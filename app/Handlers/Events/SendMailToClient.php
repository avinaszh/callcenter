<?php namespace App\Handlers\Events;

use App\Events\ClaimCreate;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendMailToClient {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  ClaimCreate  $event
	 * @return void
	 */
	public function handle(ClaimCreate $event)
	{
        $claim = $event->claim;
        \Mail::send('emails.claimcreate',compact('claim'), function($message) use ($event)
        {
            $message->to($event->claim->project->client->email, 'Callcenter №1')->subject('Создано новое обращение.');
        });
	}

}