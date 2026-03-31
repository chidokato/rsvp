<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\RsvpSubmission;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::query()->first();

        $featuredProducts = Post::query()
            ->with('category')
            ->where('type', Post::TYPE_PRODUCT)
            ->where('is_active', true)
            ->latest('published_at')
            ->latest('id')
            ->take(6)
            ->get();

        $latestNews = Post::query()
            ->with('category')
            ->where('type', Post::TYPE_NEWS)
            ->where('is_active', true)
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        $stats = [
            'products' => Post::query()->where('type', Post::TYPE_PRODUCT)->where('is_active', true)->count(),
            'news' => Post::query()->where('type', Post::TYPE_NEWS)->where('is_active', true)->count(),
            'categories' => $featuredProducts->pluck('category_id')->filter()->unique()->count(),
        ];

        return view('home', compact('setting', 'featuredProducts', 'latestNews', 'stats'));
    }

    public function storeRsvp(Request $request)
    {
        $validated = $request->validate([
            'ceremony' => ['nullable'],
            'guest_name' => ['required', 'string', 'max:255'],
            'attendance_status' => ['required', 'in:yes,no,maybe'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:20'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        RsvpSubmission::create([
            'ceremony' => $request->boolean('ceremony'),
            'guest_name' => $validated['guest_name'],
            'attendance_status' => $validated['attendance_status'],
            'guest_count' => $validated['guest_count'],
            'message' => $validated['message'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('home')
            ->with('rsvp_success', 'Thông tin xác nhận đã được ghi nhận.');
    }
}
