<?php

namespace App\Http\Controllers\Public;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Services\SitemapService;

class PlatformController extends Controller
{
    public function __construct(private Platform $platform, private SitemapService $sitemapService) {}

    public function index()
    {
        try {
            $platforms = $this->platform->all();

            return View::make('public.platforms')->with('platforms', $platforms);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $sitemap = $this->sitemapService->getSlug($request->platform);
           
            $platform = $this->platform->where('id', $sitemap->entity_id)->first();

            return view('public.platform', compact('platform'));
        } catch (\Exception $e) {
            return View::make('public.error');
        }
    }
}