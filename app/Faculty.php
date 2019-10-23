<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    const AJK = "Állam- és Jogtudományi Kar";
    const BGGYK = "Bárczi Gusztáv Gyógypedagógiai Kar";
    const BTK = "Bölcsészettudományi Kar";
    const IK = "Informatikai Kar";
    const PPK = "Pedagógiai és Pszichológiai Kar";
    const TOK = "Tanító- és Óvóképző Kar";
    const TATK = "Társadalomtudományi Kar";
    const TTK = "Természettudományi Kar";

    const ALL = [
        self::AJK,
        self::BGGYK,
        self::BTK,
        self::IK,
        self::PPK,
        self::TOK,
        self::TATK,
        self::TTK,
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'faculty_users');
    }
}
