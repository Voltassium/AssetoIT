<?php
namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\User;
use App\Models\Borrowing;
use Inertia\Inertia;
class DashboardController extends Controller
{
    public function index()
    {
        // For now, let's use dummy data until your models are set up
        $stats = [
            'availableDevices' => 150,
            'damagedDevices' => 12,
            'activeLoans' => 45,
            'totalUsers' => 200,
            'recentBorrowings' => [],
            'recentDevices' => [],
        ];
        // When your models are ready, uncomment this:
        /*
        $stats = [
            'availableDevices' => Device::where('status', 'available')->count(),
            'damagedDevices' => Device::where('status', 'damaged')->count(),
            'activeLoans' => Borrowing::whereNull('return_date')->count(),
            'totalUsers' => User::count(),
            'recentBorrowings' => Borrowing::with(['user', 'device'])
                ->whereNull('return_date')
                ->latest()
                ->take(5)
                ->get(),
            'recentDevices' => Device::latest()
                ->take(5)
                ->get(),
        ];
        */
        return Inertia::render('Dashboard', compact('stats'));
    }
}
