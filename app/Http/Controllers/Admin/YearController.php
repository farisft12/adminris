<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class YearController extends Controller
{
    public function index(): View
    {
        $years = Year::orderByDesc('tahun')->paginate(20);
        return view('admin.years.index', compact('years'));
    }

    public function create(): View
    {
        return view('admin.years.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['tahun' => 'required|integer|min:2000|max:2100|unique:years,tahun']);
        Year::create(['tahun' => $request->tahun]);
        return redirect()->route('admin.years.index')->with('success', 'Tahun berhasil ditambah.');
    }

    public function edit(Year $year): View
    {
        return view('admin.years.edit', compact('year'));
    }

    public function update(Request $request, Year $year): RedirectResponse
    {
        $request->validate(['tahun' => 'required|integer|min:2000|max:2100|unique:years,tahun,' . $year->id]);
        $year->update(['tahun' => $request->tahun]);
        return redirect()->route('admin.years.index')->with('success', 'Tahun berhasil diubah.');
    }

    public function destroy(Year $year): RedirectResponse
    {
        $year->delete();
        return redirect()->route('admin.years.index')->with('success', 'Tahun berhasil dihapus.');
    }
}
