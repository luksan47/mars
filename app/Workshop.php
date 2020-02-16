<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    const ANGOL = "Angol-amerikai műhely";
    const BIOLOGIA = "Biológia-kémia műhely";
    const BOLLOK = "Bollók János Klasszika-filológia műhely";
    const FILOZOFIA = "Filozófia műhely";
    const AURELION = "Aurélien Sauvageot Francia műhely";
    const GERMANISZTIKA = "Germanisztika műhely";
    const INFORMATIKA = "Informatika műhely";
    const MAGYAR = "Magyar műhely";
    const MATEMATIKA = "Matematika-fizika műhely";
    const MENDOL = "Mendöl Tibor földrajz-, föld- és környezettudományi műhely";
    const OLASZ = "Olasz műhely";
    const ORIENTALISZTIKA = "Orientalisztika műhely";
    const SKANDINAVISZTIKA = "Skandinavisztika műhely";
    const SPANYOL = "Spanyol műhely";
    const SZLAVISZTIKA = "Szlavisztika műhely";
    const TARSADALOMTUDOMANYI = "Társadalomtudományi műhely";
    const TORTENESZ = "Történész műhely";

    const ALL = [
        self::ANGOL,
        self::BIOLOGIA,
        self::BOLLOK,
        self::FILOZOFIA,
        self::AURELION,
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

    public function users() {
        return $this->belongsToMany(User::class, 'workshop_users');
    }
}
