<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Mail\ReminderEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users for their reservations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $todayMorning = $now->copy()->startOfDay()->addHours(8);
        $tomorrowMorning = $now->copy()->addDay()->startOfDay()->addHours(8);

        // 当日の0:00〜8:00までの予約に対して前日の朝8:00に送信
        if($now->between($todayMorning->copy()->subHours(8), $todayMorning)){
            $reservations = Reservation::whereBetween('date', [$todayMorning->copy()->subHours(8), $todayMorning])->get();
        } else {
            // それ以外の予約に対して当日の朝8:00に送信
            $reservations = Reservation::whereDate('date',$now->toDateString())
                ->whereTime('time','>=', '08:00:00')
                ->get();
        }

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReminderEmail($reservation));
            $this->info('Sent reminder email to: ' . $reservation->user->email);
        }
    }
}
