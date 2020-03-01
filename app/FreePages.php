<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreePages extends Model
{
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

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function printAccount() {
        return $this->belongsTo('App\PrintAccount', 'user_id', 'user_id');
    }
}
