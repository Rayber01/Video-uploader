<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

class UploadController extends Controller
{
		public function getFiles($perPage = 20)
		{
			$path = public_path('storage/app/public/video');
			$files = preg_grep('~\.(mp4)$~', scandir($path));
			$pagination = new Paginator(array_reverse($files), $perPage);
			return $pagination;
		}

		public function saveVideo(Request $request)
		{
			$request->validate([
					'video' => 'required|file|mimes:mp4|max:10000',
			]);

			$filename = $request->file('video')->storeAs('public/video/', now().'.mp4');

			return self::getFiles();
		}

		public function deleteVideo(Request $request){

			$file = 'public/video/'.$request->videoName;
			$exists = Storage::disk('local')->exists($file);
			if ($exists) {
				Storage::delete($file);
				return self::getFiles();
			}
		}

}
