<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a User search box.
     *
     * @return View
     */
    public function index(): View
    {
        return view('users.index', ['users' => [], 'q' => '']);
    }

    /**
     * Display a listing of the Users.
     *
     * @param UserSearchRequest $request
     * @return View
     */
    public function search(UserSearchRequest $request): View
    {
        $users = User::with(['expertises' => function ($query) {
            $query->where('cyber_expertise_id', 1);
        }])
            ->where('cyber_code', 'like', '%'.$request->q.'%')
            ->orWhere('first_name', 'like', '%'.$request->q.'%')
            ->orWhere('last_name', 'like', '%'.$request->q.'%')
            ->get();

        return view('users.index', ['users' => $users, 'q' => $request->q]);
    }

    /**
     * Show the form for creating a new User.
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            User::create(
                [
                'cyber_code'     => $request->cyber_code,
                'first_name'     => $request->first_name,
                'middle_name'    => $request->middle_name,
                'last_name'      => $request->last_name,
                'date_of_birth'  => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'email'          => $request->email,
                'password'       => bcrypt($request->password),
                ]
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('users.create')->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Display the specified User.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param User $user
     * @throws AuthorizationException
     * @return View
     */
    public function edit(User $user): View
    {
        $this->authorize('edit', $user);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param UserUpdateRequest $request
     * @param User         $user
     * @throws AuthorizationException
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        try {
            $user->update($request->all());
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $user->photo = Image::make($request->file('file')->getRealPath())->encode('data-url');
                $user->save();
            }
        } catch (\Exception $e) {
            return redirect()->route('users.edit', ['cyber_code' => $user->cyber_code])
                ->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param User $user
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->route('users.edit', ['cyber_code' => $user->cyber_code])
                ->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }
}
