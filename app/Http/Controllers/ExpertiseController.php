<?php

namespace App\Http\Controllers;

use App\Expertise;
use App\Http\Requests\ExpertiseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpertiseController extends Controller
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
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', Expertise::class);
        return view('expertise.index', ['expertises' => Expertise::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Expertise::class);
        return view('expertise.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpertiseRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ExpertiseRequest $request): RedirectResponse
    {
        $this->authorize('create', Expertise::class);
        try {
            Expertise::create($request->all());
        } catch (\Exception $e) {
            return redirect()->route('expertise.create')->withInput()->withErrors([$e->getMessage()]);
        }

        // todo notification
        return redirect()->route('expertise.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expertise $expertise
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Expertise $expertise): View
    {
        $this->authorize('show', $expertise);
        return view('expertise.show', ['expertise' => $expertise]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expertise $expertise
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Expertise $expertise): View
    {
        $this->authorize('edit', $expertise);
        return view('expertise.edit', ['expertise' => $expertise]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ExpertiseRequest $request
     * @param  \App\Expertise $expertise
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ExpertiseRequest $request, Expertise $expertise): RedirectResponse
    {
        $this->authorize('update', $expertise);
        try {
            $expertise->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('expertise.edit', ['id' => $expertise->id])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('expertise.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expertise $expertise
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Expertise $expertise): RedirectResponse
    {
        $this->authorize('delete', $expertise);
        try {
            $expertise->delete();
        } catch (\Exception $e) {
            return redirect()->route('expertise.edit', ['id' => $expertise->id])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('expertise.index');
    }
}
