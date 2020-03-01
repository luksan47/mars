<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Note: the elements of this class should no be changed manually.
// Triggers are set up in the database (see migration).
class PrintAccountHistory extends Model
{
    protected $table = 'print_account_history';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'balance_change',
        'free_pages_change',
        'balance_change',
        'modified_by',
        'modified_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
