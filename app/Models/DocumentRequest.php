<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'neptun',
        'document_type',
        'date_of_request',
    ];

    public function getDate()
    {
        return $this->date_of_request;
    }
}
