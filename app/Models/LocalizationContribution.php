<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalizationContribution extends Model
{
    protected $table = 'localization_contributions';

    protected $fillable = [
        'language', 'key', 'value', 'contributor_id', 'approved',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'approved' => false,
    ];

    public function contributor()
    {
        return $this->belongsTo('App\User', 'contributor_id');
    }
}
