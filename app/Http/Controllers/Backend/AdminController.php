<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('backend.admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Thong tin dang nhap khong chinh xac.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('backend.admin.login');
    }

    public function index()
    {
        $stats = [
            'properties' => 128,
            'agents' => 24,
            'customers' => 486,
            'pending_posts' => 12,
        ];

        $activities = [
            ['title' => 'Bai dang moi cho duyet', 'detail' => '12 bat dong san dang cho kiem duyet.'],
            ['title' => 'Khach hang moi', 'detail' => '8 khach hang vua tao tai khoan trong hom nay.'],
            ['title' => 'Lich hen xem nha', 'detail' => '5 lich hen duoc dat trong buoi chieu.'],
        ];

        return view('backend.admin.dashboard_content', compact('stats', 'activities'));
    }
}
