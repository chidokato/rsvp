<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $vouchers = Voucher::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('voucher_code', 'like', '%' . $search . '%')
                        ->orWhere('apartment_code', 'like', '%' . $search . '%')
                        ->orWhere('phone_last4', 'like', '%' . $search . '%')
                        ->orWhere('project_name', 'like', '%' . $search . '%')
                        ->orWhere('ip_address', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Voucher::query()->count(),
            'today' => Voucher::query()->whereDate('created_at', today())->count(),
            'projects' => Voucher::query()->distinct('project_name')->count('project_name'),
            'latest_id' => Voucher::query()->max('id') ?: 0,
        ];

        return view('backend.vouchers.index', compact('vouchers', 'search', 'stats'));
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()
            ->route('backend.vouchers.index')
            ->with('success', 'Da xoa voucher.');
    }
}
