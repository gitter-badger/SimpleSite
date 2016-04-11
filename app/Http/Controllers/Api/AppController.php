<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends Controller
{

    public function settings(Request $request)
    {
        $content = 'window.settings = '.json_encode([
            'asset_url' => asset(''),
            'user' => $request->user(),
            'token' => csrf_token(),
            'locale' => app()->getLocale(),
            'trans' => trans('core'),
        ]);

        return $this->cacheResponse(new Response($content, 200, [
            'Content-Type' => 'text/javascript',
        ]));
    }

    /**
     * @param Response $response
     *
     * @return Response
     */
    protected function cacheResponse(Response $response)
    {
        $response->setSharedMaxAge(31536000);
        $response->setMaxAge(31536000);
        $response->setExpires(Carbon::now()->addYear(1));

        return $response;
    }
}