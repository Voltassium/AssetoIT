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
        $stats = [
            'totalBorrowings' => Borrowing::whereNotNull('approved_at')->count(),
            'availableDevices' => Device::where('status', 'available')->count(),
            'damagedDevices' => Device::where('status', 'damaged')->count(),
            'activeLoans' => Borrowing::where('status', 'approved')
                ->whereNull('actual_return_date')
                ->whereNotNull('approved_at')
                ->count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'totalDevices' => Device::count(),
            'returnedToday' => Borrowing::whereDate('actual_return_date', today())
                ->whereNotNull('approved_at')
                ->count(),
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
