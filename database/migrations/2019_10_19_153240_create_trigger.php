<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('INSERT INTO print_accounts(user_id)
            SELECT 
               users.id
            FROM 
               users
               LEFT JOIN print_accounts
               ON users.id = print_accounts.user_id
            WHERE
               print_accounts.user_id IS NULL;');
        DB::unprepared('
        CREATE TRIGGER trigger_create_print_account_for_user
            AFTER INSERT ON users 
            FOR EACH ROW
            INSERT INTO print_accounts(user_id) VALUES (NEW.id);
        ');

        DB::unprepared('INSERT INTO internet_accesses(user_id)
            SELECT 
               users.id
            FROM 
               users
               LEFT JOIN internet_accesses
               ON users.id = internet_accesses.user_id
            WHERE
               internet_accesses.user_id IS NULL;');
        DB::unprepared('
        CREATE TRIGGER trigger_create_internet_access_for_user
            AFTER INSERT ON users 
            FOR EACH ROW
            INSERT INTO internet_accesses(user_id) VALUES (NEW.id);
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER trigger_create_print_account_for_user');
        DB::unprepared('DROP TRIGGER trigger_create_internet_access_for_user');
    }
}
