<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create($lapangan_id)
    {
        $lapangan = Lapangan::findOrFail($lapangan_id);
        $maxDate = Carbon::now()->addMonth();
        return view('bookings.create', compact('lapangan', 'maxDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'booking_date' => 'required|date|after_or_equal:today|before_or_equal:' . Carbon::now()->addMonth()->format('Y-m-d'),
            'start_time' => 'required',
            'duration_hours' => 'required|in:2,3,4,5',
            'payment_method' => 'required|in:cash,qris',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        $price = $lapangan->getPriceForHours((int) $request->duration_hours);
        
        // Hitung waktu mulai dan selesai
        $start = Carbon::parse($request->start_time);
        $end = $start->copy()->addHours((int) $request->duration_hours);
        $endTime = $end->format('H:i:s');

        // Pengecekan tumpang tindih (overlap) menggunakan raw where
        $isBooked = Booking::where('lapangan_id', $lapangan->id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('payment_status', ['paid', 'waiting_confirmation'])
            ->where(function ($query) use ($start, $end) {
                $query->whereRaw('start_time < ?', [$end->format('H:i:s')])
                      ->whereRaw('end_time > ?', [$start->format('H:i:s')]);
            })
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['start_time' => 'Jam tersebut sudah dibooking (tumpang tindih). Pilih jam lain.']);
        }

        $booking = Booking::create([
            'booking_code' => Booking::generateBookingCode(),
            'user_id' => Auth::id(),
            'lapangan_id' => $lapangan->id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'duration_hours' => $request->duration_hours,
            'end_time' => $endTime,
            'price_per_period' => $price,
            'total_price' => $price,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        if ($request->payment_method == 'cash') {
            $booking->payment_status = 'waiting_confirmation';
            $booking->save();
        }

        return redirect()->route('bookings.payment', $booking->id)->with('success', 'Booking berhasil dibuat, silakan selesaikan pembayaran.');
    }

    public function paymentPage($id)
    {
        $booking = Booking::with('lapangan')->findOrFail($id);
        if ($booking->user_id != Auth::id()) abort(403);
        return view('bookings.payment', compact('booking'));
    }

    public function uploadProof(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->user_id != Auth::id()) abort(403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('bukti-bayar', 'public');
        $booking->payment_proof = $path;
        $booking->payment_status = 'waiting_confirmation';
        $booking->save();

        return redirect()->route('bookings.history')->with('success', 'Bukti pembayaran diupload, menunggu verifikasi admin.');
    }

    public function history()
    {
        $bookings = Booking::with(['lapangan', 'user'])
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    public function cancelByUser($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if (!in_array($booking->payment_status, ['pending', 'waiting_confirmation']) || $booking->payment_method != 'cash') {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
        }

        $booking->payment_status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function invoice($id)
    {
        $booking = Booking::with('lapangan', 'user')->findOrFail($id);
        
        if ($booking->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Tidak punya akses ke invoice ini');
        }
        
        return view('bookings.invoice', compact('booking'));
    }

    public function riwayat()
    {
        $bookings = Booking::with(['lapangan', 'user'])
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('bookings.riwayat', compact('bookings'));
    }

    public function checkSlot(Request $request)
    {
        $lapanganId = $request->query('lapangan_id');
        $date = $request->query('date');
        $startTime = $request->query('start_time');
        $durationHours = $request->query('duration_hours', 2); // default 2 jam

        if (!$lapanganId || !$date || !$startTime) {
            return response()->json(['available' => false, 'message' => 'Parameter tidak lengkap']);
        }

        $lapangan = Lapangan::findOrFail($lapanganId);
        $newStart = Carbon::parse($startTime);
        $newEnd = $newStart->copy()->addHours((int) $durationHours);

        $isBooked = Booking::where('lapangan_id', $lapanganId)
            ->where('booking_date', $date)
            ->whereIn('payment_status', ['paid', 'waiting_confirmation'])
            ->where(function ($query) use ($newStart, $newEnd) {
                $query->whereRaw('start_time < ?', [$newEnd->format('H:i:s')])
                      ->whereRaw('end_time > ?', [$newStart->format('H:i:s')]);
            })
            ->exists();

        if ($isBooked) {
            return response()->json(['available' => false, 'message' => 'Jam tersebut sudah dibooking (tumpang tindih). Pilih jam lain.']);
        }

        return response()->json(['available' => true, 'message' => 'Slot tersedia']);
    }
}