<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Services\UrlService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function get(Request $request, $url)
    {
        try {
            $url = Url::where('short_url', $url)->first();
            if ($url) {
                $url->clicks++;
                $url->save();
            }

            return Redirect::to($url->original);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'data' => 'adsf',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'original' => 'required|string|url|max:255'
        ]);

        $url = Url::where('original', $request->original)->first();

        if ($url) {
            $url->updated_at = now();
            $url->save();
        } else {
            $url = Url::create([
                'original' => $request->original,
                'short_url' => $this->urlService->shortenUrl()
            ]);
        }

        return response()->json([
            'message' => 'Url is created successfully.',
            'data' => env('APP_URL') . $url->short_url,
        ], 201);
    }
}
