<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function userCounts($user)
    {
        $countFavorites = $user->favorites()->count();
        return ['countFavorites' => $countFavorites];
    }

    protected function errorResponse($message, $statusCode)
    {
        return response()->view('errors.error-page', ['message' => $message], $statusCode);
    }
}
