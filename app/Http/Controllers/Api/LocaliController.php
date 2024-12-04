<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Locali;
use Illuminate\Http\Request;

class LocaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locali = Locali::all();

        return view('welcome', compact('locali'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $local_id = $request->id;
        $locale = Locali::findOrFail($local_id);
        $locale->delete();
        return redirect()->route('locali.index')->with('success', 'Locale eliminato con successo.');


    }
}
