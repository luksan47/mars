<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    use HasFactory;

    const REQUESTED = 'REQUESTED';
    const APPROVED = 'APPROVED';
    const REJECTED = 'REJECTED';
    const STATES = [self::APPROVED, self::REJECTED, self::REQUESTED];

    protected $table = 'mac_addresses';

    protected $fillable = [
        'user_id', 'mac_address', 'comment', 'state', 'ip',
    ];

    protected $attributes = [
        'comment' => '',
        'state' => self::REQUESTED,
    ];

    protected $dispatchesEvents = [
        'saved' => \App\Events\MacAddressSaved::class,
        'deleted' => \App\Events\MacAddressDeleted::class,
    ];

    public function getState($value)
    {
        return strtoupper($value);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function setNextIp()
    {
        if ($this->state == MacAddress::APPROVED) {
            $last_ip = self::max('ip') ?? config('custom.physical-first-ip');
            $bytes = explode('.', $last_ip);
            if($bytes[3] == "255") {
                $bytes[2] = strval(intval($bytes[2]) + 1); // Assuming it's safe
                $bytes[3] = "1";
            } else {
                $bytes[3] = strval(intval($bytes[3]) + 1);
            }
            // TODO: if this ip reaches config('custom.physical-last-ip'), we should do something
            $this->ip =implode('.', $bytes);
            Log::info($this->ip . " is now attached to " . $this->mac_address . " for user " . $this->user->name);
        } else {
            Log::info($this->ip . " is now detached from " . $this->mac_address . " for user " . $this->user->name);
            $this->ip = null;
        }
        $this->saveQuietly();
    }
}
