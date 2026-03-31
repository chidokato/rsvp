@extends('backend.layouts.app')

@section('title', 'Setting')
@section('page_title', 'Setting')
@section('breadcrumb', 'Setting')

@php
    $socialMap = collect($setting->social ?? [])->mapWithKeys(function ($item) {
        return [strtolower($item['label'] ?? '') => $item['url'] ?? ''];
    });
@endphp

@section('content')
    <form action="{{ route('backend.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0">Thong tin cong ty</h4>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Luu setting</button>
                    <a href="{{ route('backend.admin.dashboard') }}" class="btn btn-light">Quay lai</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Ten cty</label>
                            <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $setting->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $setting->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="hotline" class="form-label">Hotline</label>
                            <input type="text" id="hotline" name="hotline" class="form-control @error('hotline') is-invalid @enderror" value="{{ old('hotline', $setting->hotline) }}">
                            @error('hotline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-0">
                            <label for="address" class="form-label">Dia chi</label>
                            <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $setting->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Social</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" id="facebook" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $socialMap->get('facebook')) }}" placeholder="https://facebook.com/your-page">
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-0">
                            <label for="youtube" class="form-label">Youtube</label>
                            <input type="url" id="youtube" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube', $socialMap->get('youtube')) }}" placeholder="https://youtube.com/@your-channel">
                            @error('youtube')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Hinh anh thuong hieu</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @include('backend.settings.partials.image-field', [
                        'title' => 'Logo',
                        'field' => 'logo_file',
                        'removeField' => 'remove_logo',
                        'image' => $setting->logo,
                    ])

                    @include('backend.settings.partials.image-field', [
                        'title' => 'Logo footer',
                        'field' => 'footer_logo_file',
                        'removeField' => 'remove_footer_logo',
                        'image' => $setting->footer_logo,
                    ])

                    @include('backend.settings.partials.image-field', [
                        'title' => 'Favicon',
                        'field' => 'favicon_file',
                        'removeField' => 'remove_favicon',
                        'image' => $setting->favicon,
                    ])
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.image-upload-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    var inputId = button.getAttribute('data-input');
                    var input = document.getElementById(inputId);

                    if (input) {
                        input.click();
                    }
                });
            });

            document.querySelectorAll('input[type="file"]').forEach(function (input) {
                input.addEventListener('change', function (event) {
                    var file = event.target.files[0];
                    var trigger = document.querySelector('.image-upload-trigger[data-input="' + input.id + '"]');
                    var removeButton = document.querySelector('.image-remove-trigger[data-input="' + input.id + '"]');

                    if (!file || !trigger) {
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        trigger.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-contain" alt="preview">';
                        if (removeButton) {
                            removeButton.classList.remove('d-none');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            });

            document.querySelectorAll('.image-remove-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    var inputId = button.getAttribute('data-input');
                    var removeFieldId = button.getAttribute('data-remove');
                    var input = document.getElementById(inputId);
                    var removeField = document.getElementById(removeFieldId);
                    var trigger = document.querySelector('.image-upload-trigger[data-input="' + inputId + '"]');

                    if (input) {
                        input.value = '';
                    }

                    if (removeField) {
                        removeField.value = '1';
                    }

                    if (trigger) {
                        trigger.innerHTML = '<div class="text-center text-muted"><div class="display-6 mb-2"><i class="ri-image-line"></i></div><div>No image</div></div>';
                    }

                    button.classList.add('d-none');
                });
            });
        });
    </script>
@endsection
