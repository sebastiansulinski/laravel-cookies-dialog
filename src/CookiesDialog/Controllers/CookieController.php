<?php

namespace SSD\CookiesDialog\Controllers;

use Illuminate\Routing\Controller;
use SSD\CookiesDialog\Requests\CookieRequest;
use Illuminate\Http\JsonResponse;

class CookieController extends Controller
{
    /**
     * Invoke method.
     *
     * @param  \SSD\CookiesDialog\Requests\CookieRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(CookieRequest $request): JsonResponse
    {
        return response()
            ->json(['success' => true])
            ->withCookie('third_party_cookies', $request->third_party);
    }
}
