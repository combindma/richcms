<?php

namespace Combindma\Richcms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RichcmsController extends Controller
{
    public function updateSettings(Request $request)
    {
        option()->putMany($request->except(['_token', '_method']));
        flash('Enregistrement effectué avec succès');

        return back();
    }

    public function clearCache()
    {
        if (app()->environment('local')) {
            Artisan::call('optimize:clear');
        }

        if (app()->environment('production')) {
            Artisan::call('cache:clear');
        }

        return redirect()->route('home');
    }
}
