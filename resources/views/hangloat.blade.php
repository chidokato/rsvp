<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tạo thư mời hàng loạt</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="@assetv('admin-assets/css/bootstrap.min.css')" rel="stylesheet">
    <link href="@assetv('frontend/css/thumoi-generator.css')" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <style>
        @font-face {
            font-family: 'Ghiocity';
            src: url('{{ asset("frontend/font/GHIOCITYANDDHISTHES-ITALIC.OTF") }}') format('opentype');
            font-weight: normal;
            font-style: italic;
        }
        .textarea-bulk {
            height: 250px;
            font-family: monospace;
            font-size: 14px;
            white-space: pre;
            overflow-wrap: normal;
            overflow-x: scroll;
        }
    </style>
</head>
<body class="thumoi-generator-page">
    <div style="font-family: 'Ghiocity'; position: absolute; visibility: hidden;">Preload</div>
    
    <main class="generator-shell container-xl py-4 py-lg-5">
        <div class="generator-layout">
            <section class="form-panel">
                <div class="form-card">
                    <h2 class="form-title">Tạo thư mời hàng loạt</h2>
                    <p class="form-text">Nhập danh sách khách mời (mỗi người 1 dòng). Định dạng: <strong>Danh xưng | Họ và Tên | Chức vụ</strong> (Chức vụ có thể bỏ trống).</p>

                    <form id="bulk-invitation-form" class="invitation-form" action="#" method="get">
                        <div class="field-block" style="margin-top: 18px;">
                            <label for="bulk_data" class="field-label">Danh sách khách mời</label>
                            <textarea
                                id="bulk_data"
                                name="bulk_data"
                                class="form-control input-control textarea-bulk"
                                placeholder="Mr. | Nguyễn Văn A | Tổng Giám Đốc&#10;Ms. | Trần Thị B&#10;Mr. | Lê Văn C | Trưởng Phòng"
                            ></textarea>
                        </div>

                        <div class="action-row mt-4">
                            <button type="button" id="generate-bulk" class="btn btn-primary action-button w-100">Tạo & Tải File ZIP</button>
                        </div>
                    </form>

                    <div id="generator-feedback" class="alert alert-warning mt-4 mb-0 d-none" role="alert"></div>
                    
                    <div id="progress-container" class="mt-4 d-none">
                        <p class="text-white mb-2" id="progress-text">Đang xử lý: 0/0</p>
                        <div class="progress" style="height: 20px; background-color: rgba(255,255,255,0.1);">
                            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none" style="opacity: 0.8; font-size: 14px;">&larr; Quay lại trang tạo đơn</a>
                    </div>
                </div>
            </section>

            <section class="preview-panel bg-none">
                <div class="preview-card bg-none">
                    <div
                        class="invitation-preview bg-none"
                        id="invitation-preview"
                        data-template-src="{{ asset('frontend/images/phoi.jpg') }}"
                        data-name-x="864"
                        data-name-y="460"
                        data-name-max-width="1500"
                        data-name-line-height="90"
                        data-name-font-size="80"
                        data-detail-gap="20"
                        data-job-font-size="34"
                        data-job-line-height="38"
                        data-job-max-width="1120"
                        data-company-font-size="30"
                        data-company-line-height="34"
                        data-company-max-width="1080"
                        data-text-color="#ffffff"
                    >
                        <img
                            id="sample-preview"
                            src="{{ asset('frontend/images/mau.jpg') }}"
                            alt="Thư mời mẫu"
                            class="preview-image"
                        >
                        <canvas id="invitation-canvas" class="preview-canvas d-none" width="1728" height="2160"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="@assetv('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js')"></script>
    <script src="{{ asset('frontend/js/thumoi-hangloat.js') }}"></script>
</body>
</html>
