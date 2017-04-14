<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

class FileController extends Controller
{
	//

	public function __construct()
	{
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

}
