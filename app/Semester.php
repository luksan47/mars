<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/** A semester is identified by a year and by it's either autumn or spring.
 * ie. a spring semester starting in february 2020 will be (2019, 2) since we write 2019/20/2.
 * The autumn semester starting in september 2020 is (2020, 1) since we write 2020/21/1.
 *
 * The status can be verified or not (by default it is not). Users with permission has to
 * confirm that the user can have the given status.
 */
class Semester extends Model
{
    protected $table = 'semesters';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'year',
        'part',
    ];

    private const SEPARATOR = '-';

    const PARTS = [1, 2];
    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const PASSIVE = 'PASSIVE';
    const PENDING = 'PENDING';
    const STATUSES = [
        self::ACTIVE,
        self::INACTIVE,
        self::PASSIVE,
        self::PENDING,
    ];

    // Values are in month
    // TODO: change to dates?
    const START_OF_SPRING_SEMESTER = 2;
    const END_OF_SPRING_SEMESTER = 7;
    const START_OF_AUTUMN_SEMESTER = 8;
    const END_OF_AUTUMN_SEMESTER = 1;

    // For displaying semesters
    public function tag()
    {
        return $this->year.self::SEPARATOR.($this->year + 1).self::SEPARATOR.$this->part;
    }

    public function isAutumn()
    {
        return $this->part == 1;
    }

    public function isSpring()
    {
        return $this->part == 2;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'semester_status')->withPivot(['status', 'verified', 'comment']);
    }

    public function usersWithStatus($status)
    {
        return $this->belongsToMany(User::class, 'semester_status')
                    ->wherePivot('status', '=', $status)
                    ->withPivot('comment', 'verified');
    }

    public function activeUsers()
    {
        return $this->usersWithStatus(self::ACTIVE);
    }

    public function hasUserWith($user, $status)
    {
        return $this->usersWithStatus($status)->get()->contains($user);
    }

    public function isActive($user)
    {
        return $this->hasUserWith($user, self::ACTIVE);
    }

    public static function newest()
    {
        return Semester::orderBy('year', 'desc')->orderBy('part', 'desc')->first();
    }

    // There is always a "current" semester. If there is not in the database, this function creates it.
    // TODO: fine a safer method?
    public static function current()
    {
        $now = Carbon::now();
        if ($now->month >= self::START_OF_SPRING_SEMESTER && $now->month < self::END_OF_SPRING_SEMESTER) {
            $part = 2;
            $year = $now->year - 1;
        } else {
            $part = 1;
            // This assumes that the semester ends in the new year.
            $year = $now->month <= self::END_OF_AUTUMN_SEMESTER ? $now->year - 1 : $now->year;
        }

        return Semester::getOrCreate($year, $part);
    }

    public function succ()
    {
        if ($this->isSpring()) {
            $year = $this->year + 1;
            $part = 1;
        } else {
            $year = $this->year;
            $part = 2;
        }

        return Semester::getOrCreate($year, $part);
    }

    public static function next()
    {
        return Semester::current()->succ();
    }

    public function pred()
    {
        if ($this->isSpring()) {
            $year = $this->year;
            $part = 1;
        } else {
            $year = $this->year - 1;
            $part = 2;
        }

        return Semester::getOrCreate($year, $part);
    }

    public static function previous()
    {
        return Semester::current()->pred();
    }

    public static function getOrCreate($year, $part)
    {
        $semester = Semester::all()->where('year', $year)->where('part', $part)->first();
        if ($semester === null) {
            $semester = Semester::create([
                'year' => $year,
                'part' => $part,
            ]);
        }

        return $semester;
    }
}
