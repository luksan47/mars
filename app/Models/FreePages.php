<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreePages extends Model
{
    use HasFactory;

    protected $table = 'printing_free_pages';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'amount',
        'deadline',
        'last_modified_by',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function printAccount()
    {
        return $this->belongsTo('App\Models\PrintAccount', 'user_id', 'user_id');
    }

    public function available()
    {
        return $this->deadline > date('Y-m-d');
    }

    public function lastModifiedBy()
    {
        return User::findOrFail($this->last_modified_by);
    }
}
