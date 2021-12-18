<?php

namespace Combindma\Richcms\Http\Controllers;


use Combindma\Richcms\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController
{
    public function index()
    {
        return view('richcms::pages.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->validated()['name'];
        $user->email = $request->validated()['email'];
        if ($request->filled('password'))
        {
            $user->password = Hash::make($request->validated()['password']);
        }
        $user->save();

        flash('Enregistrement effectué avec succès');
        return back();
    }
}
