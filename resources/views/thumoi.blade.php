<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tạo thư mời</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="@assetv('admin-assets/css/bootstrap.min.css')" rel="stylesheet">
    <link href="@assetv('frontend/css/thumoi-generator.css')" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Ghiocity';
            src: url('{{ asset("frontend/font/GHIOCITYANDDHISTHES-ITALIC.OTF") }}') format('opentype');
            font-weight: normal;
            font-style: italic;
        }
        #zalo-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.9);
            z-index: 99999;
            color: #fff;
            text-align: center;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            font-family: "Montserrat", sans-serif;
        }
        #zalo-overlay.active {
            display: flex;
        }
        .zalo-arrow {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 50px;
            animation: bounceTopRight 0.8s infinite alternate;
        }
        .zalo-text {
            margin-top: 120px;
            font-size: 22px;
            font-weight: 600;
            line-height: 1.6;
        }
        @keyframes bounceTopRight {
            from { transform: translate(0, 0); }
            to { transform: translate(10px, -10px); }
        }

    </style>
</head>
<body class="thumoi-generator-page">
    <!-- Preload custom font for Canvas -->
    <div style="font-family: 'Ghiocity'; position: absolute; visibility: hidden;">Preload</div>
    <div id="zalo-overlay">
        <div class="zalo-arrow">↗️</div>
        <div class="zalo-text">
            Để tạo và tải ảnh thành công,<br><br>
            Bạn vui lòng bấm vào biểu tượng <strong>dấu 3 chấm (...)</strong> ở góc trên bên phải màn hình<br><br>
            Sau đó chọn <strong>"Mở bằng trình duyệt"</strong> (Mở bằng Safari / Chrome).
        </div>
    </div>

    <main class="generator-shell container-xl py-4 py-lg-5">
        <div class="generator-layout">
            <section class="form-panel">
                <div class="form-card">
                    <h2 class="form-title">Tạo thư mời</h2>
                    <p class="form-text">Chọn danh xưng, nhập họ và tên rồi bấm tạo thư mời. Sau đó có thể tải ảnh đã tạo về máy.</p>

                    <form id="invitation-form" class="invitation-form" action="{{ route('home') }}" method="get">
                        <div class="field-row">
                            <div class="field-block field-block-salutation">
                                <label for="salutation" class="field-label">Danh xưng</label>
                                <select id="salutation" name="salutation" class="form-select input-control">
                                    <option value="Mr.">Ông</option>
                                    <option value="Ms.">Bà</option>
                                </select>
                            </div>

                            <div class="field-block field-block-name">
                                <label for="full_name" class="field-label">Họ và tên</label>
                                <input
                                    id="full_name"
                                    name="full_name"
                                    type="text"
                                    class="form-control input-control"
                                    placeholder="Ví dụ: Lê Thị Hằng"
                                >
                            </div>
                        </div>

                        <div class="field-block" style="margin-top: 18px;">
                            <label for="job_title" class="field-label">Chức vụ (Tùy chọn)</label>
                            <input
                                id="job_title"
                                name="job_title"
                                type="text"
                                class="form-control input-control"
                                placeholder="Ví dụ: Tổng Giám Đốc INDOCHINE"
                            >
                        </div>

                        <div class="action-row">
                            <button type="button" id="generate-invitation" class="btn btn-primary action-button">Tạo thư mời</button>
                            <button type="button" id="download-web" class="btn btn-outline-light action-button web-only-action" disabled>Tải ảnh</button>
                            <button type="button" id="download-mobile" class="btn btn-outline-light action-button mobile-only-action" disabled>Tải ảnh</button>
                        </div>
                    </form>

                    <div id="generator-feedback" class="alert alert-warning mt-4 mb-0 d-none" role="alert"></div>
                    

                </div>
            </section>

            <section class="preview-panel bg-none">
                <div class="preview-card bg-none">
                    <div
                        class="invitation-preview bg-none"
                        id="invitation-preview"
                        data-sample-src="{{ asset('frontend/images/mau1.jpg') }}"
                        data-template-src="{{ asset('frontend/images/phoi1.jpg') }}"
                        data-name-x="1120"
                        data-name-y="820"
                        data-name-rotate="-3.5"
                        data-name-max-width="1200"
                        data-name-line-height="48"
                        data-name-font-size="40"
                        data-detail-gap="20"
                        data-job-font-size="34"
                        data-job-line-height="38"
                        data-job-max-width="1120"
                        data-company-font-size="30"
                        data-company-line-height="34"
                        data-company-max-width="1080"
                        data-text-color="#02478a"
                    >
                        <img
                            id="sample-preview"
                            src="{{ asset('frontend/images/mau1.jpg') }}"
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
    <script src="@assetv('frontend/js/thumoi-generator.js')"></script>
    <script>
        var ua = navigator.userAgent || navigator.vendor || window.opera;
        if (ua.indexOf("Zalo") > -1 || ua.indexOf("FBAN") > -1 || ua.indexOf("FBAV") > -1) {
            document.getElementById('zalo-overlay').classList.add('active');
        }


    </script>
</body>
</html>
