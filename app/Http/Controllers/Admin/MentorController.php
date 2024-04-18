<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Models\Mentor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MentorController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $mentors = Mentor::query()
            ->filter()
            ->paginate(20)
            ->withQueryString();

        return view('admin.mentors.index', compact('mentors'));
    }

    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.mentors.create');
    }

    public function store(StoreMentorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $message = new Mentor($data);
        $message->save();

        return redirect()->route('admin.mentors.index')->with('success', ['text' => 'Успешно добавлено!']);
    }

    public function show(Mentor $mentor): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.mentors.show', compact('mentor'));
    }

    public function edit(Mentor $mentor): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.mentors.edit', compact('mentor'));
    }

    public function update(UpdateMentorRequest $request, Mentor $mentor): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $path;
        }
        if ($request->has('delete_file')) {
            if ($mentor->avatar) {
                Storage::delete('public/' . $mentor->avatar);
            }
            $data['avatar'] = null;
        }

        $mentor->update($data);

        return redirect()->route('admin.mentors.index')->with('success', ['text' => 'Успешно обновлено!']);
    }

    public function destroy(Mentor $mentor): RedirectResponse
    {
        $mentor->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }
}
