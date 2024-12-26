<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AuthComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $view->with('user', Auth::user());
        }
    }
}
