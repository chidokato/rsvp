<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tạo thư mời</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="@assetv('admin-assets/css/bootstrap.min.css')" rel="stylesheet">
    <link href="@assetv('frontend/css/thumoi-generator.css')" rel="stylesheet">
</head>
<body class="thumoi-generator-page">
    <main class="generator-shell container-xl py-4 py-lg-5">
        <div class="generator-layout">
            <section class="form-panel">
                <div class="form-card">
                    <h2 class="form-title">Tạo thư mời</h2>
                    <p class="form-text">Chọn danh xưng, nhập họ và tên rồi bấm tạo thư mời. Sau đó có thể tải ảnh đã tạo về máy.</p>

                    <form id="invitation-form" class="invitation-form" action="{{ route('thumoi') }}" method="get">
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
                                    placeholder="Ví dụ: Nguyễn Văn An"
                                >
                            </div>
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
                        data-sample-src="{{ asset('frontend/images/thumoi2406.png') }}"
                        data-template-src="{{ asset('frontend/images/thumoi2406.png') }}"
                        data-name-x="960"
                        data-name-y="1490"
                        data-name-max-width="1320"
                        data-name-line-height="110"
                        data-name-font-size="100"
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
                            src="{{ asset('frontend/images/thumoi2406.png') }}"
                            alt="Thư mời mẫu"
                            class="preview-image"
                        >
                        <canvas id="invitation-canvas" class="preview-canvas d-none" width="1920" height="3039"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="@assetv('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js')"></script>
    <script src="@assetv('frontend/js/thumoi-generator.js')"></script>
</body>
</html>
