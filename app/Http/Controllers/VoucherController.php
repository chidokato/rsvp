<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_code' => ['required', 'string', 'max:50'],
            'phone_last4' => ['required', 'digits:4'],
            'project_name' => ['required', 'string', 'max:255'],
        ]);

        $voucherCode = $validated['phone_last4'] . '-' . strtoupper($validated['apartment_code']);

        $voucher = Voucher::create([
            'apartment_code' => strtoupper($validated['apartment_code']),
            'phone_last4' => $validated['phone_last4'],
            'project_name' => $validated['project_name'],
            'voucher_code' => $voucherCode,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Da luu voucher thanh cong.',
            'voucher' => [
                'id' => $voucher->id,
                'voucher_code' => $voucher->voucher_code,
            ],
        ]);
    }
}
