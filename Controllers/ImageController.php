<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Traits\ResponseTrait;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    use ResponseTrait;

    /**
     * @param Request $request
     * @param $id
     * @param $image
     * @param $width
     * @param $height
     * @param $crop
     * @param $format
     * @return JsonResponse|BinaryFileResponse
     */
    public function resize(Request $request, $id, $image, $width, $height, $crop, $format)
    {
        $validator = Validator::make($request->route()->parameters, [
            'id' => 'required|int',
            'image' => 'required|string',
            'width' => 'required|integer|min:1|max:1920',
            'height' => 'required|integer|min:1|max:1080',
            'crop' => 'required|integer|between:0,1',
            'format' => 'required|in:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $path = public_path(ImageService::getImagePath($id, $image, $format));
        if (file_exists(($path))) {
            return response()->file(ImageService::resizeImage($path, $width, $height, $crop));
        }

        return $this->invalidate(trans('messages.image not found'));
    }
}
