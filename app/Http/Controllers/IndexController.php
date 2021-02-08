<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use function __;
use function abort;

class IndexController extends Controller
{
    public function index($slug = null): Factory|View|Application
    {
        return \view('index');
    }

    public function abort($slug = null)
    {
        abort(405, __('errors.405'));
    }
}
