<?php

namespace App\Http\Controllers;

use App\Expertise;
use App\Http\Requests\ExpertiseRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the Expertises.
     *
     * @throws AuthorizationException
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('index', Expertise::class);

        return view('expertise.index', ['expertises' => Expertise::all()]);
    }

    /**
     * Show the form for creating a new Expertise.
     *
     * @throws AuthorizationException
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', Expertise::class);

        return view('expertise.create');
    }

    /**
     * Store a newly created Expertise in storage.
     *
     * @param ExpertiseRequest $request
     *
     * @throws AuthorizationException
     *
     * @return RedirectResponse
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
     * Display the specified Expertise.
     *
     * @param Expertise $expertise
     *
     * @throws AuthorizationException
     *
     * @return View
     */
    public function show(Expertise $expertise): View
    {
        $this->authorize('show', $expertise);

        return view('expertise.show', ['expertise' => $expertise]);
    }

    /**
     * Show the form for editing the specified Expertise.
     *
     * @param Expertise $expertise
     *
     * @throws AuthorizationException
     *
     * @return View
     */
    public function edit(Expertise $expertise): View
    {
        $this->authorize('edit', $expertise);

        return view('expertise.edit', ['expertise' => $expertise]);
    }

    /**
     * Update the specified Expertise in storage.
     *
     * @param ExpertiseRequest $request
     * @param Expertise        $expertise
     *
     * @throws AuthorizationException
     *
     * @return RedirectResponse
     */
    public function update(ExpertiseRequest $request, Expertise $expertise): RedirectResponse
    {
        $this->authorize('update', $expertise);

        try {
            $expertise->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route(
                'expertise.edit', ['id' => $expertise->id]
            )->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('expertise.index');
    }

    /**
     * Remove the specified Expertise from storage.
     *
     * @param Expertise $expertise
     *
     * @throws AuthorizationException
     *
     * @return RedirectResponse
     */
    public function destroy(Expertise $expertise): RedirectResponse
    {
        $this->authorize('delete', $expertise);

        try {
            $expertise->delete();
        } catch (\Exception $e) {
            return redirect()->route('expertise.edit', ['id' => $expertise->id])
                ->withInput()->withErrors([$e->getMessage()]);
        }
        // todo notification
        return redirect()->route('expertise.index');
    }
}
