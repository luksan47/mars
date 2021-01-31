<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

/** A semester is identified by a year and by it's either autumn or spring.
 * ie. a spring semester starting in february 2020 will be (2019, 2) since we write 2019/20/2.
 * The autumn semester starting in september 2020 is (2020, 1) since we write 2020/21/1.
 *
 * The status can be verified or not (by default it is not). Users with permission has to
 * confirm that the user can have the given status.
 */
class Semester extends Model
{
    use HasFactory;

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
    const DEACTIVATED = 'DEACTIVATED';
    const PASSIVE = 'PASSIVE';
    const PENDING = 'PENDING';
    const STATUSES = [
        self::ACTIVE,
        self::INACTIVE,
        self::DEACTIVATED,
        self::PASSIVE,
        self::PENDING,
    ];

    // Values are in month
    // TODO: change to dates?
    const START_OF_SPRING_SEMESTER = 2;
    const END_OF_SPRING_SEMESTER = 7;
    const START_OF_AUTUMN_SEMESTER = 8;
    const END_OF_AUTUMN_SEMESTER = 1;

    /**
     * Returns the existing semesters until the current one (included).
     */
    public static function allUntilCurrent()
    {
        return Semester::all()->filter(function ($value, $key) {
            return $value->getStartDate() < Carbon::now();
        });
    }

    /**
     * For displaying semesters.
     * Format: YYYY-YYYY-{part} separated by the SEPARATOR constant.
     */
    public function getTagAttribute(): string
    {
        return $this->year.self::SEPARATOR.($this->year + 1).self::SEPARATOR.$this->part;
    }

    /**
     * Returns a semester by a tag (eg. 2020-2021-2).
     */
    public static function byTag(string $tag): Semester
    {
        $parts = explode(self::SEPARATOR, $tag);

        return self::getOrCreate($parts[0], $parts[2]);
    }

    /**
     * Returns a semester's exact starting and ending dates.
     */
    public function datesToText(): string
    {
        return $this->getStartDate()->format('Y.m.d').'-'.$this->getEndDate()->format('Y.m.d');
    }

    public function isAutumn(): bool
    {
        return $this->part == 1;
    }

    public function isSpring(): bool
    {
        return $this->part == 2;
    }

    /**
     * Returns a semester's start date: the starting month's (based on constants) first week's last day.
     */
    public function getStartDate(): Carbon
    {
        $year = $this->year;
        $month = $this->isAutumn() ? self::START_OF_AUTUMN_SEMESTER + 1 : self::START_OF_SPRING_SEMESTER + 1;

        return Carbon::createFromDate($year, $month, 1)->endOfWeek();
    }

    /**
     * Returns a semester's end date: the month after the ending month's (based on constants) first week's last day.
     */
    public function getEndDate(): Carbon
    {
        $year = $this->year + 1; // end of semester is always in the next year
        $month = $this->isAutumn() ? self::END_OF_AUTUMN_SEMESTER + 1 : self::END_OF_SPRING_SEMESTER + 1;

        return Carbon::createFromDate($year, $month, 1)->endOfWeek();
    }

    /**
     * Returns the users with any status in the semester.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'semester_status')->withPivot(['status', 'verified', 'comment']);
    }

    /**
     * Returns the users with the specified status in the semester.
     */
    public function usersWithStatus($status)
    {
        return $this->belongsToMany(User::class, 'semester_status')
            ->wherePivot('status', '=', $status)
            ->withPivot('comment', 'verified');
    }

    /**
     * Returns the users with active status in the semester.
     */
    public function activeUsers()
    {
        return $this->usersWithStatus(self::ACTIVE);
    }

    /**
     * Decides if the given user with the given status exists in the semester.
     * @param int $user user id
     * @param string $status
     * @return true if the given user exists
     * @return false if the given user has another status or not attached to the semester
     */
    public function hasUserWith($user, $status): bool
    {
        return $this->usersWithStatus($status)->get()->contains($user);
    }

    /**
     * Decides if the given user is active in the semester.
     * @param int $user user id
     * @param string $status
     * @return true if the given user is active
     * @return false if the given user is not active or not attached to the semester
     */
    public function isActive($user)
    {
        return $this->hasUserWith($user, self::ACTIVE);
    }

    /**
     * Returns the transactions made in the semester.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'semester_id');
    }

    /**
     * Returns the transactions belonging to the checkout in the semester.
     * @param Checkout $checkout
     */
    public function transactionsInCheckout(Checkout $checkout)
    {
        return $this->transactions()->where('checkout_id', $checkout->id);
    }

    /**
     * Returns the workshop balances in the semester.
     */
    public function workshopBalances()
    {
        return $this->hasMany('App\Models\WorkshopBalance');
    }

    /**
     * Returns the current semester from cache.
     * There is always a "current" semester. If there is not in the database, this function creates it.
     */
    public static function current(): Semester
    {
        $today = Carbon::today()->format('Ymd');
        if (! Cache::get('semester.current.'.$today)) {
            $now = Carbon::now();
            if ($now->month >= self::START_OF_SPRING_SEMESTER && $now->month <= self::END_OF_SPRING_SEMESTER) {
                $part = 2;
                $year = $now->year - 1;
            } else {
                $part = 1;
                // This assumes that the semester ends in the new year.
                $year = $now->month <= self::END_OF_AUTUMN_SEMESTER ? $now->year - 1 : $now->year;
            }
            $current = Semester::getOrCreate($year, $part);

            Cache::put('semester.current.'.$today, $current, Carbon::tomorrow());
        }

        return Cache::get('semester.current.'.$today);
    }

    /**
     * Decides if the semester is equals with the current semester.
     */
    public function isCurrent(): bool
    {
        return $this->equals($this::current());
    }

    /**
     * Returns the next semester. If the next semester does not exist, creates it.
     */
    public function succ(): Semester
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

    /**
     * Returns the next semester. If the next semester does not exist, creates it.
     */
    public static function next(): Semester
    {
        return Semester::current()->succ();
    }

    /**
     * Returns the previous semester. If the previous semester does not exist, creates it.
     */
    public function pred(): Semester
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

    /**
     * Returns the previous semester. If the previous semester does not exist, creates it.
     */
    public static function previous(): Semester
    {
        return Semester::current()->pred();
    }

    /**
     * Gets or creates the semester.
     * @param int year
     * @param int part (1,2)
     * @return Semester|InvalidArgumentException
     */
    public static function getOrCreate($year, $part): Semester
    {
        if (! in_array($part, [1, 2])) {
            throw new InvalidArgumentException("The semester's part is not 1 or 2.");
        }
        $semester = Semester::firstOrCreate([
            'year' => $year,
            'part' => $part,
        ]);

        return $semester;
    }

    /**
     * Returns the color belonging to the status.
     */
    public static function colorForStatus($status): string
    {
        switch ($status) {
            case self::ACTIVE:
                return 'green';
            case self::INACTIVE:
                return 'grey';
            case self::DEACTIVATED:
                return 'brown';
            case self::PASSIVE:
                return 'orange';
            case self::PENDING:
                return 'lime';
            default:
                return 'black';
        }
    }

    /* Helpers */

    public function equals($other): bool
    {
        return $this->year == $other->year && $this->part == $other->part;
    }
}
