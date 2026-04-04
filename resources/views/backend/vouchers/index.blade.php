@extends('backend.layouts.app')

@section('title', 'Voucher')
@section('page_title', 'Voucher')
@section('breadcrumb', 'Voucher')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Tong voucher</p>
                    <h2 class="mb-2">{{ $stats['total'] }}</h2>
                    <p class="text-muted mb-0">Tat ca voucher da tao</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Hom nay</p>
                    <h2 class="mb-2">{{ $stats['today'] }}</h2>
                    <p class="text-muted mb-0">Voucher tao trong ngay</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Du an</p>
                    <h2 class="mb-2">{{ $stats['projects'] }}</h2>
                    <p class="text-muted mb-0">So du an da ghi nhan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">ID moi nhat</p>
                    <h2 class="mb-2">#{{ $stats['latest_id'] }}</h2>
                    <p class="text-muted mb-0">Ban ghi duoc tao gan day nhat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="card-title mb-1">Danh sach voucher da tao</h4>
                <p class="text-muted mb-0">Theo doi du lieu voucher gui tu trang /voucher.</p>
            </div>

            <form method="GET" action="{{ route('backend.vouchers.index') }}" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    class="form-control"
                    placeholder="Tim theo ma voucher, ma can, du an, IP"
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
                            <th>Ma voucher</th>
                            <th>Ma can</th>
                            <th>4 so cuoi DT</th>
                            <th>Du an</th>
                            <th>IP</th>
                            <th>Ngay tao</th>
                            <th class="text-end">Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vouchers as $voucher)
                            <tr>
                                <td>{{ $voucher->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $voucher->voucher_code }}</div>
                                    @if ($voucher->user_agent)
                                        <div class="text-muted small text-truncate" style="max-width: 280px;">{{ $voucher->user_agent }}</div>
                                    @endif
                                </td>
                                <td>{{ $voucher->apartment_code }}</td>
                                <td>{{ $voucher->phone_last4 }}</td>
                                <td class="text-wrap" style="min-width: 220px;">{{ $voucher->project_name }}</td>
                                <td>{{ $voucher->ip_address ?: '-' }}</td>
                                <td>{{ $voucher->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <form
                                        action="{{ route('backend.vouchers.destroy', $voucher) }}"
                                        method="POST"
                                        class="d-inline"
                                        data-confirm-delete
                                        data-confirm-message="Ban co chac muon xoa voucher nay?"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Xoa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Chua co voucher nao duoc tao.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vouchers->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
