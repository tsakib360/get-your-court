<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'game_id',
        'field_id',
        'booking_at',
        'booking_time',
        'approve',
        'user_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'booking_at',
        'booking_time'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
