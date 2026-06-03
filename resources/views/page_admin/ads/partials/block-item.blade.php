<div class="block-item card border mb-3" data-index="{{ $index }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Blok #<span class="block-order-label">{{ is_numeric($index) ? (int) $index + 1 : 1 }}</span></h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-block-btn">
                <i class="bx bx-trash"></i> Hapus
            </button>
        </div>

        @if ($blockId)
            <input type="hidden" name="blocks[{{ $index }}][id]" value="{{ $blockId }}">
        @endif

        <div class="mb-3">
            <label class="form-label">Tipe Blok</label>
            <select class="form-select block-type-select" name="blocks[{{ $index }}][type]">
                <option value="image" {{ $blockType === 'image' ? 'selected' : '' }}>Gambar</option>
                <option value="button" {{ $blockType === 'button' ? 'selected' : '' }}>Tombol</option>
                <option value="youtube" {{ $blockType === 'youtube' ? 'selected' : '' }}>YouTube Embed</option>
            </select>
        </div>

        <div data-block-fields="image" style="{{ $blockType !== 'image' ? 'display:none' : '' }}">
            <label class="form-label">Gambar</label>
            @if ($imagePath)
                <input type="hidden" name="blocks[{{ $index }}][existing_image]" value="{{ $imagePath }}">
                <div class="mb-2">
                    <img src="{{ asset('storage/meta-ads/' . $imagePath) }}" alt="Preview" class="img-fluid rounded"
                        style="max-height: 200px;">
                </div>
            @endif
            <input type="file" class="form-control" name="blocks[{{ $index }}][image]" accept="image/*">
            <div class="form-text">Format: JPG, PNG, WebP. Maks. 4MB.</div>
        </div>

        <div data-block-fields="button" style="{{ $blockType !== 'button' ? 'display:none' : '' }}">
            <div class="mb-3">
                <label class="form-label">Label Tombol</label>
                <input type="text" class="form-control" name="blocks[{{ $index }}][button_label]"
                    value="{{ $buttonLabel }}" placeholder="Contoh: Hubungi via WhatsApp">
            </div>
            <div class="mb-0">
                <label class="form-label">URL Tombol</label>
                <input type="url" class="form-control" name="blocks[{{ $index }}][button_url]"
                    value="{{ $buttonUrl }}" placeholder="https://wa.me/628...">
            </div>
        </div>

        <div data-block-fields="youtube" style="{{ $blockType !== 'youtube' ? 'display:none' : '' }}">
            <label class="form-label">URL YouTube</label>
            <input type="url" class="form-control" name="blocks[{{ $index }}][youtube_url]"
                value="{{ $youtubeUrl }}" placeholder="https://www.youtube.com/watch?v=...">
            <div class="form-text">Mendukung link watch, youtu.be, atau embed.</div>
        </div>
    </div>
</div>
