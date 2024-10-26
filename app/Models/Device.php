<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Device extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'manufacturer',
        'status',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
    ];
    /**
     * Status constants
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_USE = 'in_use';
    const STATUS_DAMAGED = 'damaged';
    /**
     * Get all possible status values
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_AVAILABLE,
            self::STATUS_IN_USE,
            self::STATUS_DAMAGED,
        ];
    }
    /**
     * Get all borrowings for the device.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    /**
     * Get all users who have borrowed this device.
     */
    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'borrowings')
            ->withPivot('borrow_date', 'return_date')
            ->withTimestamps();
    }
    /**
     * Check if the device is currently borrowed
     */
    public function isCurrentlyBorrowed()
    {
        return $this->status === self::STATUS_IN_USE;
    }
    /**
     * Check if the device is damaged
     */
    public function isDamaged()
    {
        return $this->status === self::STATUS_DAMAGED;
    }
    /**
     * Check if the device is available
     */
    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }
    /**
     * Get the current borrowing record if the device is borrowed
     */
    public function getCurrentBorrowing()
    {
        return $this->borrowings()
            ->
whereNull('return_date')
            ->latest('borrow_date')
            ->first();
    }
}
