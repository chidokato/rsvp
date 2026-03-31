<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RsvpSubmission;
use Illuminate\Http\Request;

class GuestRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $submissions = RsvpSubmission::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('guest_name', 'like', '%' . $search . '%')
                        ->orWhere('message', 'like', '%' . $search . '%')
                        ->orWhere('ip_address', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => RsvpSubmission::query()->count(),
            'attending' => RsvpSubmission::query()->where('attendance_status', 'yes')->count(),
            'not_attending' => RsvpSubmission::query()->where('attendance_status', 'no')->count(),
            'pending' => RsvpSubmission::query()->where('attendance_status', 'maybe')->count(),
        ];

        return view('backend.guest-registrations.index', compact('submissions', 'search', 'stats'));
    }

    public function destroy(RsvpSubmission $guestRegistration)
    {
        $guestRegistration->delete();

        return redirect()
            ->route('backend.guest-registrations.index')
            ->with('success', 'Da xoa dang ky khach moi.');
    }
}
