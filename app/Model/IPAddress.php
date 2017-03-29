<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPAddress extends Model
{
	//
	protected $table = 'ip_addresses';

	/**
	 * multi connection
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function source()
	{
		return $this->morphTo();
	}

}
