<?php

use Illuminate\Database\Migrations\Migration;

class FixTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::Unprepared('DROP TRIGGER IF EXISTS trigger_print_account_history_balance');

        DB::unprepared('
            CREATE TRIGGER trigger_print_account_history_balance
            AFTER UPDATE ON print_accounts
            FOR EACH ROW
                BEGIN
                    IF (NEW.balance <> OLD.balance) THEN
                        INSERT INTO print_account_history(
                            user_id,
                            balance_change,
                            free_page_change,
                            deadline_change,
                            modified_by)
                        VALUES(OLD.user_id, NEW.balance - OLD.balance, 0, NULL, NEW.last_modified_by);
                    END IF;
                END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //We will drop these later.
    }
}
