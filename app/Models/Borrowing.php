<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Borrowing extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'device_id',
        'reason',
        'status',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'late_fee',
        'approved_at',
        'approved_by',
        'rejection_reason'
    ];

    const LATE_FEE_PER_DAY = 5000; // Rp 5.000 per day

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
    ];
    /**
     * Get the user who borrowed the device.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the device that was borrowed.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    /**
     * Check if the device has been returned
     */
    public function isReturned()
    {
        return !is_null($this->actual_return_date);
    }
    /**
     * Calculate the duration of the borrowing in days
     */
    public function getDurationInDays()
    {
        $endDate = $this->return_date ?? now();
        return $this->borrow_date->diffInDays($endDate);
    }
    /**
     * Scope a query to only include active borrowings.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('return_date');
    }
    /**
     * Scope a query to only include returned borrowings.
     */
    public function scopeReturned($query)
    {
        return $query->whereNotNull('return_date');
    }

    /**
     * Calculate the late fee for the borrowing
     */
    public function calculateLateFee()
    {
        if (!$this->actual_return_date || !$this->return_date) {
            return 0;
        }

        $daysLate = $this->actual_return_date->diffInDays($this->return_date, false);
        return $daysLate > 0 ? $daysLate * self::LATE_FEE_PER_DAY : 0;
    }
}
