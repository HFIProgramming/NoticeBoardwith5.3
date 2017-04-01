<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\VerifyFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
	//
	function __construct()
	{
		$this->accessKey = env('OBJECT_STORAGE_ACCESS_KEY', NULL);
		$this->secretKey = env('OBJECT_STORAGE_SECRET_KEY', NULL);
		$this->imageBucketName = env('OBJECT_STORAGE_IMAGE_BUCKET_NAME', NULL);
		$this->expire = env('OBJECT_STORAGE_TOKEN_EXPIRE', 400);
	}

	public function generateKeys(VerifyFile $request)
	{
		switch ($request->type) {
			case  'image':
				$bucket = $this->imageBucketName;
				break;
			default:
				abort(422, __('auth.illegal_request'));
		}

		$json = json_encode(["Bucket" => $bucket, "Object" => $request->object, "Expires" => time() + $this->expire]);

		$base64 = base64_encode($json);

		$sign = hash_hmac('sha256', $base64, $this->secretKey);

		$result = base64_encode($sign);

		return Response()->json(
			[
				"bucketName" => $bucket,
			    "objectName" => $request->object,
			    "token" => $result,

			]
		);

	}
}
