<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Support\MetaAdsTheme;
use App\Models\MetaAdsBlock;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MetaAdsController extends Controller
{
    public function edit()
    {
        $blocks = MetaAdsBlock::ordered()->get();

        $settings = [
            'meta_pixel_id' => Setting::where('key', 'meta_pixel_id')->value('value'),
            'meta_pixel_enabled' => Setting::where('key', 'meta_pixel_enabled')->value('value') === '1',
            'meta_pixel_scope' => Setting::where('key', 'meta_pixel_scope')->value('value') ?? 'ads_only',
            'meta_ads_page_title' => Setting::where('key', 'meta_ads_page_title')->value('value') ?? 'Firstudio',
            'meta_ads_page_description' => Setting::where('key', 'meta_ads_page_description')->value('value'),
            'meta_ads_bg_color' => Setting::where('key', 'meta_ads_bg_color')->value('value') ?? MetaAdsTheme::DEFAULT_BG,
            'meta_ads_button_color' => Setting::where('key', 'meta_ads_button_color')->value('value') ?? MetaAdsTheme::DEFAULT_BUTTON,
            'meta_ads_text_color' => Setting::where('key', 'meta_ads_text_color')->value('value') ?? MetaAdsTheme::DEFAULT_TEXT,
        ];

        return view('page_admin.ads.edit', compact('blocks', 'settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'meta_pixel_id' => 'nullable|string|max:32',
            'meta_pixel_scope' => 'nullable|in:ads_only,site_wide',
            'meta_ads_page_title' => 'nullable|string|max:255',
            'meta_ads_page_description' => 'nullable|string|max:500',
            'meta_ads_bg_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'meta_ads_button_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'meta_ads_text_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'blocks' => 'nullable|array',
            'blocks.*.type' => 'required_with:blocks|in:image,button,youtube',
            'blocks.*.button_label' => 'nullable|string|max:255',
            'blocks.*.button_url' => 'nullable|url|max:2048',
            'blocks.*.youtube_url' => 'nullable|url|max:2048',
            'blocks.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $blocksInput = $request->input('blocks', []);

        foreach ($blocksInput as $index => $blockData) {
            $type = $blockData['type'] ?? null;

            if ($type === MetaAdsBlock::TYPE_BUTTON) {
                if (empty($blockData['button_label']) || empty($blockData['button_url'])) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Blok tombol #' . ($index + 1) . ' wajib diisi label dan URL.');
                }
            }

            if ($type === MetaAdsBlock::TYPE_YOUTUBE) {
                $url = $blockData['youtube_url'] ?? '';
                if (empty($url) || ! YoutubeHelper::extractVideoId($url)) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Blok YouTube #' . ($index + 1) . ' memerlukan URL YouTube yang valid.');
                }
            }

            if ($type === MetaAdsBlock::TYPE_IMAGE) {
                $hasFile = $request->hasFile("blocks.{$index}.image");
                $hasExisting = ! empty($blockData['existing_image']);
                if (! $hasFile && ! $hasExisting) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Blok gambar #' . ($index + 1) . ' wajib memiliki gambar.');
                }
            }
        }

        try {
            DB::transaction(function () use ($request, $blocksInput) {
                $this->saveSettings($request);

                $keptIds = [];
                foreach ($blocksInput as $index => $blockData) {
                    $block = null;
                    if (! empty($blockData['id'])) {
                        $block = MetaAdsBlock::find($blockData['id']);
                    }

                    if (! $block) {
                        $block = new MetaAdsBlock();
                    }

                    $block->type = $blockData['type'];
                    $block->sort_order = $index;
                    $block->is_active = true;
                    $block->button_label = null;
                    $block->button_url = null;
                    $block->youtube_url = null;

                    if ($block->type === MetaAdsBlock::TYPE_IMAGE) {
                        if ($request->hasFile("blocks.{$index}.image")) {
                            if ($block->image_path) {
                                $this->deleteImageFile($block->image_path);
                            }
                            $block->image_path = $this->storeImage($request->file("blocks.{$index}.image"));
                        } elseif (! empty($blockData['existing_image'])) {
                            $block->image_path = $blockData['existing_image'];
                        }
                    } else {
                        if ($block->image_path) {
                            $this->deleteImageFile($block->image_path);
                        }
                        $block->image_path = null;
                    }

                    if ($block->type === MetaAdsBlock::TYPE_BUTTON) {
                        $block->button_label = $blockData['button_label'];
                        $block->button_url = $blockData['button_url'];
                    }

                    if ($block->type === MetaAdsBlock::TYPE_YOUTUBE) {
                        $block->youtube_url = $blockData['youtube_url'];
                    }

                    $block->save();
                    $keptIds[] = $block->id;
                }

                $toDelete = empty($keptIds)
                    ? MetaAdsBlock::all()
                    : MetaAdsBlock::whereNotIn('id', $keptIds)->get();
                foreach ($toDelete as $old) {
                    if ($old->image_path) {
                        $this->deleteImageFile($old->image_path);
                    }
                    $old->delete();
                }
            });

            return redirect()->route('admin.ads.edit')->with('success', 'Halaman Meta Ads berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Meta Ads update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    private function saveSettings(Request $request): void
    {
        Setting::updateOrCreate(
            ['key' => 'meta_pixel_id'],
            ['value' => $request->input('meta_pixel_id', '')]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_pixel_enabled'],
            ['value' => $request->input('meta_pixel_enabled') === '1' ? '1' : '0']
        );

        Setting::updateOrCreate(
            ['key' => 'meta_pixel_scope'],
            ['value' => $request->input('meta_pixel_scope', 'ads_only')]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_ads_page_title'],
            ['value' => $request->input('meta_ads_page_title', 'Firstudio')]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_ads_page_description'],
            ['value' => $request->input('meta_ads_page_description', '')]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_ads_bg_color'],
            ['value' => MetaAdsTheme::normalizeHex(
                $request->input('meta_ads_bg_color'),
                MetaAdsTheme::DEFAULT_BG
            )]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_ads_button_color'],
            ['value' => MetaAdsTheme::normalizeHex(
                $request->input('meta_ads_button_color'),
                MetaAdsTheme::DEFAULT_BUTTON
            )]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_ads_text_color'],
            ['value' => MetaAdsTheme::normalizeHex(
                $request->input('meta_ads_text_color'),
                MetaAdsTheme::DEFAULT_TEXT
            )]
        );
    }

    private function storeImage($file): string
    {
        $isWebpSupported = function_exists('imagewebp');
        $extension = $isWebpSupported ? 'webp' : 'jpg';
        $filename = time() . '_' . uniqid() . '.' . $extension;

        $path = public_path('storage/meta-ads');
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        if ($isWebpSupported) {
            $image->toWebp(80);
        } else {
            $image->toJpeg(80);
        }

        $image->save($path . '/' . $filename);

        return $filename;
    }

    private function deleteImageFile(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $fullPath = public_path('storage/meta-ads/' . $filename);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
