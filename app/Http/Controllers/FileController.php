<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
	//
	public function __construct()
	{
		$this->fileBucket = 'hfinotice-file';
		$this->imageBucket = 'hfinotice-image';
		$this->expireAt = '600'; // unit:second
		$this->accessKey = 'ff7f5dd02238400a8cb341b519ca4cd9';
		$this->accessSecret = '';
	}

	public function handle(Request $request)
	{
		switch ($request->type) {
			case 'file':

		}

	}

	public function filenameVerify(){
		randomString(10, 'file') . time();
	}

	public function tokenGenerate($type, $filename)
	{
		$raw = collect(['Bucket'  => $type,
		                'Object'  => $filename,
		                'Expires' => $this->expireAt])->toJson();
		$signAwait = base64_encode($raw);
		$sign = hash_hmac('sha256', $signAwait, $this->accessSecret);
		$signEncoded = base64_encode($sign);
		$token = $this->accessKey . ':' . $signEncoded . ':' . $signAwait;

		return $token;
	}
}
