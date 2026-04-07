<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\KategoriTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $templates = Template::with('kategori')->paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $templates = Template::with('kategori')
                ->where('judul', 'like', '%' . $filter . '%')
                ->paginate(10);
        }
        return view('page_admin.template.index', compact('templates', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = KategoriTemplate::all();
        return view('page_admin.template.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'link' => 'nullable|url',
            'kategori_template_id' => 'required|exists:kategori_templates,id',
        ]);

        try {
            $template = new Template($request->except('gambar'));

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';
                $path = public_path('storage/template');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80);
                $image->save($path . '/' . $gambarName);

                $template->gambar = $gambarName;
            }

            $template->save();
            return redirect()->route('admin.template.index')->with('success', 'Template berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error in TemplateController@store: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        $categories = KategoriTemplate::all();
        return view('page_admin.template.edit', compact('template', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'link' => 'nullable|url',
            'kategori_template_id' => 'required|exists:kategori_templates,id',
        ]);

        try {
            $template->fill($request->except('gambar'));

            if ($request->hasFile('gambar')) {
                if ($template->gambar && file_exists(public_path('storage/template/' . $template->gambar))) {
                    unlink(public_path('storage/template/' . $template->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';
                $path = public_path('storage/template');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80);
                $image->save($path . '/' . $gambarName);

                $template->gambar = $gambarName;
            }

            $template->save();
            return redirect()->route('admin.template.index')->with('success', 'Template berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error in TemplateController@update: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        try {
            if ($template->gambar && file_exists(public_path('storage/template/' . $template->gambar))) {
                unlink(public_path('storage/template/' . $template->gambar));
            }
            $template->delete();
            return redirect()->route('admin.template.index')->with('success', 'Template berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error in TemplateController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
