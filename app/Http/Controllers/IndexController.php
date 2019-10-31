<?php

namespace App\Http\Controllers;

use function api_response;
use function trans;

class IndexController extends Controller
{
    public function index($slug = null)
    {
        return view('index');
    }

    public function abort($slug = null)
    {
        $message = trans('errors.405');

        return api_response($message, 405);
    }
}
