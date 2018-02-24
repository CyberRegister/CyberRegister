<?php

namespace App\Http\Controllers;

use App\Http\Requests\PcePointRequest;
use App\PcePoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PcePointController extends Controller
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
        $this->authorize('index', PcePoint::class);
        return view('pce.index', ['pcePoints' => PcePoint::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', PcePoint::class);
        return view('pce.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PcePointRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PcePointRequest $request): RedirectResponse
    {
        $this->authorize('create', PcePoint::class);
        try {
            PcePoint::create($request->all());
        } catch (\Exception $e) {
            return redirect()->route('pcePoint.create')->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('pcePoint.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PcePoint $pcePoint
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(PcePoint $pcePoint): View
    {
        $this->authorize('show', $pcePoint);
        return view('pce.show', ['pcePoint' => $pcePoint]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PcePoint $pcePoint
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(PcePoint $pcePoint): View
    {
        $this->authorize('edit', $pcePoint);
        return view('pce.edit', ['pcePoint' => $pcePoint]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\PcePoint $pcePoint
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, PcePoint $pcePoint): RedirectResponse
    {
        $this->authorize('update', $pcePoint);
        try {
            $pcePoint->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('pcePoint.edit', ['id' => $pcePoint->id])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('pcePoint.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PcePoint $pcePoint
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(PcePoint $pcePoint): RedirectResponse
    {
        $this->authorize('delete', $pcePoint);
        try {
            $pcePoint->delete();
        } catch (\Exception $e) {
            return redirect()->route('pcePoint.edit', ['id' => $pcePoint->id])->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('pcePoint.index');
    }
}
