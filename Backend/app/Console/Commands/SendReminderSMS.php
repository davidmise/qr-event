<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventInfo;
use App\Services\BeemSMSService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendReminderSMS extends Command
{
    protected $signature = 'sms:send-reminders';
    protected $description = 'Send reminder SMS to event guests';

    protected $beemSMSService;

    public function __construct(BeemSMSService $beemSMSService)
    {
        parent::__construct();
        $this->beemSMSService = $beemSMSService;
    }

    public function handle()
    {
        Log::info('SendReminderSMS command started.');

        // Get the current date
        $currentDate = Carbon::now();
        Log::info('Current date:', ['date' => $currentDate]);

        // Calculate target dates
        $threeDaysBefore = $currentDate->copy()->addDays(3)->format('Y-m-d');
        $oneDayBefore = $currentDate->copy()->addDay()->format('Y-m-d');

        Log::info('Target dates:', ['three_days_before' => $threeDaysBefore, 'one_day_before' => $oneDayBefore]);

        // Fetch upcoming events that haven't taken place yet and are within 3 days or 1 day before the event date
        $events = EventInfo::with(['location', 'guests'])
            ->where('start_date', '>', $currentDate) // Events that have not taken place yet
            ->where(function ($query) use ($threeDaysBefore, $oneDayBefore) {
                $query->whereDate('start_date', $threeDaysBefore) // Events 3 days before
                      ->orWhereDate('start_date', $oneDayBefore); // Events 1 day before
            })
            ->get();

        Log::info('Fetched events:', ['events' => $events]);

        foreach ($events as $event) {
            $eventDetails = [
                'name' => $event->event_name,
                'date' => $event->start_date,
                'time' => $event->start_time,
                'location' => "{$event->location->street}, {$event->location->city}, {$event->location->country}"
            ];

            $guests = $event->guests->toArray(); // Convert to array
            Log::info('Event details:', ['event' => $eventDetails]);
            Log::info('Guests:', ['guests' => $guests]);

            $this->beemSMSService->sendReminderSMS($guests, $eventDetails);
        }

        Log::info('SendReminderSMS command completed.');
        $this->info('Reminder SMS sent successfully.');
    }
}
