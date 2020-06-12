<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintAccountHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('print_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('last_modified_by')->nullable(); //TODO remove nullable
            $table->timestamp('modified_at')->nullable();
        });
        Schema::create('print_account_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('balance_change');
            $table->integer('free_page_change');
            $table->date('deadline_change')->nullable();
            $table->unsignedBigInteger('modified_by');
            $table->timestamp('modified_at');
        });
        // This triggers is changed in fix_trigger migrations.
        DB::unprepared('
            CREATE TRIGGER trigger_print_account_history_balance
            AFTER UPDATE ON print_accounts
            FOR EACH ROW
                INSERT INTO print_account_history(
                    user_id,
                    balance_change,
                    free_page_change,
                    deadline_change,
                    modified_by)
                VALUES(OLD.user_id, NEW.balance - OLD.balance, 0, NULL, NEW.last_modified_by);
        ');

        DB::unprepared('
            CREATE TRIGGER trigger_update_print_account_history_free_pages
            AFTER UPDATE ON printing_free_pages
            FOR EACH ROW
                BEGIN
                    SET @new_deadline := IF(NEW.deadline <> OLD.deadline, NEW.deadline, NULL);
                    INSERT INTO print_account_history(
                        user_id,
                        balance_change,
                        free_page_change,
                        deadline_change,
                        modified_by,
                        modified_at)
                    VALUES(OLD.user_id, 0, NEW.amount, @new_deadline, NEW.last_modified_by, NEW.updated_at);
                END;
        ');

        DB::unprepared('
            CREATE TRIGGER trigger_insert_print_account_history_free_pages
            AFTER INSERT ON printing_free_pages
            FOR EACH ROW
                INSERT INTO print_account_history(
                    user_id,
                    balance_change,
                    free_page_change,
                    deadline_change,
                    modified_by,
                    modified_at)
                VALUES(NEW.user_id, 0, NEW.amount, NEW.deadline, NEW.last_modified_by, NEW.updated_at);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER trigger_print_account_history_balance');
        DB::unprepared('DROP TRIGGER trigger_update_print_account_history_free_pages');
        DB::unprepared('DROP TRIGGER trigger_insert_print_account_history_free_pages');
        Schema::dropIfExists('print_account_history');
        Schema::table('print_accounts', function (Blueprint $table) {
            $table->dropColumn('last_modified_by');
            $table->dropColumn('modified_at');
        });
    }
}
