<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'queue_number',
        'payment_method'
    ];

    // Relasi ke user (pelanggan yang membuat pesanan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Mendapatkan nomor antrian baru
    public static function generateQueueNumber()
    {
        $lastOrder = self::orderBy('queue_number', 'desc')->first();
        return $lastOrder ? $lastOrder->queue_number + 1 : 1;
    }
}
