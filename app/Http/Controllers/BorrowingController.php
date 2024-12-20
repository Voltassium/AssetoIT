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

        // jika user admin, menampilkan semua peminjaman
        if ($user->isAdmin()) {
            $borrowings = Borrowing::with(['user', 'device'])
                ->latest()
                ->paginate(10);
        }
        // jika user yang login, hanya menampilkan peminjaman yang dia lakukan
        else {
            $borrowings = Borrowing::with(['user', 'device'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

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
            'reason' => 'required|string|min:10',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        DB::transaction(function () use ($validated) {
            Borrowing::create($validated);
        });

        return redirect()->route('borrowings.index')
            ->with('message', 'Borrowing request submitted for approval.');
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
        $borrowing->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        $borrowing->device->update(['status' => Device::STATUS_IN_USE]);
        return redirect()->back()
            ->with('message', 'permintaan peminjaman telah disetujui.');
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        DB::transaction(function () use ($borrowing, $validated) {
            // Update device status back to available
            $borrowing->device->update([
                'status' => Device::STATUS_AVAILABLE
            ]);

            // Delete the borrowing record
            $borrowing->delete();
        });

        return redirect()->back()
            ->with('message', 'permintaan peminjaman telah ditolak.');
    }

    public function return(Borrowing $borrowing)
    {
        if ($borrowing->status === 'pending') {
            return redirect()->back()
                ->with('error', 'Tidak bisa mengembalikan perangkat ketika sedang pending.');
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->actual_return_date = now();
            $borrowing->late_fee = $borrowing->calculateLateFee();
            $borrowing->status = 'returned';
            $borrowing->save();

            $borrowing->device->update([
                'status' => Device::STATUS_AVAILABLE
            ]);
        });

        return redirect()->back()
            ->with('message', sprintf(
                'Device returned successfully. %s',
                $borrowing->late_fee > 0 ? "Late fee: Rp " . number_format($borrowing->late_fee, 0, ',', '.') : ''
            ));
    }

    public function exportReport()
    {
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
        return $pdf->stream('laporan_peminjaman.pdf');
    }
}
