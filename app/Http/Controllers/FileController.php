<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

	public function index()
	{
		$files = File::with('user')->orderBy('created_at', 'desc')->Paginate(15);

		return $files;

		return view('welcome')->withPosts($posts);
	}

	public function showIndividualFile(Request $request)
	{
		$file = File::findOrFail($request->id);

		return $file;
	}

	public function handleDownload(Request $request)
	{
		$file = File::findOrFail($request->id);
		switch ($request->type) {
			case 'download':
				$address = $this->filePath . '/download?';
				break;
			case 'image':
				$address = $this->filePath . '/image?';
				break;
			default:
				return response()->json('type No Found', 404);
		}
		$time = (string)time();
		$result = $address . 'filename=' . $file->filename . '&timestamp=' . $time . '&expired_at=' . $this->expiredAt . '&download_name=' . $file->real_name . '&signature=' . $this->tokenGenerate($file, $time, $this->expiredAt);

		return response()->json(['status' => 200, 'link' => $result]);
	}

	protected function generateFilename($prefix = '')
	{
		$filename = '';
		while (true) {
			$filename = randomString(25, $prefix) . time();
			if (empty(File::where('real_name', $filename)->first()->get())) {
				break;
			}
		}

		return $filename;
	}

	public function tokenGenerate($file, $time, $expiredAt)
	{
		$raw = collect(['filename'      => $file->filename,
		                'timestamp'     => $time,
		                'expired_at'     => $expiredAt,
		                'download_name' => $file->real_name,
			]
		)->toJson();
		$signAwait = base64_encode($raw);
		$sign = hash_hmac('sha256', $signAwait, $this->secretKey);
		$signEncoded = base64_encode($sign);

		return $signEncoded;
	}
}
