<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'device'])->get();
        return Inertia::render('Borrowing/Index', ['borrowings' => $borrowings]);
    }

    public function create()
    {
        return Inertia::render('Borrowing/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date',
        ]);

        Borrowing::create($validated);

        return redirect()->route('borrowing.index');
    }

    public function show(Borrowing $borrowing)
    {
        return Inertia::render('Borrowing/Show', ['borrowing' => $borrowing->load(['user', 'device'])]);
    }

    public function edit(Borrowing $borrowing)
    {
        return Inertia::render('Borrowing/Edit', ['borrowing' => $borrowing->load(['user', 'device'])]);
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date',
        ]);

        $borrowing->update($validated);

        return redirect()->route('borrowing.index');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowing.index');
    }
}
