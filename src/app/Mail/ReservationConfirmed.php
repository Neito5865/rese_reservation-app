<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation-confirmed')
                    ->subject('予約が確定しました')
                    ->with([
                        'reservation' => $this->reservation,
                        'qrCode' => \SimpleSoftwareIO\QrCode\Facades\QrCode::generate(route('reservation.qrConfirmed', $this->reservation->id))
                    ]);
    }
}
