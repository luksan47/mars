<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';

    const DELIMITER = '|';

    const STATUS_UNFINAL = 'unfinal';
    const STATUS_FINAL = 'final';
    const STATUS_BANISHED = 'banished';

    const STATUSES = [
        self::STATUS_UNFINAL,
        self::STATUS_FINAL,
        self::STATUS_BANISHED,
    ];

    const MEMBER_INNER = 'inner';
    const MEMBER_OUTER = 'outer';

    public $fillable = [
        'id',
        'user_id',

        'status',    // string {of STATUSES}

        'inf_name',     // string
        'inf_birthdate',    // date
        'inf_mothers_name', // string
        'inf_main_email',   // email
        'inf_telephone', // phone|string

        'address_country', // string
        'address_city', // string
        'address_zip',  // string
        'address_street', // string

        'school_name',  // string
        'school_country',   // string
        'school_city',  // string
        'school_zip',   // string
        'school_street', // string

        'studies_matura_exam_year',   // int
        'studies_matura_exam_avrage', // float
        'studies_university_studies_avrages', // float[]
        'studies_university_courses',   // string[]

        'achivements_language_exams', // string[]
        'achivements_competitions',   // string[]
        'achivements_publications',     // string[]
        'achivements_studies_abroad',   // string[]

        'question_social',  // text
        'question_why_us',  // text
        'question_plans',   // text

        'misc_status',      // bentlako|bajaro
        'misc_workshops',   // WORKSHOP[]
        'misc_neptun',      // char(6)
        'misc_caesar_mail', // email

        'profile_picture_path', // string

    ];

    public static function compress_data($data)
    {
        if ($data === null) {
            return null;
        }

        return join(
            self::DELIMITER,
            array_map(
                function (&$value) {
                    return str_replace(self::DELIMITER, ' ', $value);
                },
                array_filter(
                    $data,
                    function (&$value) {
                        return ! is_null($value);
                    }
                )
            )
        );
    }

    public static function decompress_data($data)
    {
        if ($data === null) {
            return null;
        }

        return explode(self::DELIMITER, $data);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function uploads()
    {
        return $this->belongsToMany('App\Uploads');
    }

    public static function find_prepare($id)
    {
        $application = Applications::where('user_id', $id)->get()[0];

        self::prepare_data($application);

        return $application;
    }

    public static function find_id_prepare($id)
    {
        $application = Applications::where('id', $id)->get()[0];

        self::prepare_data($application);

        return $application;
    }

    public static function where_prepare(string $colum, string $value)
    {
        $applications = Applications::where($colum, $value)->get();

        foreach ($applications as &$application) {
            self::prepare_data($application);
        }

        return $applications;
    }

    public static function prepare_data(&$application)
    {
        $application['studies_university_studies_avrages'] = Applications::decompress_data($application['studies_university_studies_avrages']);
        $application['studies_university_courses'] = Applications::decompress_data($application['studies_university_courses']);

        $application['achivements_language_exams'] = Applications::decompress_data($application['achivements_language_exams']);
        $application['achivements_competitions'] = Applications::decompress_data($application['achivements_competitions']);
        $application['achivements_publications'] = Applications::decompress_data($application['achivements_publications']);
        $application['achivements_studies_abroad'] = Applications::decompress_data($application['achivements_studies_abroad']);

        $application['misc_workshops'] = Applications::decompress_data($application['misc_workshops']);
    }
}
