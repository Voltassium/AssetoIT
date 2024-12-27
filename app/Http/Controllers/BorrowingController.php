<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class BorrowingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Borrowing::with(['user', 'device'])
            ->latest();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $borrowings = $query->paginate(10)
            ->through(function ($borrowing) {
                return array_merge($borrowing->toArray(), [
                    'status_label' => $borrowing->getStatusLabel(),
                    'status_color' => $borrowing->getStatusColor()
                ]);
            });

        return Inertia::render('Borrowings/Index', [
            'borrowings' => $borrowings,
            'isAdmin' => $user->isAdmin(),
            'reportUrl' => route('borrowings.report')
        ]);
    }

    public function create()
    {
        return Inertia::render('Borrowings/Create', [
            'devices' => Device::where('status', 'available')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
            'reason' => 'required|string|max:500', // Add this validation rule
        ]);

        // Add authenticated user's ID
        $validated['user_id'] = auth()->id();

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

    public function approve(Borrowing $borrowing)
    {
        // Update the borrowing status to approved
        $borrowing->update([
            'status' => 'approved',
        ]);

        // Update the device status to in_use
        $borrowing->device->update([
            'status' => 'in_use'
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Borrowing $borrowing)
    {
        // Delete the borrowing record
        $borrowing->delete();

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak');
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

    public function exportReport(){
    // Ambil semua data peminjaman dengan relasi ke user dan device
    $borrowings = Borrowing::with(['user', 'device'])
        ->orderBy('created_at', 'desc')
        ->get();

    // Load view laporan untuk PDF
    $pdf = Pdf::loadView('borrowings', [
        'borrowings' => $borrowings,
        'title' => 'Laporan Peminjaman Perangkat IT',
        'date' => now()->format('d-m-Y')
    ]);

    // Return file PDF untuk diunduh
    return $pdf->download('laporan_peminjaman.pdf');
    }
}
