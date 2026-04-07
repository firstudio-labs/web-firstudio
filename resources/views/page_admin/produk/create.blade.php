@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Produk /</span> Tambah Produk</h4>
        
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
                        <h5 class="mb-0">Form Tambah Produk</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="judul">Judul Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                        name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul produk" />
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="master_kategori_produk_id">Kategori
                                    Produk</label>
                                <div class="col-sm-10">
                                    <select class="form-select @error('master_kategori_produk_id') is-invalid @enderror"
                                        id="master_kategori_produk_id" name="master_kategori_produk_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori_produks as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('master_kategori_produk_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->kategori_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('master_kategori_produk_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="link">Link Project (opsional)</label>
                                <div class="col-sm-10">
                                    <input
                                        type="url"
                                        class="form-control @error('link') is-invalid @enderror"
                                        id="link"
                                        name="link"
                                        value="{{ old('link') }}"
                                        placeholder="https://contohproject.com" />
                                    <small class="text-muted">Masukkan URL live project atau studi kasus.</small>
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="gambar">Gambar Produk</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*" />
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Deskripsi produk</span>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="btnGenerateDeskripsi">
                                            <i class="bx bx-bulb"></i> Generate dengan AI
                                        </button>
                                    </div>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                        name="deskripsi" rows="5"
                                        placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                        <i class="bx bx-x"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Generate Deskripsi AI -->
    <div class="modal fade" id="modalGenerateDeskripsi" tabindex="-1" aria-labelledby="modalGenerateDeskripsiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGenerateDeskripsiLabel">
                        <i class="bx bx-bulb text-primary"></i> Generate Deskripsi Produk dengan AI
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judulDeskripsi" class="form-label">Judul Produk</label>
                        <input type="text" class="form-control" id="judulDeskripsi" placeholder="Masukkan judul produk">
                        <div class="form-text">Judul produk akan digunakan untuk generate deskripsi yang relevan</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategoriDeskripsi" class="form-label">Kategori Produk (Opsional)</label>
                        <select class="form-select" id="kategoriDeskripsi">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori_produks as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->kategori_produk }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Kategori akan membantu AI generate deskripsi yang lebih spesifik</div>
                    </div>

                    <div class="mb-3">
                        <label for="customPromptDeskripsi" class="form-label">Instruksi Khusus (Opsional)</label>
                        <textarea class="form-control" id="customPromptDeskripsi" rows="3" 
                            placeholder="Contoh: Fokus pada keunggulan teknologi, target market profesional, atau aspek tertentu yang ingin ditekankan"></textarea>
                        <div class="form-text">Berikan instruksi khusus untuk customize hasil generate</div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bx bx-info-circle"></i>
                        <strong>Info:</strong> AI akan generate 3 opsi deskripsi produk 150-300 kata dalam bahasa Indonesia yang menarik dan informatif.
                    </div>
                    
                    <div id="deskripsiResults" class="mt-3" style="display:none;">
                        <h6>Pilih Deskripsi:</h6>
                        <div id="deskripsiList"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitGenerateDeskripsi">
                        <i class="bx bx-bulb"></i> Generate Deskripsi
                    </button>
                    <div id="loadingDeskripsi" class="spinner-border spinner-border-sm text-primary" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
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

        // Inisialisasi CKEditor untuk deskripsi
        let editorDeskripsi;
        ClassicEditor
            .create(document.querySelector('#deskripsi'), editorConfig)
            .then(newEditor => {
                editorDeskripsi = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Generate Deskripsi AI
        document.getElementById('btnGenerateDeskripsi').addEventListener('click', function() {
            // Pre-fill judul dari form jika sudah ada
            const judulValue = document.getElementById('judul').value;
            if (judulValue) {
                document.getElementById('judulDeskripsi').value = judulValue;
            }
            
            // Pre-fill kategori dari form jika sudah ada
            const kategoriValue = document.getElementById('master_kategori_produk_id').value;
            if (kategoriValue) {
                document.getElementById('kategoriDeskripsi').value = kategoriValue;
            }
            
            const modal = new bootstrap.Modal(document.getElementById('modalGenerateDeskripsi'));
            modal.show();
        });

        // Submit Generate Deskripsi
        document.getElementById('btnSubmitGenerateDeskripsi').addEventListener('click', function() {
            const judul = document.getElementById('judulDeskripsi').value;
            if (!judul.trim()) {
                alert('Silakan masukkan judul produk terlebih dahulu');
                return;
            }

            const btn = this;
            const loading = document.getElementById('loadingDeskripsi');
            const kategoriId = document.getElementById('kategoriDeskripsi').value;
            const customPrompt = document.getElementById('customPromptDeskripsi').value;
            
            // Show loading state
            btn.disabled = true;
            loading.style.display = 'inline-block';
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating...';
            
            // Add progress indicator
            let progressText = document.createElement('div');
            progressText.id = 'progressText';
            progressText.className = 'text-center mt-2 text-muted';
            progressText.innerHTML = 'AI sedang memproses... (biasanya 5-10 detik)';
            btn.parentNode.appendChild(progressText);
            
            // Set timeout
            const timeoutId = setTimeout(() => {
                progressText.innerHTML = 'Proses memakan waktu lebih lama dari biasanya...';
            }, 10000);

            // Create AbortController for timeout
            const controller = new AbortController();
            const timeoutId2 = setTimeout(() => {
                controller.abort();
            }, 120000); // 120 detik timeout

            fetch('{{ route("admin.produk.generate-deskripsi") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    judul: judul,
                    kategori_produk_id: kategoriId || null,
                    custom_prompt: customPrompt.trim() || null
                }),
                signal: controller.signal
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    displayDescriptions(data.descriptions);
                    // Hide generate button and show results
                    btn.style.display = 'none';
                    document.getElementById('deskripsiResults').style.display = 'block';
                    
                    // Update remaining tokens
                    if (typeof data.remaining_tokens !== 'undefined') {
                        const tokenElement = document.getElementById('aiRemainingTokens');
                        if (tokenElement) {
                            tokenElement.textContent = data.remaining_tokens;
                        }
                    }
                } else {
                    showErrorNotification((data.message || 'Gagal generate deskripsi') + ' Halaman akan di-refresh dalam 3 detik...');
                    
                    // Auto refresh halaman setelah 3 detik untuk API error
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                console.error('Error details:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                
                let errorMessage = 'Terjadi kesalahan saat generate deskripsi.';
                if (error.name === 'TypeError' && error.message.includes('JSON')) {
                    errorMessage = 'Error parsing response dari server. Coba lagi.';
                } else if (error.name === 'AbortError') {
                    errorMessage = 'Request timeout. Coba lagi.';
                } else if (error.message) {
                    errorMessage = 'Error: ' + error.message;
                }
                
                showErrorNotification(errorMessage + ' Halaman akan di-refresh otomatis dalam 3 detik...');
                
                // Auto refresh halaman setelah 3 detik
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
            .finally(() => {
                clearTimeout(timeoutId);
                clearTimeout(timeoutId2);
                btn.disabled = false;
                loading.style.display = 'none';
                btn.innerHTML = '<i class="bx bx-bulb"></i> Generate Deskripsi';
                
                // Remove progress text
                const progressText = document.getElementById('progressText');
                if (progressText) {
                    progressText.remove();
                }
            });
        });

        // Display generated descriptions
        function displayDescriptions(descriptions) {
            const deskripsiList = document.getElementById('deskripsiList');
            deskripsiList.innerHTML = '';
            
            descriptions.forEach((description, index) => {
                const deskripsiCard = document.createElement('div');
                deskripsiCard.className = 'card mb-3 deskripsi-option';
                deskripsiCard.style.cursor = 'pointer';
                
                // Create card structure
                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                
                // Create header with title and button
                const header = document.createElement('div');
                header.className = 'd-flex justify-content-between align-items-start mb-2';
                
                const title = document.createElement('h6');
                title.className = 'card-title mb-0';
                title.textContent = `Opsi ${index + 1}`;
                
                const selectBtn = document.createElement('button');
                selectBtn.type = 'button';
                selectBtn.className = 'btn btn-sm btn-outline-primary';
                selectBtn.textContent = 'Pilih';
                selectBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selectDescription(description);
                });
                
                header.appendChild(title);
                header.appendChild(selectBtn);
                
                // Create preview
                const preview = document.createElement('div');
                preview.className = 'deskripsi-preview';
                preview.style.cssText = 'max-height: 150px; overflow-y: auto; font-size: 0.9em;';
                preview.innerHTML = description;
                
                // Assemble card
                cardBody.appendChild(header);
                cardBody.appendChild(preview);
                deskripsiCard.appendChild(cardBody);
                
                // Add click handler to entire card
                deskripsiCard.addEventListener('click', function() {
                    selectDescription(description);
                });
                
                deskripsiList.appendChild(deskripsiCard);
            });
        }

        // Select description function
        function selectDescription(description) {
            console.log('Selecting description:', description);
            console.log('Editor available:', !!editorDeskripsi);
            
            try {
                // Set deskripsi ke CKEditor
                if (editorDeskripsi) {
                    editorDeskripsi.setData(description);
                    console.log('Description set to CKEditor');
                } else {
                    // Fallback ke textarea jika CKEditor belum ready
                    const textarea = document.getElementById('deskripsi');
                    if (textarea) {
                        textarea.value = description;
                        console.log('Description set to textarea');
                    } else {
                        console.error('Deskripsi textarea not found');
                    }
                }
                
                // Show success notification
                showSuccessNotification('Deskripsi berhasil dipilih!');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerateDeskripsi'));
                if (modal) {
                    modal.hide();
                }
                
                // Reset modal state
                setTimeout(() => {
                    const resultsDiv = document.getElementById('deskripsiResults');
                    const btnDiv = document.getElementById('btnSubmitGenerateDeskripsi');
                    const judulInput = document.getElementById('judulDeskripsi');
                    const kategoriInput = document.getElementById('kategoriDeskripsi');
                    const customInput = document.getElementById('customPromptDeskripsi');
                    
                    if (resultsDiv) resultsDiv.style.display = 'none';
                    if (btnDiv) btnDiv.style.display = 'inline-block';
                    if (judulInput) judulInput.value = '';
                    if (kategoriInput) kategoriInput.value = '';
                    if (customInput) customInput.value = '';
                }, 300);
                
            } catch (error) {
                console.error('Error selecting description:', error);
                showErrorNotification('Gagal memilih deskripsi: ' + error.message);
            }
        }

        // Add CSRF token meta tag if not exists
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const csrfMeta = document.createElement('meta');
            csrfMeta.name = 'csrf-token';
            csrfMeta.content = '{{ csrf_token() }}';
            document.head.appendChild(csrfMeta);
        }

        // Notification functions
        function showSuccessNotification(message) {
            // Create success notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="bx bx-check-circle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        function showErrorNotification(message) {
            // Create error notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="bx bx-error-circle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            // Auto remove after 7 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 7000);
        }
    </script>
@endsection