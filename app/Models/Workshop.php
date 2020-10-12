<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    const ANGOL = 'Angol-amerikai műhely';
    const BIOLOGIA = 'Biológia-kémia műhely';
    const BOLLOK = 'Bollók János Klasszika-filológia műhely';
    const FILOZOFIA = 'Filozófia műhely';
    const AURELION = 'Aurélien Sauvageot Francia műhely';
    const GAZDALKODASTUDOMANYI = 'Gazdálkodástudományi műhely';
    const GERMANISZTIKA = 'Germanisztika műhely';
    const INFORMATIKA = 'Informatikai műhely';
    const MAGYAR = 'Magyar műhely';
    const MATEMATIKA = 'Matematika-fizika műhely';
    const MENDOL = 'Mendöl Tibor földrajz-, föld- és környezettudományi műhely';
    const OLASZ = 'Olasz műhely';
    const ORIENTALISZTIKA = 'Orientalisztika műhely';
    const SKANDINAVISZTIKA = 'Skandinavisztika műhely';
    const SPANYOL = 'Spanyol műhely';
    const SZLAVISZTIKA = 'Szlavisztika műhely';
    const TARSADALOMTUDOMANYI = 'Társadalomtudományi műhely';
    const TORTENESZ = 'Történész műhely';

    const ALL = [
        self::ANGOL,
        self::BIOLOGIA,
        self::BOLLOK,
        self::FILOZOFIA,
        self::AURELION,
        self::GAZDALKODASTUDOMANYI,
        self::GERMANISZTIKA,
        self::INFORMATIKA,
        self::MAGYAR,
        self::MATEMATIKA,
        self::MENDOL,
        self::OLASZ,
        self::ORIENTALISZTIKA,
        self::SKANDINAVISZTIKA,
        self::SPANYOL,
        self::SZLAVISZTIKA,
        self::TARSADALOMTUDOMANYI,
        self::TORTENESZ,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'workshop_users');
    }

    public function activeMembers()
    {
        return $this->activeMembersInSemester(Semester::current());
    }

    public function activeMembersInSemester(Semester $semester)
    {
        return $this->filter(function ($user, $key) use ($semester) {
            return $user->isActiveInSemester($semester);
        });
    }

    public function residents()
    {
        return $this->users->filter(function ($user, $key) {
            return $user->isResident();
        });
    }

    public function externs()
    {
        return $this->users->filter(function ($user, $key) {
            return $user->isExtern();
        });
    }

    public function membersPayedKKTNetreg()
    {
        return $this->payedKKTNetregInSemester(Semester::current());
    }
    
    public function membersPayedKKTNetregInSemester(Semester $semester)
    {
        return $this->users->filter(function ($user, $key) use ($semester){
            return $user->isActiveIn($semester) && (!$user->hasToPayKKTNetregInSemester($semester));
        });
    }

    public function color()
    {
        switch ($this->name) {
            case self::ANGOL:
                return 'deep-purple lighten-3';
            case self::BIOLOGIA:
                return 'green lighten-2';
            case self::BOLLOK:
                return 'teal lighten-2';
            case self::FILOZOFIA:
                return 'teal accent-4';
            case self::AURELION:
                return 'lime darken-2';
            case self::GAZDALKODASTUDOMANYI:
                return 'brown lighten-2';
            case self::GERMANISZTIKA:
                return 'blue-grey lighten-2';
            case self::INFORMATIKA:
                return 'light-blue darken-4';
            case self::MAGYAR:
                return 'red lighten-2';
            case self::MATEMATIKA:
                return 'blue darken-2';
            case self::MENDOL:
                return 'cyan darken-2';
            case self::OLASZ:
                return 'red accent-3';
            case self::ORIENTALISZTIKA:
                return 'amber lighten-1';
            case self::SKANDINAVISZTIKA:
                return 'deep-orange lighten-3';
            case self::SPANYOL:
                return 'deep-purple darken-2';
            case self::SZLAVISZTIKA:
                return 'light-blue lighten-2';
            case self::TARSADALOMTUDOMANYI:
                return 'purple lighten-1';
            case self::TORTENESZ:
                return 'teal darken-4';
            default:
                return 'black';
        }
    }
}
