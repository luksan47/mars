<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'document_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
