<?php

namespace App\Listeners;

use App\Events\UpdateModelIPAddress;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\IPAddress;

class UpdateModelIPAddressNotification
{
	/**
	 * Create the event listener.
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
	 * @param  UpdateModelIPAddress $event
	 * @return void
	 */
	public function handle(UpdateModelIPAddress $event)
	{
		//
		$ipAddress = new IPAddress;
		$ipAddress->source_id = $event->id;
		$ipAddress->source_type = $event->type;
		$ipAddress->description = $event->description;
		$ipAddress->ip_address = $event->ip_address;
		$ipAddress->saveOrFail();
	}
}
