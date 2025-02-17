<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Url;
use App\Services\UrlService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Redirect;

class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Redirect to original url
     *
     * @param Request $request
     * @param $url
     * @return RedirectResponse
     */
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
                'message' => 'Shorten url failed: ' . $exception->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Creates shorten url
     *
     * @param StoreRequest $request
     * @return AnonymousResourceCollection
     */
    public function store(StoreRequest $request)
    {
        try {
            $request->validated();

            $url = $this->urlService->createShortUrl($request);

            return response()->json([
                'message' => 'Url is shortened successfully.',
                'data' => [
                    'short_url' => env('APP_URL') . $url->short_url,
                    'original' => $url->original,
                    'clicks' => $url->clicks
                ],
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Shorten url failed: ' . $exception->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
