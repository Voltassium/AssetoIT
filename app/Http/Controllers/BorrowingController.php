<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'device'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Borrowings/Index', [
            'borrowings' => $borrowings
        ]);
    }

    public function create()
    {
        return Inertia::render('Borrowings/Create', [
            'devices' => Device::where('status', 'available')->get(),
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        DB::transaction(function () use ($validated) {
            Borrowing::create($validated);
            Device::where('id', $validated['device_id'])
                ->update(['status' => Device::STATUS_IN_USE]);
        });

        return redirect()->route('borrowings.index')
            ->with('message', 'Peminjaman Berhasil.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'device']);

        return Inertia::render('Borrowings/Show', [
            'borrowing' => $borrowing
        ]);
    }

    public function return(Borrowing $borrowing)
    {
    DB::transaction(function () use ($borrowing) {

        $borrowing->update([
            'actual_return_date' => now()
        ]);

        $borrowing->device->update([
            'status' => Device::STATUS_AVAILABLE
        ]);
    });

    return redirect()->back()
        ->with('message', 'Perangkat berhasil dikembalikan.');
    }
}
