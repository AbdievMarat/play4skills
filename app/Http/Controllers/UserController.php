<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('client.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $path;
        }
        if ($request->has('delete_file')) {
            if ($user->avatar) {
                Storage::delete('public/'.$user->avatar);
            }
            $data['avatar'] = null;
        }

        $data['command'] = array_filter($data['command'], fn($value) => !is_null($value));

        $user->update($data);

        return redirect()->route('assigned_tasks.index')->with('success', ['text' => 'Успешно обновлено!']);
    }
}
