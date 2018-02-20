<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            User::create([
                'cyber_code' => $request->cyber_code,
                'first_name' =>  $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('users.create')->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return View
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        try {
            $user->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('users.edit', ['cyber_code' => $user->cyber_code])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->route('users.edit', ['cyber_code' => $user->cyber_code])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('users.index');
    }
}
