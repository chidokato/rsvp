<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting?->company_name ?: 'Xác nhận tham dự' }}</title>
    <meta name="description" content="Trang xác nhận tham dự sự kiện INDOCHINE.">
    @if ($setting?->favicon)
        <link rel="icon" href="{{ asset($setting->favicon) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/home.css') }}" rel="stylesheet">
</head>
<body class="home-page">
    <main class="page">
        <section class="invitation container-xxl position-relative">
            <div class="content content-split">
                <div class="invite-panel">
                    <div class="invite-card">
                        <div class="invite-media">
                            <img src="{{ asset('frontend/images/thumoi.jpg') }}" alt="Thư mời">
                        </div>
                        <div class="invite-copy">
                            <div
                                class="countdown"
                                data-countdown="2026-04-07T09:30:00+07:00"
                                aria-label="Đồng hồ đếm ngược đến thời gian tham dự"
                            >
                                <div class="countdown-item">
                                    <span class="countdown-value" data-unit="days">00</span>
                                    <span class="countdown-label">Ngày</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" data-unit="hours">00</span>
                                    <span class="countdown-label">Giờ</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" data-unit="minutes">00</span>
                                    <span class="countdown-label">Phút</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" data-unit="seconds">00</span>
                                    <span class="countdown-label">Giây</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rsvp-panel">
                    <h1 class="title">XÁC NHẬN THAM DỰ</h1>
                    <p class="subtitle">
                        Quý vị, khách quý vui lòng xác nhận tham dự để INDOCHINE có sự tiếp đón chu đáo và trang trọng nhất.
                    </p>

                    @if (session('rsvp_success'))
                        <div id="rsvp-feedback" class="alert alert-success mt-0 mb-4" role="alert">
                            {{ session('rsvp_success') }}
                        </div>
                    @elseif ($errors->any())
                        <div id="rsvp-feedback" class="alert alert-warning mt-0 mb-4" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @else
                        <div id="rsvp-feedback" class="alert alert-success mt-0 mb-4 d-none" role="alert">
                            Thông tin xác nhận đã được ghi nhận.
                        </div>
                    @endif

                    <form class="rsvp-form" id="rsvp-form" action="{{ route('home.rsvp') }}" method="post">
                        @csrf
                        <input type="hidden" name="ceremony" value="1">
                        <input type="hidden" name="attendance_status" value="yes">

                        <div class="field-group">
                            <label class="field-label visually-hidden" for="guest_name">Tên khách mời</label>
                            <input
                                id="guest_name"
                                class="field form-control"
                                type="text"
                                name="guest_name"
                                placeholder="Tên khách mời"
                                value="{{ old('guest_name') }}"
                            >
                        </div>

                        <div class="guest-wrap">
                            <label class="field-label visually-hidden" for="guest_count">Số lượng khách</label>
                            <input
                                id="guest_count"
                                class="guest-field form-control"
                                type="text"
                                name="guest_count"
                                min="1"
                                max="20"
                                placeholder="Số lượng người"
                            >
                        </div>

                        <textarea
                            class="textarea-field form-control"
                            name="message"
                            placeholder="Lời nhắn dành cho INDOCHINE"
                        >{{ old('message') }}</textarea>

                        <button class="submit btn btn-primary" type="submit">Xác nhận</button>
                    </form>

                    <div class="brand-block">
                        <img src="{{ asset('frontend/images/logo_-02.png') }}" alt="INDOCHINE" class="brand-logo">
                        <div class="brand-company">
                            CÔNG TY CỔ PHẦN BẤT ĐỘNG SẢN INDOCHINE
                        </div>
                        <div class="brand-hotline">
                            <span class="brand-hotline-icon">
                                <img src="{{ asset('frontend/images/icon.png') }}" alt="Hotline">
                            </span>
                            <span>0799 618 555</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/home.js') }}"></script>
</body>
</html>
