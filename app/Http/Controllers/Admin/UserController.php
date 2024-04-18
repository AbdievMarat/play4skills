<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Mentor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::with('roles', 'mentor')
            ->filter()
            ->paginate(10)
            ->withQueryString();
        $mentors = Mentor::query()->pluck('name', 'id')->all();

        return view('admin.users.index', compact('users', 'mentors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $roles = Role::query()->pluck('description', 'id')->all();
        $mentors = Mentor::query()->pluck('name', 'id')->all();

        return view('admin.users.create', compact('roles', 'mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->get('password'));
        $data['decrypted_password'] = $request->get('password');
        $data['command'] = array_filter($data['command'], fn($value) => !is_null($value));

        $user = new User($data);
        $user->save();

        if ($request->has('role_id')) {
            $user->roles()->sync($request->get('role_id'));
        }

        return redirect()->route('admin.users.index')->with('success', ['text' => 'Успешно добавлено!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('update', $user);

        $roles = Role::query()->pluck('description', 'id')->all();
        $mentors = Mentor::query()->pluck('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->get('password'));
            $data['decrypted_password'] = $request->get('password');
        }
        $data['command'] = array_filter($data['command'], fn($value) => !is_null($value));

        $user->update($data);

        if ($request->has('role_id')) {
            $user->roles()->sync($request->get('role_id'));
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('admin.users.index')->with('success', ['text' => 'Успешно обновлено!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }
}
