<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends Controller
{

    public function scripts(Request $request)
    {
        $content = "var myApp = angular.module('myApp',[]);
myApp.constant('USER', ".json_encode($request->user()).");
myApp.constant('TOKEN', ".json_encode(csrf_token()).");
myApp.constant('LOCALE', ".json_encode(app()->getLocale()).");
";

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