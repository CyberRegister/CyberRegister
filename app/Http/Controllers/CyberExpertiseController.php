<?php

namespace App\Http\Controllers;

use App\CyberExpertise;
use App\Http\Requests\CyberExpertiseStoreRequest;
use App\Http\Requests\CyberExpertiseUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CyberExpertiseController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index(): View
    {
        return view('cyber.index', ['cyberExpertises' => CyberExpertise::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', CyberExpertise::class);
        return view('cyber.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CyberExpertiseStoreRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CyberExpertiseStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', CyberExpertise::class);
        try {
            CyberExpertise::create($request->all());
        } catch (\Exception $e) {
            return redirect()->route('cyberExpertise.create')->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('cyberExpertise.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CyberExpertise $cyberExpertise
     * @return View
     */
    public function show(CyberExpertise $cyberExpertise): View
    {
        return view('cyber.show', ['cyberExpertise' => $cyberExpertise]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CyberExpertise  $cyberExpertise
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(CyberExpertise $cyberExpertise): View
    {
        $this->authorize('edit', $cyberExpertise);
        return view('cyber.edit', ['cyberExpertise' => $cyberExpertise]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CyberExpertiseUpdateRequest  $request
     * @param  \App\CyberExpertise  $cyberExpertise
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CyberExpertiseUpdateRequest $request, CyberExpertise $cyberExpertise): RedirectResponse
    {
        $this->authorize('update', $cyberExpertise);
        try {
            $cyberExpertise->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('cyberExpertise.edit', ['expertise_code' => $cyberExpertise->expertise_code])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('cyberExpertise.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CyberExpertise $cyberExpertise
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(CyberExpertise $cyberExpertise): RedirectResponse
    {
        $this->authorize('delete', $cyberExpertise);
        try {
            $cyberExpertise->delete();
        } catch (\Exception $e) {
            return redirect()->route('cyberExpertise.edit', ['expertise_code' => $cyberExpertise->expertise_code])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('cyberExpertise.index');
    }
}
