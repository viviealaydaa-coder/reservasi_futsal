<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'lapangan']);

        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('booking_code', 'like', '%'.$request->search.'%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%'.$request->search.'%');
                  });
            });
        }

        $bookings = $query->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function verifyPayment($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->payment_status == 'waiting_confirmation') {
            $booking->payment_status = 'paid';
            $booking->payment_verified_at = now();
            $booking->verified_by = auth()->id();
            $booking->save();
            return back()->with('success', 'Pembayaran diverifikasi. Lapangan terblokir.');
        }
        return back()->with('error', 'Status tidak valid.');
    }

    public function rejectPayment($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->payment_status == 'waiting_confirmation') {
            $booking->payment_status = 'failed';
            $booking->payment_notes = 'Bukti tidak valid atau tidak sesuai';
            $booking->save();
            return back()->with('error', 'Pembayaran ditolak.');
        }
        return back();
    }

    public function completeBooking($id, Request $request)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->payment_status == 'paid') {
            $booking->payment_status = 'completed';
            $booking->damage_notes = $request->damage_notes;
            $booking->damage_fee = $request->damage_fee ?? 0;
            $booking->save();
            return back()->with('success', 'Booking selesai. Lapangan tersedia kembali.');
        }
        return back();
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if (in_array($booking->payment_status, ['pending', 'waiting_confirmation'])) {
            $booking->payment_status = 'cancelled';
            $booking->save();
            return back()->with('success', 'Booking dibatalkan.');
        }
        return back();
    }
}