<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Localization extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($locale)
    {
        if(!in_array($locale,config('localization.locals'))){
            abort(400);
        }
        session(['localization' => $locale]);
        return redirect()->back();
    }
}
