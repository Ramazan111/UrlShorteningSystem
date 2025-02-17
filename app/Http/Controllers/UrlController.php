<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;
use App\Services\UrlService;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UrlController extends Controller
{
    use AuthorizesRequests;

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
            $url = Url::where('short_url', 'S/' . $url)->first();

            if (Carbon::parse($url->expire_at)->isBefore(Carbon::now())) {
                return Inertia::render('Error', [
                    'message' => 'Page not found',
                    'data' => null,
                ]);
            }

            if ($url) {
                $url->clicks++;
                $url->save();
            }

            return Redirect::to($url->original);
        } catch (Exception $exception) {
            return Inertia::render('Error', [
                'message' => 'Shorten url failed: ' . $exception->getMessage(),
                'data' => null,
            ]);
        }
    }

    /**
     * Url list
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            return UrlResource::collection(Auth::user()->urls()->paginate(10));
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

    /**
     * Updates shorten url expire date
     *
     * @param StoreRequest $request
     * @return AnonymousResourceCollection
     */
    public function update(Request $request, Url $url)
    {
        try {
            $request->validate([
                'expire_at' => 'date'
            ]);

            $url->update([
                'expire_at' => $request->expire_at
            ]);

            return response()->json([
                'message' => 'Url is updated successfully.',
                'data' => [
                    'url' => $url
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
