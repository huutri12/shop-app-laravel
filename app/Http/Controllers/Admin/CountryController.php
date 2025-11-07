<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $countries = Country::when($q, fn($s) => $s->where('name', 'like', "%{$q}%"))
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.country.index', compact('countries', 'q'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        Country::create(['name' => $request->name]);
        return redirect()->route('admin.country.index')->with('success', 'Create successfully');
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
        $country = Country::findOrFail($id);
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update(['name' => $request->name]);
        return redirect()->route('admin.country.index')->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::findOrFail($id)->delete();
        return redirect()->route('admin.country.index')->with('success', 'Delete successfully');
    }
}
