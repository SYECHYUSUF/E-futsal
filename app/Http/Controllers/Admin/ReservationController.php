<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    public function index()
    {
        $reservations = Reservation::with(['user', 'field'])->latest()->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'field']);

        return view('admin.reservations.show', compact('reservation'));
    }

    public function approve(Reservation $reservation)
    {
        $isBooked = Reservation::where('field_id', $reservation->field_id)
            ->where('booking_date', $reservation->booking_date)
            ->where('status', 'confirmed')
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($reservation) {
                // Logika overlap waktu
                $query->where('start_time', '<', $reservation->end_time)
                    ->where('end_time', '>', $reservation->start_time);
            })->exists();

        if ($isBooked) {
            return back()->with('error', 'Failed! Schedule conflicts with another confirmed booking.');
        }

        $reservation->update(['status' => 'confirmed']);

        if ($reservation->user->phone) {
            $msg = "*Hello {$reservation->user->name}* 👋\n\n";
            $msg .= "Your field booking has been *APPROVED* ✅.\n";
            $msg .= "🏟 Field: {$reservation->field->name}\n";
            $msg .= "📅 Date: " . date('d M Y', strtotime($reservation->booking_date)) . "\n";
            $msg .= "⏰ Time: {$reservation->start_time} - {$reservation->end_time}\n";
            $msg .= "\nPlease arrive on time!";

            $this->waService->sendMessage($reservation->user->phone, $msg);
        }

        return back()->with('success', 'Reservation approved & WhatsApp notification sent.');
    }

    // REJECT
    public function reject(Request $request, Reservation $reservation)
    {
        $request->validate(['reason' => 'required|string']);

        $reservation->update([
            'status' => 'cancelled',
        ]);

        if ($reservation->user->phone) {
            $msg = "*Hello {$reservation->user->name}* 👋\n\n";
            $msg .= "Sorry, your field booking has been *REJECTED* ❌.\n";
            $msg .= "Reason: _{$request->reason}_\n\n";
            $msg .= "Please book another time/day.";

            $this->waService->sendMessage($reservation->user->phone, $msg);
        }

        return back()->with('success', 'Reservation rejected & WhatsApp notification sent.');
    }

    public function review(Request $request, Reservation $reservation)
    {
        $action = $request->query('action', 'detail');

        return view('admin.reservations.review', compact('reservation', 'action'));
    }
}
