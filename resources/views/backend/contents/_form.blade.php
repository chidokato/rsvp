@csrf

@php
    $currentImage = old('existing_image', $post->image ?? '');
    $imagePreview = $currentImage ? asset($currentImage) : '';
    $existingGalleryImages = $galleryImages ?? collect();
@endphp

<div class="row">
    <div class="col-xl-9">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tieu de</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug ?? '') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="summary" class="form-label">Mo ta ngan</label>
                            <textarea id="summary" name="summary" rows="3" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $post->summary ?? '') }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if ($type === 'product')
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Dia chi</label>
                                <textarea id="address" name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $post->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dien tich (m2)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" step="0.01" min="0" id="area_from" name="area_from" class="form-control @error('area_from') is-invalid @enderror" value="{{ old('area_from', $post->area_from ?? $post->area ?? '') }}" placeholder="Tu">
                                        @error('area_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" step="0.01" min="0" id="area_to" name="area_to" class="form-control @error('area_to') is-invalid @enderror" value="{{ old('area_to', $post->area_to ?? $post->area ?? '') }}" placeholder="Den">
                                        @error('area_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">So tang</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" min="0" id="floor_count_from" name="floor_count_from" class="form-control @error('floor_count_from') is-invalid @enderror" value="{{ old('floor_count_from', $post->floor_count_from ?? $post->floor_count ?? '') }}" placeholder="Tu">
                                        @error('floor_count_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" id="floor_count_to" name="floor_count_to" class="form-control @error('floor_count_to') is-invalid @enderror" value="{{ old('floor_count_to', $post->floor_count_to ?? $post->floor_count ?? '') }}" placeholder="Den">
                                        @error('floor_count_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">So can</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" min="0" id="unit_count_from" name="unit_count_from" class="form-control @error('unit_count_from') is-invalid @enderror" value="{{ old('unit_count_from', $post->unit_count_from ?? $post->unit_count ?? '') }}" placeholder="Tu">
                                        @error('unit_count_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" id="unit_count_to" name="unit_count_to" class="form-control @error('unit_count_to') is-invalid @enderror" value="{{ old('unit_count_to', $post->unit_count_to ?? $post->unit_count ?? '') }}" placeholder="Den">
                                        @error('unit_count_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">So phong ngu</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" min="0" id="bedroom_count_from" name="bedroom_count_from" class="form-control @error('bedroom_count_from') is-invalid @enderror" value="{{ old('bedroom_count_from', $post->bedroom_count_from ?? $post->bedroom_count ?? '') }}" placeholder="Tu">
                                        @error('bedroom_count_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" id="bedroom_count_to" name="bedroom_count_to" class="form-control @error('bedroom_count_to') is-invalid @enderror" value="{{ old('bedroom_count_to', $post->bedroom_count_to ?? $post->bedroom_count ?? '') }}" placeholder="Den">
                                        @error('bedroom_count_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">So WC</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" min="0" id="bathroom_count_from" name="bathroom_count_from" class="form-control @error('bathroom_count_from') is-invalid @enderror" value="{{ old('bathroom_count_from', $post->bathroom_count_from ?? $post->bathroom_count ?? '') }}" placeholder="Tu">
                                        @error('bathroom_count_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" id="bathroom_count_to" name="bathroom_count_to" class="form-control @error('bathroom_count_to') is-invalid @enderror" value="{{ old('bathroom_count_to', $post->bathroom_count_to ?? $post->bathroom_count ?? '') }}" placeholder="Den">
                                        @error('bathroom_count_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="mb-0">
                            <label for="content" class="form-label">Noi dung</label>
                            <textarea id="content" name="content" rows="8" class="form-control editor @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border">
            <div class="card-header">
                <h5 class="card-title mb-0">Cau hinh SEO</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="seo_title" class="form-label">Title</label>
                            <input type="text" id="seo_title" name="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $post->seo_title ?? '') }}" placeholder="Nhap SEO title">
                            @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="seo_description" class="form-label">Description</label>
                            <textarea id="seo_description" name="seo_description" rows="3" class="form-control @error('seo_description') is-invalid @enderror" placeholder="Nhap SEO description">{{ old('seo_description', $post->seo_description ?? '') }}</textarea>
                            @error('seo_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="form-label mb-0">Hien thi</label>
                            </div>
                            <div class="col-lg-10">
                                <div id="seo-link-preview" class="text-muted">{{ url('/') }}/san-pham/slug</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card border">
            <div class="card-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Khong chon</option>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" {{ (string) old('category_id', $post->category_id ?? '') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-12 {{ $type === 'product' ? 'mb-3' : '' }}">
                        <div class="mb-3">
                            <label for="published_at" class="form-label">Ngay dang</label>
                            <input type="datetime-local" id="published_at" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\\TH:i') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if ($type === 'product')
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">Gia</label>
                                <input type="number" step="0.01" min="0" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $post->price ?? '') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card border mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Hinh anh</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="existing_image" value="{{ $currentImage }}">
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                        <input type="file" id="image_file" name="image_file" class="d-none" accept="image/*">
                        @if ($type === 'product')
                            <input type="file" id="gallery_files" name="gallery_files[]" class="d-none" accept="image/*" multiple>
                        @endif

                        <div class="d-flex flex-column gap-2">
                            <button type="button" id="image-preview-box" class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden p-0 w-100" style="height: 205px;">
                                <img id="image-preview" src="{{ $imagePreview }}" alt="Preview" class="w-100 h-100 object-fit-cover {{ $imagePreview ? '' : 'd-none' }}">
                                <div id="image-placeholder" class="text-center text-muted px-3 {{ $imagePreview ? 'd-none' : '' }}">
                                    <div class="display-6 mb-2">
                                        <i class="ri-image-line"></i>
                                    </div>
                                    <div class="fw-semibold">NO IMAGE</div>
                                    <div>Click hoac drop anh vao day</div>
                                </div>
                            </button>
                            <button type="button" id="remove-image-trigger" class="btn btn-soft-danger btn-sm align-self-start {{ $imagePreview ? '' : 'd-none' }}">Bo anh dai dien</button>
                        </div>

                        @error('image_file')
                            <div class="text-danger small mt-3">{{ $message }}</div>
                        @enderror

                        @if ($type === 'product')
                            @error('gallery_files.*')
                                <div class="text-danger small mt-3">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <div id="gallery-preview-grid" class="d-flex align-items-start gap-2 flex-wrap">
                                    @foreach ($existingGalleryImages as $galleryImage)
                                        <div class="position-relative border rounded overflow-hidden bg-light gallery-item" data-gallery-item style="width: 72px; height: 72px;">
                                            <img src="{{ asset($galleryImage->image) }}" alt="Gallery" class="w-100 h-100 object-fit-cover">
                                            <input type="hidden" name="existing_gallery_images[]" value="{{ $galleryImage->id }}">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle d-flex align-items-center justify-content-center remove-gallery-item" data-existing-id="{{ $galleryImage->id }}" style="width: 20px; height: 20px; line-height: 1;">x</button>
                                        </div>
                                    @endforeach

                                    <button type="button" id="gallery-picker-trigger" class="btn btn-light border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 58px; height: 58px;">
                                        <i class="ri-add-line" style="font-size: 30px; color: #7b7b7b;"></i>
                                    </button>
                                </div>
                                <div class="form-text mt-2">Co the click hoac drop nhieu anh. Anh se duoc nen truoc khi upload.</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $post->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Hien thi {{ strtolower($typeLabel) }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var fileInput = document.getElementById('image_file');
        var previewBox = document.getElementById('image-preview-box');
        var removeButton = document.getElementById('remove-image-trigger');
        var preview = document.getElementById('image-preview');
        var placeholder = document.getElementById('image-placeholder');
        var removeImageInput = document.getElementById('remove_image');
        var slugInput = document.getElementById('slug');
        var seoLinkPreview = document.getElementById('seo-link-preview');
        var galleryInput = document.getElementById('gallery_files');
        var galleryButton = document.getElementById('gallery-picker-trigger');
        var galleryGrid = document.getElementById('gallery-preview-grid');
        var galleryFiles = galleryInput ? new DataTransfer() : null;

        if (!fileInput || !previewBox || !preview || !placeholder || !removeButton || !removeImageInput) {
            return;
        }

        function loadImage(file) {
            return new Promise(function (resolve, reject) {
                var image = new Image();
                var objectUrl = URL.createObjectURL(file);

                image.onload = function () {
                    URL.revokeObjectURL(objectUrl);
                    resolve(image);
                };

                image.onerror = function () {
                    URL.revokeObjectURL(objectUrl);
                    reject(new Error('Khong doc duoc anh.'));
                };

                image.src = objectUrl;
            });
        }

        function canvasToBlob(canvas, type, quality) {
            return new Promise(function (resolve, reject) {
                canvas.toBlob(function (blob) {
                    if (!blob) {
                        reject(new Error('Khong the nen anh.'));
                        return;
                    }

                    resolve(blob);
                }, type, quality);
            });
        }

        async function compressImage(file, options) {
            var settings = Object.assign({
                maxWidth: 1600,
                maxHeight: 1600,
                quality: 0.82,
                outputType: 'image/webp'
            }, options || {});

            if (!file || !file.type || file.type.indexOf('image/') !== 0 || file.type === 'image/gif') {
                return file;
            }

            var image = await loadImage(file);
            var ratio = Math.min(settings.maxWidth / image.width, settings.maxHeight / image.height, 1);
            var targetWidth = Math.max(1, Math.round(image.width * ratio));
            var targetHeight = Math.max(1, Math.round(image.height * ratio));

            if (ratio === 1 && file.size <= 1024 * 1024) {
                return file;
            }

            var canvas = document.createElement('canvas');
            canvas.width = targetWidth;
            canvas.height = targetHeight;

            var context = canvas.getContext('2d', { alpha: true });
            context.drawImage(image, 0, 0, targetWidth, targetHeight);

            var blob = await canvasToBlob(canvas, settings.outputType, settings.quality);
            var extension = settings.outputType === 'image/png' ? 'png' : 'webp';
            var fileName = (file.name || 'image').replace(/\.[^.]+$/, '') + '.' + extension;

            if (blob.size >= file.size && ratio === 1) {
                return file;
            }

            return new File([blob], fileName, {
                type: blob.type,
                lastModified: Date.now()
            });
        }

        function createDataTransfer(files) {
            var transfer = new DataTransfer();
            files.forEach(function (file) {
                transfer.items.add(file);
            });

            return transfer;
        }

        function bindDropZone(element, onFiles) {
            if (!element) {
                return;
            }

            ['dragenter', 'dragover'].forEach(function (eventName) {
                element.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    element.classList.add('border-primary');
                });
            });

            ['dragleave', 'dragend', 'drop'].forEach(function (eventName) {
                element.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    element.classList.remove('border-primary');
                });
            });

            element.addEventListener('drop', function (event) {
                var files = Array.from((event.dataTransfer && event.dataTransfer.files) || []).filter(function (file) {
                    return file.type && file.type.indexOf('image/') === 0;
                });

                if (files.length) {
                    onFiles(files);
                }
            });
        }

        function showPlaceholder() {
            preview.src = '';
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
            removeButton.classList.add('d-none');
        }

        function showPreview(src) {
            preview.src = src;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
            removeButton.classList.remove('d-none');
        }

        async function applyMainImage(file) {
            if (!file) {
                return;
            }

            var compressedFile = await compressImage(file, {
                maxWidth: 1800,
                maxHeight: 1800,
                quality: 0.82
            });
            var transfer = createDataTransfer([compressedFile]);

            removeImageInput.value = '0';
            fileInput.files = transfer.files;

            var reader = new FileReader();
            reader.onload = function (event) {
                showPreview(event.target.result);
            };
            reader.readAsDataURL(compressedFile);
        }

        previewBox.addEventListener('click', function () {
            fileInput.click();
        });

        fileInput.addEventListener('change', function (event) {
            var file = event.target.files[0];

            if (file) {
                applyMainImage(file);
            }
        });

        removeButton.addEventListener('click', function () {
            fileInput.value = '';
            removeImageInput.value = '1';
            showPlaceholder();
        });

        bindDropZone(previewBox, function (files) {
            applyMainImage(files[0]);
        });

        function updateSeoPreview() {
            if (!slugInput || !seoLinkPreview) {
                return;
            }

            var slug = slugInput.value || 'slug';
            var prefix = '{{ $type === 'product' ? 'san-pham' : 'tin-tuc' }}';
            seoLinkPreview.textContent = '{{ url('/') }}/' + prefix + '/' + slug;
        }

        if (slugInput) {
            slugInput.addEventListener('input', updateSeoPreview);
        }
        updateSeoPreview();

        function appendGalleryItem(src, existingId, fileToken) {
            if (!galleryGrid) {
                return;
            }

            var wrapper = document.createElement('div');
            wrapper.className = 'position-relative border rounded overflow-hidden bg-light gallery-item';
            wrapper.setAttribute('data-gallery-item', '');
            wrapper.style.width = '72px';
            wrapper.style.height = '72px';

            var image = document.createElement('img');
            image.src = src;
            image.className = 'w-100 h-100 object-fit-cover';
            image.alt = 'Gallery';

            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle d-flex align-items-center justify-content-center remove-gallery-item';
            button.style.width = '20px';
            button.style.height = '20px';
            button.style.lineHeight = '1';
            button.textContent = 'x';

            if (existingId) {
                button.dataset.existingId = existingId;
            }

            if (fileToken) {
                button.dataset.fileToken = fileToken;
            }

            wrapper.appendChild(image);
            wrapper.appendChild(button);

            if (galleryButton && galleryButton.parentNode === galleryGrid) {
                galleryGrid.insertBefore(wrapper, galleryButton);
            } else {
                galleryGrid.appendChild(wrapper);
            }
        }

        async function addGalleryFiles(files) {
            if (!galleryInput || !galleryFiles) {
                return;
            }

            for (let index = 0; index < files.length; index++) {
                let compressedFile = await compressImage(files[index], {
                    maxWidth: 1800,
                    maxHeight: 1800,
                    quality: 0.8
                });
                let currentToken = [compressedFile.name, compressedFile.size, compressedFile.lastModified].join('__');
                galleryFiles.items.add(compressedFile);

                var reader = new FileReader();
                reader.onload = function (event) {
                    appendGalleryItem(event.target.result, null, currentToken);
                };
                reader.readAsDataURL(compressedFile);
            }

            galleryInput.files = galleryFiles.files;
        }

        if (galleryButton && galleryInput) {
            galleryButton.addEventListener('click', function () {
                galleryInput.click();
            });

            galleryInput.addEventListener('change', function (event) {
                addGalleryFiles(Array.from(event.target.files || []));
            });

            bindDropZone(galleryGrid, function (files) {
                addGalleryFiles(files);
            });
        }

        document.addEventListener('click', function (event) {
            var removeGalleryButton = event.target.closest('.remove-gallery-item');

            if (!removeGalleryButton) {
                return;
            }

            var existingId = removeGalleryButton.getAttribute('data-existing-id');
            var fileToken = removeGalleryButton.getAttribute('data-file-token');

            if (existingId && galleryGrid) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_gallery_images[]';
                input.value = existingId;
                galleryGrid.appendChild(input);
            }

            if (fileToken && galleryInput && galleryFiles) {
                var nextFiles = new DataTransfer();

                Array.from(galleryInput.files).forEach(function (file) {
                    var currentToken = [file.name, file.size, file.lastModified].join('__');

                    if (currentToken !== fileToken) {
                        nextFiles.items.add(file);
                    }
                });

                galleryFiles = nextFiles;
                galleryInput.files = galleryFiles.files;
            }

            var galleryItem = removeGalleryButton.closest('[data-gallery-item]');
            if (galleryItem) {
                galleryItem.remove();
            }
        });
    });
</script>
