<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    const PERMISSION_WORKSHOP_ENGLISH = 'w_english';
    const PERMISSION_WORKSHOP_BIO_CHEM = 'w_bio_chem';
    const PERMISSION_WORKSHOP_FILOLOGY = 'w_filology';
    const PERMISSION_WORKSHOP_PHILOSOPHY = 'w_philosophy';
    const PERMISSION_WORKSHOP_FRENCH = 'w_french';
    const PERMISSION_WORKSHOP_GERMAN = 'w_german';
    const PERMISSION_WORKSHOP_INFORMATICS_WITH_AN_I = 'w_informatics';
    const PERMISSION_WORKSHOP_HUNGARIAN = 'w_hungarian';
    const PERMISSION_WORKSHOP_MATH_PHYSICS = 'w_math_physics';
    const PERMISSION_WORKSHOP_GEOGRAPHY = 'w_geography';
    const PERMISSION_WORKSHOP_ITALIAN = 'w_italan';
    const PERMISSION_WORKSHOP_ORIENTAL = 'w_oriental';
    const PERMISSION_WORKSHOP_SCANDINAVIAN = 'w_scandinavian';
    const PERMISSION_WORKSHOP_SPANISH = 'w_spanish';
    const PERMISSION_WORKSHOP_SLAV = 'w_slav';
    const PERMISSION_WORKSHOP_SOCIAL = 'w_social';
    const PERMISSION_WORKSHOP_HISTORY = 'w_history';
    const PERMISSION_WORKSHOP_ECONOMY = 'w_economy';

    const NAME_WORKSHOP_ENGLISH = 'Angol-Amerikai műhely';
    const NAME_WORKSHOP_BIO_CHEM = 'Biológia-Kémia műhely';
    const NAME_WORKSHOP_FILOLOGY = 'Klasszika-filológia műhely';
    const NAME_WORKSHOP_PHILOSOPHY = 'Filozófia műhely';
    const NAME_WORKSHOP_FRENCH = 'Francia műhely';
    const NAME_WORKSHOP_GERMAN = 'Germanisztika műhely';
    const NAME_WORKSHOP_INFORMATICS_WITH_AN_I = 'Informatikai műhely';
    const NAME_WORKSHOP_HUNGARIAN = 'Magyar műhely';
    const NAME_WORKSHOP_MATH_PHYSICS = 'Matematika-Fizika műhely';
    const NAME_WORKSHOP_GEOGRAPHY = 'Földrajz-Földtud.-Környezettud. műhely';
    const NAME_WORKSHOP_ITALIAN = 'Olasz műhely';
    const NAME_WORKSHOP_ORIENTAL = 'Orientalisztika műhely';
    const NAME_WORKSHOP_SCANDINAVIAN = 'Skandinavisztika műhely';
    const NAME_WORKSHOP_SPANISH = 'Spanyol műhely';
    const NAME_WORKSHOP_SLAV = 'Szlavisztika műhely';
    const NAME_WORKSHOP_SOCIAL = 'Társadalomtudományi műhely';
    const NAME_WORKSHOP_HISTORY = 'Történész műhely';
    const NAME_WORKSHOP_ECONOMY = 'Gazdálkodástudományi műhely';

    public static function cast_workshop_code_to_url(string $workshop_code): string
    {
        //TODO: maybe make this better
        return str_replace('_', '-', substr($workshop_code, 2));
    }

    public static function cast_workshop_url_to_code(string $workshop_url): string
    {
        return 'w_'.str_replace('-', '_', $workshop_url);
    }

    public static function cast_permission_code_to_url(string $workshop_code): string
    {
        //TODO: maybe make this better
        return str_replace('_', '-', substr($workshop_code, 2));
    }

    public static function cast_persmission_url_to_code(string $workshop_url): string
    {
        return 'p_'.str_replace('-', '_', $workshop_url);
    }

    public static function id_permission_code_exist(string $permission_code): bool
    {
        return key_exists($permission_code, self::PERMISSIONS);
    }

    /*
        const ADMINISTRATION_PERMISSIONS = [
            self::PERMISSION_LIST_FINAL_APPLICATIONS,
            self::PERMISSION_LIST_INPROGRESS_APPLICATIONS,
        ];

       const WORKSHOP_PERMISSIONS = [
            self::PERMISSION_WORKSHOP_ENGLISH,
            self::PERMISSION_WORKSHOP_BIO_CHEM,
            self::PERMISSION_WORKSHOP_FILOLOGY,
            self::PERMISSION_WORKSHOP_PHILOSOPHY,
            self::PERMISSION_WORKSHOP_FRENCH,
            self::PERMISSION_WORKSHOP_GERMAN,
            self::PERMISSION_WORKSHOP_INFORMATICS_WITH_AN_I,
            self::PERMISSION_WORKSHOP_HUNGARIAN,
            self::PERMISSION_WORKSHOP_MATH_PHYSICS,
            self::PERMISSION_WORKSHOP_GEOGRAPHY,
            self::PERMISSION_WORKSHOP_ITALIAN,
            self::PERMISSION_WORKSHOP_ORIENTAL,
            self::PERMISSION_WORKSHOP_SCANDINAVIAN,
            self::PERMISSION_WORKSHOP_SPANISH,
            self::PERMISSION_WORKSHOP_SLAV,
            self::PERMISSION_WORKSHOP_SOCIAL,
            self::PERMISSION_WORKSHOP_HISTORY,
            self::PERMISSION_WORKSHOP_ECONOMY,
        ];

        const PERMISSIONS_NAMES = [
            self::PERMISSION_LIST_FINAL_APPLICATIONS => 'Véglegesített jelentkezések megtekintése',
            self::PERMISSION_LIST_INPROGRESS_APPLICATIONS => 'Folyamatbanlévő jelentkezések megtekintése',

            self::PERMISSION_WORKSHOP_ENGLISH => 'Angol-Amerikai műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_BIO_CHEM => 'Biológia-Kémia műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_FILOLOGY => 'Klasszika-filológia műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_PHILOSOPHY => 'Filozófia műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_FRENCH => 'Francia műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_GERMAN => 'Germanisztika műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_INFORMATICS_WITH_AN_I => 'Informatikai műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_HUNGARIAN => 'Magyar műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_MATH_PHYSICS => 'Matematika-Fizika műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_GEOGRAPHY => 'Földrajz-Földtud.-Környezettud. műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_ITALIAN => 'Olasz műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_ORIENTAL => 'Orientalisztika műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_SCANDINAVIAN => 'Skandinavisztika műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_SPANISH => 'Spanyol műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_SLAV => 'Szlavisztika műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_SOCIAL => 'Társadalomtudományi műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_HISTORY => 'Történész műhely listájának megtekintése',
            self::PERMISSION_WORKSHOP_ECONOMY => 'Gazdálkodástudományi műhely listájának megtekintése',
        ];

        const PERMISSIONS_NAMES_SHORT = [
            self::PERMISSION_LIST_FINAL_APPLICATIONS => 'Véglegesített jelentkezések',
            self::PERMISSION_LIST_INPROGRESS_APPLICATIONS => 'Folyamatbanlévő jelentkezések',

            self::PERMISSION_WORKSHOP_ENGLISH => self::NAME_WORKSHOP_ENGLISH,
            self::PERMISSION_WORKSHOP_BIO_CHEM => self::NAME_WORKSHOP_BIO_CHEM,
            self::PERMISSION_WORKSHOP_FILOLOGY => self::NAME_WORKSHOP_FILOLOGY,
            self::PERMISSION_WORKSHOP_PHILOSOPHY => self::NAME_WORKSHOP_PHILOSOPHY,
            self::PERMISSION_WORKSHOP_FRENCH => self::NAME_WORKSHOP_FRENCH,
            self::PERMISSION_WORKSHOP_GERMAN => self::NAME_WORKSHOP_GERMAN,
            self::PERMISSION_WORKSHOP_INFORMATICS_WITH_AN_I => self::NAME_WORKSHOP_INFORMATICS_WITH_AN_I,
            self::PERMISSION_WORKSHOP_HUNGARIAN => self::NAME_WORKSHOP_HUNGARIAN,
            self::PERMISSION_WORKSHOP_MATH_PHYSICS => self::NAME_WORKSHOP_MATH_PHYSICS,
            self::PERMISSION_WORKSHOP_GEOGRAPHY => self::NAME_WORKSHOP_GEOGRAPHY,
            self::PERMISSION_WORKSHOP_ITALIAN => self::NAME_WORKSHOP_ITALIAN,
            self::PERMISSION_WORKSHOP_ORIENTAL => self::NAME_WORKSHOP_ORIENTAL,
            self::PERMISSION_WORKSHOP_SCANDINAVIAN => self::NAME_WORKSHOP_SCANDINAVIAN,
            self::PERMISSION_WORKSHOP_SPANISH => self::NAME_WORKSHOP_SPANISH,
            self::PERMISSION_WORKSHOP_SLAV => self::NAME_WORKSHOP_SLAV,
            self::PERMISSION_WORKSHOP_SOCIAL => self::NAME_WORKSHOP_SOCIAL,
            self::PERMISSION_WORKSHOP_HISTORY => self::NAME_WORKSHOP_HISTORY,
            self::PERMISSION_WORKSHOP_ECONOMY => self::NAME_WORKSHOP_ECONOMY,
        ];


        const WORKSHOPS_OLD = [
            self::PERMISSION_WORKSHOP_ENGLISH => self::NAME_WORKSHOP_ENGLISH,
            self::PERMISSION_WORKSHOP_BIO_CHEM => self::NAME_WORKSHOP_BIO_CHEM,
            self::PERMISSION_WORKSHOP_FILOLOGY => self::NAME_WORKSHOP_FILOLOGY,
            self::PERMISSION_WORKSHOP_PHILOSOPHY => self::NAME_WORKSHOP_PHILOSOPHY,
            self::PERMISSION_WORKSHOP_FRENCH => self::NAME_WORKSHOP_FRENCH,
            self::PERMISSION_WORKSHOP_GERMAN => self::NAME_WORKSHOP_GERMAN,
            self::PERMISSION_WORKSHOP_INFORMATICS_WITH_AN_I => self::NAME_WORKSHOP_INFORMATICS_WITH_AN_I,
            self::PERMISSION_WORKSHOP_HUNGARIAN => self::NAME_WORKSHOP_HUNGARIAN,
            self::PERMISSION_WORKSHOP_MATH_PHYSICS => self::NAME_WORKSHOP_MATH_PHYSICS,
            self::PERMISSION_WORKSHOP_GEOGRAPHY => self::NAME_WORKSHOP_GEOGRAPHY,
            self::PERMISSION_WORKSHOP_ITALIAN => self::NAME_WORKSHOP_ITALIAN,
            self::PERMISSION_WORKSHOP_ORIENTAL => self::NAME_WORKSHOP_ORIENTAL,
            self::PERMISSION_WORKSHOP_SCANDINAVIAN => self::NAME_WORKSHOP_SCANDINAVIAN,
            self::PERMISSION_WORKSHOP_SPANISH => self::NAME_WORKSHOP_SPANISH,
            self::PERMISSION_WORKSHOP_SLAV => self::NAME_WORKSHOP_SLAV,
            self::PERMISSION_WORKSHOP_SOCIAL => self::NAME_WORKSHOP_SOCIAL,
            self::PERMISSION_WORKSHOP_HISTORY => self::NAME_WORKSHOP_HISTORY,
            self::PERMISSION_WORKSHOP_ECONOMY => self::NAME_WORKSHOP_ECONOMY,
        ];*/

    const WORKSHOP_TYPE_DOGESZ = 't_dogesz';
    const WORKSHOP_TYPE_BOLCSESZ = 't_bolcsesz';

    const WORKSHOP_TYPES = [
        self::WORKSHOP_TYPE_DOGESZ,
        self::WORKSHOP_TYPE_BOLCSESZ,
    ];

    const PERMISSION_LIST_FINAL_APPLICATIONS = 'p_list_final_applications';
    const PERMISSION_LIST_INPROGRESS_APPLICATIONS = 'p_list_inprogress_applications';
    const PERMISSION_LIST_USERS = 'p_list_users';

    const PERMISSIONS = [
        /* 'code' => [
            'name_short'    => '',
            'name'          => '',
            'type'          => '',
        ], */

        self::PERMISSION_LIST_FINAL_APPLICATIONS => [
            'name'  => 'Véglegesített jelentkezések megtekintése',
            'type'  => 'primary',
        ],
        self::PERMISSION_LIST_INPROGRESS_APPLICATIONS => [
            'name'  => 'Folyamatbanlévő jelentkezések megtekintése',
            'type'  => 'primary',
        ],
        self::PERMISSION_LIST_USERS => [
            'name'  => 'Felvételiztetők megtekintése',
            'type'  => 'primary',
        ],

        'w_english' => [
            'name'  => 'Angol-Amerikai műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_bio_chem' => [
            'name'  => 'Biológia-Kémia műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_filology' => [
            'name'  => 'Klasszika-filológia műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_philosophy' => [
            'name'  => 'Filozófia műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_french' => [
            'name'  => 'Francia műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_german' => [
            'name'  => 'Germanisztika műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_informatics' => [
            'name'  => 'Informatikai műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_hungarian' => [
            'name'  => 'Magyar műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_math_physics' => [
            'name'  => 'Matematika-Fizika műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_geography' => [
            'name'  => 'Földrajz-Földtud.-Környezettud. műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_italan' => [
            'name'  => 'Olasz műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_oriental' => [
            'name'  => 'Orientalisztika műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_scandinavian' => [
            'name'  => 'Skandinavisztika műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_spanish' => [
            'name'  => 'Spanyol műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_slav' => [
            'name'  => 'Szlavisztika műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_social' => [
            'name'  => 'Társadalomtudományi műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_history' => [
            'name'  => 'Történész műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
        'w_economy' => [
            'name'  => 'Gazdálkodástudományi műhely listájának megtekintése',
            'type'  => 'secondary',
        ],
    ];

    const LISTS = [
        /* 'local_code' => [
            'permission_code' => '',
            'name' => '',
            'route' => '',
        ], */

        self::PERMISSION_LIST_FINAL_APPLICATIONS => [
            'permission_code'   => self::PERMISSION_LIST_FINAL_APPLICATIONS,
            'name'              => 'Véglegesített jelentkezések',
            'route_name'        => 'user.list.applications.final',
        ],
        self::PERMISSION_LIST_INPROGRESS_APPLICATIONS => [
            'permission_code'   => self::PERMISSION_LIST_INPROGRESS_APPLICATIONS,
            'name'              => 'Folyamatbanlévő jelentkezések',
            'route_name'        => 'user.list.applications.inprogress',
        ],
        self::PERMISSION_LIST_USERS => [
            'permission_code'   => self::PERMISSION_LIST_USERS,
            'name'              => 'Felvételiztetők',
            'route_name'        => 'user.list.users',
        ],
    ];

    const WORKSHOPS = [
        /* 'local_code' => [
            'permission_code' => '',
            'name' => '',
            'type' => '',
        ], */

        'w_english' => [
            'permission_code' => 'w_english',
            'name' => 'Angol-Amerikai műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_bio_chem' => [
            'permission_code' => 'w_bio_chem',
            'name' => 'Biológia-Kémia műhely',
            'type' => self::WORKSHOP_TYPE_DOGESZ,
        ],
        'w_filology' => [
            'permission_code' => 'w_filology',
            'name' => 'Klasszika-filológia műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_philosophy' => [
            'permission_code' => 'w_philosophy',
            'name' => 'Filozófia műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_french' => [
            'permission_code' => 'w_french',
            'name' => 'Francia műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_german' => [
            'permission_code' => 'w_german',
            'name' => 'Germanisztika műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_informatics' => [
            'permission_code' => 'w_informatics',
            'name' => 'Informatikai műhely',
            'type' => self::WORKSHOP_TYPE_DOGESZ,
        ],
        'w_hungarian' => [
            'permission_code' => 'w_hungarian',
            'name' => 'Magyar műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_math_physics' => [
            'permission_code' => 'w_math_physics',
            'name' => 'Matematika-Fizika műhely',
            'type' => self::WORKSHOP_TYPE_DOGESZ,
        ],
        'w_geography' => [
            'permission_code' => 'w_geography',
            'name' => 'Földrajz-Földtud.-Környezettud. műhely',
            'type' => self::WORKSHOP_TYPE_DOGESZ,
        ],
        'w_italan' => [
            'permission_code' => 'w_italan',
            'name' => 'Olasz műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_oriental' => [
            'permission_code' => 'w_oriental',
            'name' => 'Orientalisztika műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_scandinavian' => [
            'permission_code' => 'w_scandinavian',
            'name' => 'Skandinavisztika műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_spanish' => [
            'permission_code' => 'w_spanish',
            'name' => 'Spanyol műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_slav' => [
            'permission_code' => 'w_slav',
            'name' => 'Szlavisztika műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_social' => [
            'permission_code' => 'w_social',
            'name' => 'Társadalomtudományi műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_history' => [
            'permission_code' => 'w_history',
            'name' => 'Történész műhely',
            'type' => self::WORKSHOP_TYPE_BOLCSESZ,
        ],
        'w_economy' => [
            'permission_code' => 'w_economy',
            'name' => 'Gazdálkodástudományi műhely',
            'type' => self::WORKSHOP_TYPE_DOGESZ,
        ],
    ];

    //const LEVEL_VIEW = 'view';
    //const LEVEL_ADMIN = 'admin';

    public $timestamps = true;
    protected $primaryKey = 'id';

    public $fillable = [
        'id',
        'user_id',

        'permission',
        //'level',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
