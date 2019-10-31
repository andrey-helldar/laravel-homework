<?php

namespace App\Contracts;

use Illuminate\View\View;

interface ViewComposer
{
    public function compose(View $view);
}
