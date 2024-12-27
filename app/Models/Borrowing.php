<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    // Define constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_RETURNED = 'returned';
    const STATUS_OVERDUE = 'overdue';

    const LATE_FEE_PER_DAY = 5000; // Rp 5.000 per hari keterlambatan

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'device_id',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'status',
        'reason',
        'rejection_reason',
        'late_fee',
        'approved_at',
        'approved_by',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'approved_at' => 'datetime',
        'late_fee' => 'decimal:2',
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
     * Get the user who approved the borrowing.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
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
        return $query->where('status', self::STATUS_APPROVED)
                    ->whereNull('actual_return_date');
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

        if ($this->actual_return_date->isBefore($this->return_date)) {
            return 0;
        }

        $daysLate = max(0, $this->actual_return_date->diffInDays($this->return_date));
        return $daysLate * self::LATE_FEE_PER_DAY;
    }

    /**
     * Get the current status of the borrowing
     */
    public function getStatus()
    {
        if ($this->actual_return_date) {
            return self::STATUS_RETURNED;
        }

        if ($this->isOverdue()) {
            return self::STATUS_OVERDUE;
        }

        return $this->status ?? self::STATUS_PENDING;
    }

    /**
     * Check if the borrowing is overdue
     */
    public function isOverdue()
    {
        if ($this->actual_return_date) {
            return $this->actual_return_date->isAfter($this->return_date);
        }

        return !$this->actual_return_date && now()->isAfter($this->return_date);
    }

    /**
     * Check if device can be returned
     */
    public function canBeReturned()
    {
        return !$this->actual_return_date && $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if borrowing can be approved
     */
    public function canBeApproved()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Get formatted late fee
     */
    public function getFormattedLateFee()
    {
        return 'Rp ' . number_format($this->calculateLateFee(), 0, ',', '.');
    }

    /**
     * Calculate days until due
     */
    public function getDaysUntilDue()
    {
        if ($this->actual_return_date) {
            return 0;
        }

        $today = now();
        if ($today->isAfter($this->return_date)) {
            return -$today->diffInDays($this->return_date); // Return negative days if overdue
        }

        return $today->diffInDays($this->return_date);
    }

    /**
     * Scope pending borrowings
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope approved borrowings
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope overdue borrowings
     */
    public function scopeOverdue($query)
    {
        return $query->where('return_date', '<', now())
                    ->whereNull('actual_return_date');
    }

    /**
     * Check if the borrowing is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the borrowing is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the borrowing is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Get the available statuses for borrowings
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_RETURNED => 'Dikembalikan',
            self::STATUS_OVERDUE => 'Terlambat'
        ];
    }

    /**
     * Get the status label
     */
    public function getStatusLabel()
    {
        return self::getStatuses()[$this->getStatus()] ?? $this->status;
    }

    /**
     * Get status color for UI
     */
    public function getStatusColor()
    {
        return match($this->getStatus()) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_RETURNED => 'blue',
            self::STATUS_OVERDUE => 'orange',
            default => 'gray'
        };
    }
}
