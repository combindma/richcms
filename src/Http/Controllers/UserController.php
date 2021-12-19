<?php

namespace Combindma\Richcms\Http\Controllers;

use Combindma\Richcms\Http\Requests\UserRequest;
use Combindma\Richcms\ModelFilters\UserFilter;
use Combindma\Richcms\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController
{
    public function index(Request $request)
    {
        $users = User::filter($request->all(), UserFilter::class)
            ->latest('id')
            ->with(['roles'])
            ->paginate(10);

        return view('richcms::users.index', compact('users'));
    }

    public function create()
    {
        return view('richcms::users.create', ['user' => new User()]);
    }

    public function show(User $user)
    {
        return view('richcms::users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('richcms::users.edit', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        if ($request->send_email) {
            $user->sendNewAccountNotification($request->validated()['password']);
        }

        flash('Ajout effectué avec succès');

        return redirect(route('richcms::users.index'));
    }

    public function update(UserRequest $request, User $user)
    {
        $validatedData = Arr::except($request->validated(), ['password', 'role', 'send_email']);
        $user->update($validatedData);
        if ($request->filled('password')) {
            $user->updatePassword($request->password);
            if ($request->send_email) {
                $user->sendNewPasswordNotification($request->validated()['password']);
            }
        }
        $user->syncRoles($request->input('role'));
        $user->save();
        flash('Enregistrement effectué avec succès');

        return back();
    }

    public function activer(User $user)
    {
        $user->activer();
        flash('Compte activé avec succès');

        return back();
    }

    public function desactiver(User $user)
    {
        $user->desactiver();
        flash('Compte desactivé avec succès');

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash('Compte supprimé avec succès');

        return back();
    }

    public function restore($id)
    {
        User::withTrashed()->where('id', $id)->restore();
        flash('Compte restauré avec succès');

        return back();
    }
}
