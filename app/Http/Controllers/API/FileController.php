<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\VerifyFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FileController extends Controller
{
	//
	protected $expiredAt;
	protected $filePath;
	protected $secretKey;

	public function __construct()
	{
		$this->filePath = env('FILE_PATH', 'https://storage.hfi.me/file');
		$this->expiredAt = (string)env('TOKEN_EXPIRE', '300'); // unit:second
		$this->secretKey = env('STORAGE_SECRET_KEY');
		if (empty($this->secretKey)) abort(500, __('errors.service_internal_error'));
	}

	public function handleDownload(Request $request)
	{
		$file = File::findOrFail($request->id);
		$address = $this->filePath . '/download?';
		$time = (string)time();
		$result = $address . 'filename=' . $file->filename . '&timestamp=' . $time . '&expired_at=' . $this->expiredAt . '&download_name=' . $file->real_name . '&signature=' . $this->generateDownloadToken($file, $time, $this->expiredAt);

		return response()->json(['status' => 200, 'link' => $result]);
	}

	public function listImage(Request $request)
	{
		$filename = File::where('user_id', $request->user()->id)->where('type', 'image')->map(function ($file) {
			return $address = $this->filePath . '/image?' . 'filename=' . $file->filename;
		});

		return response()->json(['status' => 200, 'data' =>$filename]);
	}

	public function handleUpload(VerifyFile $request)
	{
		$file = new File();
		$file->real_name = $request->real_name;
		$file_extension = strtolower(substr(strrchr($request->real_name,"."),1));

		switch( $file_extension ) {
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpeg"; break;
			default:
		}
		switch ($request->type) {
			case 'file':
				$address = $this->filePath . '/upload?';
				$filename = $this->generateFilename('file');
				$file->type = 'file';
				break;
			case 'image':
				$address = $this->filePath . '/upload/image?';
				$filename = $this->generateFilename('image');
				$file->type = 'image';
				break;
			default:
				return response()->json('type No Found', 404);
		}
		$file->filename = $filename;
		$file->user_id = $request->user()->id;
		$file->saveOrFail();
		$time = (string)time();
		$result = $address . 'filename=' . $file->filename . '&timestamp=' . $time . '&expired_at=' . $this->expiredAt . '&signature=' . $this->generateUploadToken($file, $time, $this->expiredAt);

		return response()->json(['status' => 200, 'link' => $result]);
	}

	public function handleEcho(Request $request)
	{
		$file = File::where('filename', $request->filename)->firstOrFail();
		$file->valid = 1;
		$file->saveOrFail();

		return response()->json(['status' => 200]);

	}

	protected function generateFilename($prefix = '')
	{
		$filename = '';
		while (true) {
			$filename = randomString(25, $prefix) . time();
			if (empty(File::where('real_name', $filename)->first())) {
				break;
			}
		}

		return $filename;
	}

	protected function generateDownloadToken($file, $time, $expiredAt)
	{
		$raw = collect(['filename'      => $file->filename,
		                'timestamp'     => $time,
		                'expired_at'    => $expiredAt,
		                'download_name' => $file->real_name,
			]
		)->toJson();
		$signAwait = base64_encode($raw);
		$sign = hash_hmac('sha256', $signAwait, $this->secretKey);
		$signEncoded = base64_encode($sign);

		return $signEncoded;
	}

	protected function generateUploadToken($file, $time, $expiredAt)
	{
		$raw = collect(['filename'   => $file->filename,
		                'timestamp'  => $time,
		                'expired_at' => $expiredAt,
			]
		)->toJson();
		$signAwait = base64_encode($raw);
		$sign = hash_hmac('sha256', $signAwait, $this->secretKey);
		$signEncoded = base64_encode($sign);

		return $signEncoded;
	}
}
