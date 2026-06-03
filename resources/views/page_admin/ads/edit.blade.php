@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Konten /</span> Meta Ads</h4>
            <a href="{{ route('web.ads.index') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="bx bx-link-external me-1"></i> Lihat /ads
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data" id="meta-ads-form">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Pengaturan Halaman & Meta Pixel</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="meta_ads_page_title">Judul Halaman</label>
                            <input type="text" class="form-control" id="meta_ads_page_title" name="meta_ads_page_title"
                                value="{{ old('meta_ads_page_title', $settings['meta_ads_page_title']) }}"
                                placeholder="Firstudio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="meta_ads_page_description">Deskripsi (SEO)</label>
                            <input type="text" class="form-control" id="meta_ads_page_description"
                                name="meta_ads_page_description"
                                value="{{ old('meta_ads_page_description', $settings['meta_ads_page_description']) }}"
                                placeholder="Opsional">
                        </div>
                    </div>

                    <h6 class="text-muted mb-3">Tampilan Halaman</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="meta_ads_bg_color">Background</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" class="form-control form-control-color" id="meta_ads_bg_color"
                                    name="meta_ads_bg_color"
                                    value="{{ old('meta_ads_bg_color', $settings['meta_ads_bg_color']) }}">
                                <input type="text" class="form-control form-control-sm color-hex-input"
                                    data-color-for="meta_ads_bg_color"
                                    value="{{ old('meta_ads_bg_color', $settings['meta_ads_bg_color']) }}"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" maxlength="7">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="meta_ads_button_color">Warna Tombol</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" class="form-control form-control-color" id="meta_ads_button_color"
                                    name="meta_ads_button_color"
                                    value="{{ old('meta_ads_button_color', $settings['meta_ads_button_color']) }}">
                                <input type="text" class="form-control form-control-sm color-hex-input"
                                    data-color-for="meta_ads_button_color"
                                    value="{{ old('meta_ads_button_color', $settings['meta_ads_button_color']) }}"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" maxlength="7">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="meta_ads_text_color">Warna Teks</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" class="form-control form-control-color" id="meta_ads_text_color"
                                    name="meta_ads_text_color"
                                    value="{{ old('meta_ads_text_color', $settings['meta_ads_text_color']) }}">
                                <input type="text" class="form-control form-control-sm color-hex-input"
                                    data-color-for="meta_ads_text_color"
                                    value="{{ old('meta_ads_text_color', $settings['meta_ads_text_color']) }}"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" maxlength="7">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preview</label>
                        <div id="meta-ads-color-preview" class="rounded border p-4 text-center"
                            style="background-color: {{ old('meta_ads_bg_color', $settings['meta_ads_bg_color']) }}; color: {{ old('meta_ads_text_color', $settings['meta_ads_text_color']) }};">
                            <p class="mb-3 small">Contoh teks pada halaman /ads</p>
                            <span id="meta-ads-preview-btn" class="d-inline-block px-4 py-2 rounded fw-semibold"
                                style="background-color: {{ old('meta_ads_button_color', $settings['meta_ads_button_color']) }}; color: {{ old('meta_ads_text_color', $settings['meta_ads_text_color']) }};">
                                Tombol CTA
                            </span>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="meta_pixel_id">Meta Pixel ID</label>
                            <input type="text" class="form-control" id="meta_pixel_id" name="meta_pixel_id"
                                value="{{ old('meta_pixel_id', $settings['meta_pixel_id']) }}"
                                placeholder="Contoh: 123456789012345">
                            <div class="form-text">ID numerik dari Events Manager Facebook.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Status Pixel</label>
                            <input type="hidden" name="meta_pixel_enabled" value="0">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="meta_pixel_enabled"
                                    name="meta_pixel_enabled" value="1"
                                    {{ old('meta_pixel_enabled', $settings['meta_pixel_enabled'] ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="meta_pixel_enabled">Aktifkan Meta Pixel</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cakupan Pixel</label>
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="meta_pixel_scope" id="scope_ads"
                                        value="ads_only"
                                        {{ old('meta_pixel_scope', $settings['meta_pixel_scope']) === 'ads_only' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="scope_ads">Hanya halaman /ads</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="meta_pixel_scope" id="scope_site"
                                        value="site_wide"
                                        {{ old('meta_pixel_scope', $settings['meta_pixel_scope']) === 'site_wide' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="scope_site">Seluruh situs publik</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Blok Konten (urutan atas ke bawah)</h5>
                    <button type="button" class="btn btn-sm btn-primary" id="add-block-btn">
                        <i class="bx bx-plus me-1"></i> Tambah Blok
                    </button>
                </div>
                <div class="card-body">
                    <div id="blocks-container">
                        @php
                            $oldBlocks = old('blocks');
                            $renderBlocks = $oldBlocks ? collect(array_values($oldBlocks)) : $blocks;
                        @endphp
                        @forelse ($renderBlocks as $index => $block)
                            @php
                                $blockId = is_object($block) ? $block->id : ($block['id'] ?? null);
                                $blockType = is_object($block) ? $block->type : ($block['type'] ?? 'image');
                                $imagePath = is_object($block) ? $block->image_path : ($block['existing_image'] ?? $block['image_path'] ?? null);
                                $buttonLabel = is_object($block) ? $block->button_label : ($block['button_label'] ?? '');
                                $buttonUrl = is_object($block) ? $block->button_url : ($block['button_url'] ?? '');
                                $youtubeUrl = is_object($block) ? $block->youtube_url : ($block['youtube_url'] ?? '');
                            @endphp
                            @include('page_admin.ads.partials.block-item', [
                                'index' => $index,
                                'blockId' => $blockId,
                                'blockType' => $blockType,
                                'imagePath' => $imagePath,
                                'buttonLabel' => $buttonLabel,
                                'buttonUrl' => $buttonUrl,
                                'youtubeUrl' => $youtubeUrl,
                            ])
                        @empty
                        @endforelse
                    </div>
                    <p class="text-muted small mb-0 mt-3" id="blocks-empty-hint"
                        style="{{ $renderBlocks->count() > 0 ? 'display:none' : '' }}">
                        Belum ada blok. Klik &quot;Tambah Blok&quot; untuk memulai.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save me-1"></i> Simpan
            </button>
        </form>
    </div>

    <template id="block-item-template">
        @include('page_admin.ads.partials.block-item', [
            'index' => '__INDEX__',
            'blockId' => null,
            'blockType' => 'image',
            'imagePath' => null,
            'buttonLabel' => '',
            'buttonUrl' => '',
            'youtubeUrl' => '',
        ])
    </template>
@endsection

@section('scripts')
    <script>
        (function () {
            function syncColorPair(colorInput, hexInput) {
                if (!colorInput || !hexInput) return;
                colorInput.addEventListener('input', function () {
                    hexInput.value = colorInput.value;
                    updateColorPreview();
                });
                hexInput.addEventListener('input', function () {
                    if (/^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
                        colorInput.value = hexInput.value;
                        updateColorPreview();
                    }
                });
                hexInput.addEventListener('change', function () {
                    if (/^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
                        colorInput.value = hexInput.value;
                    }
                    updateColorPreview();
                });
            }

            function updateColorPreview() {
                var preview = document.getElementById('meta-ads-color-preview');
                var btn = document.getElementById('meta-ads-preview-btn');
                var bg = document.getElementById('meta_ads_bg_color');
                var button = document.getElementById('meta_ads_button_color');
                var text = document.getElementById('meta_ads_text_color');
                if (!preview || !bg || !button || !text) return;
                preview.style.backgroundColor = bg.value;
                preview.style.color = text.value;
                if (btn) {
                    btn.style.backgroundColor = button.value;
                    btn.style.color = text.value;
                }
            }

            document.querySelectorAll('.color-hex-input').forEach(function (hexInput) {
                var id = hexInput.getAttribute('data-color-for');
                var colorInput = document.getElementById(id);
                syncColorPair(colorInput, hexInput);
            });

            var container = document.getElementById('blocks-container');
            var template = document.getElementById('block-item-template');
            var addBtn = document.getElementById('add-block-btn');
            var emptyHint = document.getElementById('blocks-empty-hint');
            var blockIndex = container.querySelectorAll('.block-item').length;

            function toggleEmptyHint() {
                if (!emptyHint) return;
                emptyHint.style.display = container.querySelectorAll('.block-item').length ? 'none' : '';
            }

            function bindBlockItem(item) {
                var typeSelect = item.querySelector('.block-type-select');
                var fields = item.querySelectorAll('[data-block-fields]');

                function updateFields() {
                    var type = typeSelect.value;
                    fields.forEach(function (el) {
                        el.style.display = el.getAttribute('data-block-fields') === type ? '' : 'none';
                    });
                }

                typeSelect.addEventListener('change', updateFields);
                updateFields();

                item.querySelector('.remove-block-btn').addEventListener('click', function () {
                    item.remove();
                    reindexBlocks();
                    toggleEmptyHint();
                });
            }

            function reindexBlocks() {
                container.querySelectorAll('.block-item').forEach(function (item, i) {
                    item.setAttribute('data-index', i);
                    item.querySelector('.block-order-label').textContent = i + 1;
                    item.querySelectorAll('[name^="blocks["]').forEach(function (input) {
                        input.name = input.name.replace(/blocks\[\d+\]/, 'blocks[' + i + ']');
                    });
                });
                blockIndex = container.querySelectorAll('.block-item').length;
            }

            container.querySelectorAll('.block-item').forEach(bindBlockItem);
            toggleEmptyHint();

            addBtn.addEventListener('click', function () {
                var html = template.innerHTML.replace(/__INDEX__/g, blockIndex);
                var wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();
                var item = wrapper.firstElementChild;
                container.appendChild(item);
                bindBlockItem(item);
                blockIndex++;
                toggleEmptyHint();
            });
        })();
    </script>
@endsection
