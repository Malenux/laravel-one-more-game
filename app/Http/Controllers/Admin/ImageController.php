<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MongoDB\Image;
use App\Http\Requests\Admin\ImageRequest;
use App\Services\ImageService;
use App\Http\ViewComposers\Image as ImageComposer;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(private Image $image, private ImageService $imageService) {}

    public function store(ImageRequest $request)
    {
        try{
            $data = $request->validated();

            $filename = $this->imageService->uploadImage($request->file('image'));
        
            $this->image->create([
                'filename' => $filename
            ]);
        
            return response()->json([
                'imageGallery' => view('components.modal-image', ['filename' => $filename])->render(),
            ], 200);
            }
            catch(\Exception $e){
            \Debugbar::info($e->getMessage());
            return response()->json([
                'message' => \Lang::get('admin/notification.error'),
            ], 500);
        }
    }

    public function showThumb($filename)
    {
        try {
            $disk = Storage::disk('public');
            $path = "images/gallery/thumbnail/{$filename}";

            if ($disk->exists($path)) {
                return response($disk->get($path), 200)
                    ->header('Content-Type', 'image/webp');
            }

            return response()->json([
                'message' => \Lang::get('admin/notification.error'),
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => \Lang::get('admin/notification.error'),
            ], 500);
        }
    }

    public function destroy($filename)
    {
        try {
            $this->imageService->deleteImage($filename);
            $this->image->where('filename', $filename)->delete();

            ImageComposer::$composed = null;

            $images = $this->image->orderBy('created_at', 'desc')->get();

            return response()->json([
                'imageGallery' => view('components.modal-image', ['images' => $images])->render(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}