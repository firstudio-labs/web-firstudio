@extends('template_admin.layout')

@section('content')
    <script>
        window.onerror = function (msg, url, lineNo, columnNo, error) {
            console.error('Error: ' + msg + '\nURL: ' + url + '\nLine: ' + lineNo + '\nColumn: ' + columnNo + '\nError object: ' + JSON.stringify(error));
            return false;
        };
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Artikel /</span> Tambah Artikel</h4>
        @auth
        <div class="mb-3">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="bx bx-bolt me-1"></i>
                    Token AI hari ini: <strong>{{ $aiDailyLimit - $aiRemainingTokens }}/{{ $aiDailyLimit }}</strong> terpakai
                    | Sisa: <strong id="aiRemainingTokens">{{ $aiRemainingTokens }}</strong>
                </div>
                <span class="badge bg-{{ $aiRemainingTokens > 0 ? 'success' : 'secondary' }}">{{ $aiRemainingTokens }} tersisa</span>
            </div>
        </div>
        @endauth

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Tambah Artikel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data"
                            id="formArtikel">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <div class="d-flex gap-2 mb-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm ai-feature-btn" id="btnGenerateTitles" title="Generate judul artikel dari topik" {{ ($aiRemainingTokens ?? 0) <= 0 ? 'disabled' : '' }}>
                                                <i class="bx bx-bulb"></i> Generate Judul
                                            </button>
                                        </div>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="penulis" class="form-label">Penulis</label>
                                        <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                            id="penulis" name="penulis" value="{{ old('penulis') }}" required>
                                        @error('penulis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kategori_artikel_id" class="form-label">Kategori</label>
                                        <select class="form-select @error('kategori_artikel_id') is-invalid @enderror"
                                            id="kategori_artikel_id" name="kategori_artikel_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoriArtikels as $kategori)
                                                <option value="{{ $kategori->id }}" {{ old('kategori_artikel_id') == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->kategori_artikel }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_artikel_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            id="gambar" name="gambar" accept="image/*" required>
                                        <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 2MB</small>
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="isi" class="form-label">Isi</label>
                                        <div class="d-flex gap-2 mb-2">
                                            <button type="button" class="btn btn-outline-success btn-sm ai-feature-btn" id="btnGenerateAI" title="Generate isi artikel dengan AI" {{ ($aiRemainingTokens ?? 0) <= 0 ? 'disabled' : '' }}>
                                                <i class="bx bx-brain"></i> Generate dengan AI
                                            </button>
                                        </div>
                                        <textarea class="form-control @error('isi') is-invalid @enderror" id="isi"
                                            name="isi">{{ old('isi') }}</textarea>
                                        <small class="text-muted">Tip: Isi judul dan kategori terlebih dahulu, lalu klik "Generate dengan AI" untuk membuat konten otomatis</small>
                                        @error('isi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                        <input type="text" class="form-control @error('catatan') is-invalid @enderror"
                                            id="catatan" name="catatan" value="{{ old('catatan') }}">
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Publik" {{ old('status') == 'Publik' ? 'selected' : '' }}>Publik
                                            </option>
                                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Preview Artikel</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="preview-container" class="article-preview">
                                                <div class="article-header mb-4">
                                                    <h1 id="preview-judul" class="article-title mb-3"></h1>
                                                </div>
                                                <div id="preview-gambar" class="article-image mb-4"></div>
                                                <div class="article-meta text-muted mb-3">
                                                    <span class="me-3">
                                                        <i class="bx bx-user"></i>
                                                        <span id="preview-penulis"></span>
                                                    </span>
                                                    <span class="me-3">
                                                        <i class="bx bx-category"></i>
                                                        <span id="preview-kategori"></span>
                                                    </span>
                                                </div>
                                                <div id="preview-isi" class="article-content" style="text-align: justify;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" id="btnSimpan">
                                    <i class="bx bx-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                                    <i class="bx bx-x"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Generate Judul -->
    <div class="modal fade" id="modalGenerateTitles" tabindex="-1" aria-labelledby="modalGenerateTitlesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGenerateTitlesLabel">
                        <i class="bx bx-bulb"></i> Generate Judul Artikel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formGenerateTitles">
                        <div class="mb-3">
                            <label for="topikTitles" class="form-label">Topik Artikel</label>
                            <input type="text" class="form-control" id="topikTitles" placeholder="Masukkan topik artikel, misal: Teknologi AI, Digital Marketing, dll">
                            <small class="text-muted">Contoh: "Artificial Intelligence", "Digital Marketing Strategy", "Web Development"</small>
                        </div>
                        <div class="mb-3">
                            <label for="kategoriTitles" class="form-label">Kategori (Opsional)</label>
                            <select class="form-select" id="kategoriTitles">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriArtikels as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori_artikel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div id="titleResults" class="mt-3" style="display:none;">
                        <h6>Pilih Judul:</h6>
                        <div id="titlesList"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitGenerateTitles">
                        <i class="bx bx-loader-alt bx-spin" id="loadingTitles" style="display:none;"></i>
                        Generate Judul
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Generate AI Content -->
    <div class="modal fade" id="modalGenerateAI" tabindex="-1" aria-labelledby="modalGenerateAILabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGenerateAILabel">
                        <i class="bx bx-brain"></i> Generate Konten dengan AI
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle"></i>
                        AI akan membuat konten artikel berdasarkan judul dan kategori yang sudah Anda isi.
                    </div>
                    <div class="mb-3">
                        <label for="minWords" class="form-label">Minimal Kata</label>
                        <select class="form-select" id="minWords">
                            <option value="300">300 kata (Pendek)</option>
                            <option value="500" selected>500 kata (Sedang)</option>
                            <!-- <option value="800">800 kata (Panjang)</option>
                            <option value="1200">1200 kata (Sangat Panjang)</option> -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customPrompt" class="form-label">Brief/Prompt Artikel <span class="text-muted">(Opsional)</span></label>
                        <textarea class="form-control" id="customPrompt" rows="3" 
                                  placeholder="Contoh: Fokus pada manfaat untuk pelajar, sertakan tips praktis, gunakan bahasa yang mudah dipahami..."></textarea>
                        <div class="form-text">
                            <i class="bx bx-info-circle"></i> 
                            Berikan instruksi spesifik untuk AI agar artikel sesuai kebutuhan Anda
                        </div>
                    </div>
                    <small class="text-muted">
                        <strong>Catatan:</strong> Proses generate mungkin membutuhkan waktu 10-30 detik. Pastikan koneksi internet stabil.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="btnSubmitGenerateAI">
                        <i class="bx bx-loader-alt bx-spin" id="loadingAI" style="display:none;"></i>
                        Generate Konten
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <style>
        .article-preview {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        .article-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .article-meta {
            font-size: 0.9rem;
        }

        .article-meta i {
            margin-right: 5px;
        }

        .article-image img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .article-content {
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin: 2rem 0 1rem;
            color: #2c3e50;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .article-content blockquote {
            border-left: 4px solid #3498db;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #666;
        }

        /* Tambahan untuk list agar preview numbering dan bulleted list tampil rapi */
        .article-content ul {
            list-style-type: disc;
            margin-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .article-content ol {
            list-style-type: decimal;
            margin-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        /* AI Features Styling */
        .title-option:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
        }

        .ai-loading {
            animation: pulse 1.5s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            from { opacity: 0.6; }
            to { opacity: 1; }
        }

        .ai-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .ai-feature-btn {
            transition: all 0.3s ease;
        }

        .ai-feature-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
    <script>
        // Konfigurasi CKEditor dengan toolbar lengkap
        const editorConfig = {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'insertTable', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
        };

        // Inisialisasi CKEditor
        let editor;
        ClassicEditor
            .create(document.querySelector('#isi'), editorConfig)
            .then(newEditor => {
                editor = newEditor;
                editor.model.document.on('change:data', () => {
                    document.getElementById('preview-isi').innerHTML = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });

        // Form submission handling
        document.getElementById('formArtikel').addEventListener('submit', function (e) {
            e.preventDefault();

            // Validasi form
            const judul = document.getElementById('judul').value;
            const penulis = document.getElementById('penulis').value;
            const kategori = document.getElementById('kategori_artikel_id').value;
            const gambar = document.getElementById('gambar').files[0];
            const isi = editor.getData();
            const status = document.getElementById('status').value;

            if (!judul || !penulis || !kategori || !gambar || !isi || !status) {
                alert('Mohon lengkapi semua field yang wajib diisi');
                return;
            }

            if (!isi) {
                alert('Mohon isi konten artikel!');
                return;
            }

            // Tampilkan loading state
            const btnSimpan = document.getElementById('btnSimpan');
            const originalText = btnSimpan.innerHTML;
            btnSimpan.disabled = true;
            btnSimpan.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';

            // Submit form
            this.submit();
        });

        // Preview untuk judul
        document.getElementById('judul').addEventListener('input', function () {
            document.getElementById('preview-judul').textContent = this.value;
        });

        // Preview untuk penulis
        document.getElementById('penulis').addEventListener('input', function () {
            document.getElementById('preview-penulis').textContent = this.value;
        });

        // Preview untuk kategori
        document.getElementById('kategori_artikel_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('preview-kategori').textContent = selectedOption.text;
        });

        // Preview untuk gambar
        document.getElementById('gambar').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid';
                    const previewDiv = document.getElementById('preview-gambar');
                    previewDiv.innerHTML = '';
                    previewDiv.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });

        // === AI FEATURES ===
        
        // Generate Titles Modal
        document.getElementById('btnGenerateTitles').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalGenerateTitles'));
            modal.show();
        });

        // Generate AI Content Modal
        document.getElementById('btnGenerateAI').addEventListener('click', function() {
            const judul = document.getElementById('judul').value;
            if (!judul.trim()) {
                alert('Silakan isi judul terlebih dahulu untuk generate konten AI');
                return;
            }
            const modal = new bootstrap.Modal(document.getElementById('modalGenerateAI'));
            modal.show();
        });

        // Submit Generate Titles
        document.getElementById('btnSubmitGenerateTitles').addEventListener('click', function() {
            const topik = document.getElementById('topikTitles').value;
            if (!topik.trim()) {
                alert('Silakan masukkan topik terlebih dahulu');
                return;
            }

            const btn = this;
            const loading = document.getElementById('loadingTitles');
            const kategoriId = document.getElementById('kategoriTitles').value;
            
            // Show loading state
            btn.disabled = true;
            loading.style.display = 'inline-block';
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating...';

            fetch('{{ route("admin.artikel.generate-titles") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    topik: topik,
                    kategori_artikel_id: kategoriId || null
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayTitles(data.titles);
                    // Hide generate button and show results
                    btn.style.display = 'none';
                    document.getElementById('titleResults').style.display = 'block';
                } else {
                    showErrorNotification((data.message || 'Gagal generate judul') + ' Halaman akan di-refresh dalam 3 detik...');
                    
                    // Auto refresh halaman setelah 3 detik untuk API error
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorNotification('Terjadi kesalahan saat generate judul. Halaman akan di-refresh otomatis dalam 3 detik...');
                
                // Auto refresh halaman setelah 3 detik
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
            .finally(() => {
                btn.disabled = false;
                loading.style.display = 'none';
                btn.innerHTML = '<i class="bx bx-bulb"></i> Generate Judul';
            });
        });

        // Display generated titles
        function displayTitles(titles) {
            const titlesList = document.getElementById('titlesList');
            titlesList.innerHTML = '';
            
            titles.forEach((title, index) => {
                const titleCard = document.createElement('div');
                titleCard.className = 'card mb-2 title-option';
                titleCard.style.cursor = 'pointer';
                titleCard.innerHTML = `
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${title}</span>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectTitle('${title.replace(/'/g, "\\'")}')">
                                Pilih
                            </button>
                        </div>
                    </div>
                `;
                titlesList.appendChild(titleCard);
            });
        }

        // Select title function
        function selectTitle(title) {
            document.getElementById('judul').value = title;
            document.getElementById('preview-judul').textContent = title;
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerateTitles'));
            modal.hide();
            
            // Reset modal state
            setTimeout(() => {
                document.getElementById('titleResults').style.display = 'none';
                document.getElementById('btnSubmitGenerateTitles').style.display = 'inline-block';
                document.getElementById('topikTitles').value = '';
                document.getElementById('kategoriTitles').value = '';
            }, 300);
        }

        // Submit Generate AI Content
        document.getElementById('btnSubmitGenerateAI').addEventListener('click', function() {
            const judul = document.getElementById('judul').value;
            const kategoriId = document.getElementById('kategori_artikel_id').value;
            const minWords = document.getElementById('minWords').value;
            const customPrompt = document.getElementById('customPrompt').value;

            if (!judul.trim()) {
                alert('Silakan isi judul terlebih dahulu');
                return;
            }

            const btn = this;
            const loading = document.getElementById('loadingAI');
            
            // Show loading state
            btn.disabled = true;
            loading.style.display = 'inline-block';
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating...';

            fetch('{{ route("admin.artikel.generate-ai") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    judul: judul,
                    kategori_artikel_id: kategoriId || null,
                    min_words: parseInt(minWords),
                    custom_prompt: customPrompt.trim() || null
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Set content to CKEditor
                    editor.setData(data.content);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerateAI'));
                    modal.hide();
                    
                    // Show success message
                    showSuccessNotification(`Konten berhasil di-generate! (${data.word_count} kata)`);
                    if (typeof data.remaining_tokens !== 'undefined') {
                        const el = document.getElementById('aiRemainingTokens');
                        if (el) el.textContent = data.remaining_tokens;
                        // Disable buttons when no tokens left
                        if (data.remaining_tokens <= 0) {
                            document.getElementById('btnGenerateAI')?.setAttribute('disabled', 'disabled');
                            document.getElementById('btnGenerateTitles')?.setAttribute('disabled', 'disabled');
                        }
                    }
                } else {
                    showErrorNotification((data.message || 'Gagal generate konten') + ' Halaman akan di-refresh dalam 3 detik...');
                    
                    // Auto refresh halaman setelah 3 detik untuk API error
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorNotification('Terjadi kesalahan saat generate konten. Halaman akan di-refresh otomatis dalam 3 detik...');
                
                // Auto refresh halaman setelah 3 detik
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
            .finally(() => {
                btn.disabled = false;
                loading.style.display = 'none';
                btn.innerHTML = '<i class="bx bx-brain"></i> Generate Konten';
            });
        });

        // Add CSRF token meta tag if not exists
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const csrfMeta = document.createElement('meta');
            csrfMeta.name = 'csrf-token';
            csrfMeta.content = '{{ csrf_token() }}';
            document.head.appendChild(csrfMeta);
        }

        // Notification functions
        function showSuccessNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
            notification.innerHTML = `
                <i class="bx bx-check-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }

        function showErrorNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
            notification.innerHTML = `
                <i class="bx bx-error-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 8 seconds (longer for error messages)
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 8000);
        }

        function showRetryNotification(message, retryFn) {
            // Create retry notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-warning alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
            notification.innerHTML = `
                <i class="bx bx-loader-alt bx-spin me-2"></i>
                ${message}
                <button type="button" class="btn btn-sm btn-outline-dark ms-2" onclick="this.closest('.alert').remove();">
                    Batal
                </button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 10 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 10000);
        }
    </script>
@endsection