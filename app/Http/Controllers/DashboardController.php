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
        // Dummy Data Sementara
        /*
        $stats = [
            'availableDevices' => 150,
            'damagedDevices' => 12,
            'activeLoans' => 45,
            'totalUsers' => 200,
            'recentBorrowings' => [],
            'recentDevices' => [],
        ];*/


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


            return Inertia::render('Dashboard', compact('stats'));
    }

    public function userDashboard()
    {
        $user = auth()->user();

        return Inertia::render('DashboardUser', [
            'user' => $user,
            'activeBorrowings' => Borrowing::with(['device'])
                ->where('user_id', $user->id)
                ->whereNotIn('status', ['returned', 'rejected'])
                ->latest()
                ->paginate(10),
            'borrowingHistory' => Borrowing::with(['device'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['returned', 'rejected'])
                ->latest()
                ->paginate(10)
        ]);
    }
}
