<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalizationContribution extends Model
{
    protected $table = 'localization_contributions';

    protected $fillable = [
        'key', 'value', 'contributor_id',
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

    public function approve()
    {
        //TODO
        //Artisan::call('...')

        $this->approved = true;
    }
}
