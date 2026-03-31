@extends('backend.layouts.app')

@section('title', 'Guest Registration')
@section('page_title', 'Guest Registration')
@section('breadcrumb', 'Guest Registration')

@php
    $statusLabels = [
        'yes' => ['label' => 'Se den', 'class' => 'success'],
        'no' => ['label' => 'Khong den', 'class' => 'danger'],
        'maybe' => ['label' => 'Phan hoi sau', 'class' => 'warning'],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Tong dang ky</p>
                    <h2 class="mb-2">{{ $stats['total'] }}</h2>
                    <p class="text-muted mb-0">Tat ca khach moi da gui form</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Se den</p>
                    <h2 class="mb-2">{{ $stats['attending'] }}</h2>
                    <p class="text-muted mb-0">Khach xac nhan tham du</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Khong den</p>
                    <h2 class="mb-2">{{ $stats['not_attending'] }}</h2>
                    <p class="text-muted mb-0">Khach tu choi tham du</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Cho phan hoi</p>
                    <h2 class="mb-2">{{ $stats['pending'] }}</h2>
                    <p class="text-muted mb-0">Khach se tra loi sau</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="card-title mb-1">Danh sach khach moi dang ky</h4>
                <p class="text-muted mb-0">Theo doi thong tin gui tu form RSVP ngoai trang chu.</p>
            </div>

            <form method="GET" action="{{ route('backend.guest-registrations.index') }}" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    class="form-control"
                    placeholder="Tim theo ten, loi nhan, IP"
                    style="min-width: 280px;"
                >
                <button type="submit" class="btn btn-primary">Tim</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Ten khach moi</th>
                            <th>Trang thai</th>
                            <th>So nguoi</th>
                            <th>Le thanh hon</th>
                            <th>Loi nhan</th>
                            <th>IP</th>
                            <th>Ngay gui</th>
                            <th class="text-end">Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission)
                            @php
                                $status = $statusLabels[$submission->attendance_status] ?? ['label' => $submission->attendance_status, 'class' => 'secondary'];
                            @endphp
                            <tr>
                                <td>{{ $submission->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $submission->guest_name }}</div>
                                    @if ($submission->user_agent)
                                        <div class="text-muted small text-truncate" style="max-width: 280px;">{{ $submission->user_agent }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $status['class'] }}-subtle text-{{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td>{{ $submission->guest_count }}</td>
                                <td>
                                    @if ($submission->ceremony)
                                        <span class="badge bg-success-subtle text-success">Co</span>
                                    @else
                                        <span class="badge bg-light text-muted">Khong</span>
                                    @endif
                                </td>
                                <td class="text-wrap" style="min-width: 240px;">
                                    {{ $submission->message ?: 'Khong co loi nhan.' }}
                                </td>
                                <td>{{ $submission->ip_address ?: '-' }}</td>
                                <td>{{ $submission->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <form
                                        action="{{ route('backend.guest-registrations.destroy', $submission) }}"
                                        method="POST"
                                        class="d-inline"
                                        data-confirm-delete
                                        data-confirm-message="Ban co chac muon xoa ban ghi dang ky nay?"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Xoa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Chua co khach moi nao gui dang ky.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $submissions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
