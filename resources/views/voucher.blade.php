<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tạo voucher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/thumoi-generator.css') }}" rel="stylesheet">
</head>
<body class="thumoi-generator-page voucher-page">
    <main class="generator-shell container-xl py-4 py-lg-5">
        <div class="generator-layout">
            <section class="form-panel">
                <div class="form-card">
                    <h2 class="form-title">Tạo voucher</h2>
                    <p class="form-text">Quý Khách vui lòng nhập các thông tin dưới đây, sau đó bấm "Tạo Voucher" và lưu mã Voucher về máy. Chúc Quý Khách có những trải nghiệm trọn vẹn tại Asia Town</p>

                    <form id="invitation-form" class="invitation-form" action="{{ route('voucher.store') }}" method="post">
                        @csrf
                        <div class="field-row">
                            <div class="field-block field-block-salutation">
                                <label for="apartment_code" class="field-label">Mã căn</label>
                                <input
                                    id="apartment_code"
                                    name="apartment_code"
                                    type="text"
                                    class="form-control input-control"
                                    placeholder="Ví dụ: A12.08"
                                >
                            </div>

                            <div class="field-block field-block-name">
                                <label for="phone_last4" class="field-label">4 số cuối số điện thoại</label>
                                <input
                                    id="phone_last4"
                                    name="phone_last4"
                                    type="text"
                                    class="form-control input-control"
                                    inputmode="numeric"
                                    maxlength="4"
                                    placeholder="Ví dụ: 6688"
                                >
                            </div>
                        </div>

                        <div class="field-block">
                            <label for="project_name" class="field-label">Tên dự án đã mua</label>
                            <input
                                id="project_name"
                                name="project_name"
                                type="text"
                                class="form-control input-control"
                                placeholder="Ví dụ: Indochine Grand"
                            >
                        </div>

                        <div class="action-row">
                            <button type="button" id="generate-invitation" class="btn btn-primary action-button">Tạo voucher</button>
                            <button type="button" id="download-web" class="btn btn-outline-light action-button web-only-action" disabled>Tải cho web</button>
                            <button type="button" id="download-mobile" class="btn btn-outline-light action-button mobile-only-action" disabled>Mở cho mobile</button>
                        </div>
                    </form>

                    <div id="generator-feedback" class="alert alert-warning mt-4 mb-0 d-none" role="alert"></div>
                </div>
            </section>

            <section class="preview-panel">
                <div class="preview-card">
                    <div class="voucher-preview-stack d-grid gap-3 p-3">
                        <div class="invitation-preview">
                            <img
                                src="{{ asset('frontend/images/voucher1.jpg') }}"
                                alt="Voucher 1"
                                class="preview-image"
                            >
                        </div>

                        <div
                            class="invitation-preview"
                            id="invitation-preview"
                            data-sample-src="{{ asset('frontend/images/voucher2.jpg') }}"
                            data-template-src="{{ asset('frontend/images/voucher2.jpg') }}"
                            data-file-prefix="voucher"
                            data-generator-type="voucher"
                        >
                            <img
                                id="sample-preview"
                                src="{{ asset('frontend/images/voucher2.jpg') }}"
                                alt="Voucher 2"
                                class="preview-image"
                            >
                            <canvas id="invitation-canvas" class="preview-canvas d-none" width="1890" height="828"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/thumoi-generator.js') }}"></script>
</body>
</html>
