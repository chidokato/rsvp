<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting?->company_name ?: 'Xac nhan tham du' }}</title>
    <meta name="description" content="Trang chu phong cach thiep moi voi giao dien xac nhan tham du.">
    @if ($setting?->favicon)
        <link rel="icon" href="{{ asset($setting->favicon) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oooh+Baby&display=swap" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/home.css') }}" rel="stylesheet">
</head>
<body class="home-page">
    <main class="page">
        <section class="invitation container-xxl position-relative">
            <div class="content">
                <h1 class="title">Xac nhan tham du</h1>
                <p class="subtitle mb-4">Hay cho chung toi biet ban se den tham du nhe!</p>

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
                        Thong tin xac nhan da duoc ghi nhan.
                    </div>
                @endif

                <form class="rsvp-form" id="rsvp-form" action="{{ route('home.rsvp') }}" method="post">
                    @csrf

                    <label class="check-row form-check justify-content-center mb-0">
                        <input class="form-check-input me-2" type="checkbox" name="ceremony" value="1" {{ old('ceremony') ? 'checked' : '' }}>
                        <span>Le Thanh Hon</span>
                    </label>

                    <div class="field-group">
                        <label class="field-label" for="guest_name">Ten Khach Moi</label>
                        <input id="guest_name" class="field form-control" type="text" name="guest_name" placeholder="Ten Khach Moi" value="{{ old('guest_name') }}">
                    </div>

                    <div class="field-group">
                        <select class="select-field form-select" name="attendance_status" aria-label="Trang thai tham du">
                            <option value="yes" {{ old('attendance_status', 'yes') === 'yes' ? 'selected' : '' }}>Co toi se den</option>
                            <option value="no" {{ old('attendance_status') === 'no' ? 'selected' : '' }}>Rat tiec toi khong den duoc</option>
                            <option value="maybe" {{ old('attendance_status') === 'maybe' ? 'selected' : '' }}>Toi se phan hoi sau</option>
                        </select>
                    </div>

                    <div class="guest-wrap">
                        <input class="guest-field form-control text-center" type="number" name="guest_count" min="1" max="20" value="{{ old('guest_count', 1) }}" aria-label="So luong nguoi">
                    </div>

                    <textarea class="textarea-field form-control" name="message" placeholder="Loi nhan danh cho chung toi">{{ old('message') }}</textarea>

                    <button class="submit btn btn-primary" type="submit">Xac nhan</button>
                </form>

                <p class="footer-note">
                    {{ $setting?->company_name ?: 'Thiep moi online' }}
                    @if ($setting?->hotline)
                        - Hotline {{ $setting->hotline }}
                    @endif
                </p>
            </div>
        </section>
    </main>

    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/home.js') }}"></script>
</body>
</html>
