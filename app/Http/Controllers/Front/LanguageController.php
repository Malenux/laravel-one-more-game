<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MySQL\Sitemap;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
	public function __construct(Sitemap $sitemap) {}

	public function changeLanguage(Request $request)
	{
		$language = $request->language;
		$path = $request->path;
		$sitemap = Sitemap::where('path', $path)->first();
		$routeName = $sitemap->route_name;
		$languagePath = $sitemap->language;

		$routeName = str_replace($languagePath, $language, $routeName);

		$redirect = Sitemap::where('route_name', $routeName)->first();

		return response()->json([
			'success' => true,
			'path' => $redirect->path
		]);
	}
}