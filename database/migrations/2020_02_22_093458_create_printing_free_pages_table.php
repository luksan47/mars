<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintingFreePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printing_free_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('amount');
            $table->date('deadline');
            $table->bigInteger('last_modified_by');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('print_accounts', function (Blueprint $table) {
            $table->dropColumn('free_pages');
            $table->dropColumn('free_page_deadline');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('print_accounts', function (Blueprint $table) {
            $table->integer('free_pages');
            $table->timestamp('free_page_deadline')->nullable();
        });
        Schema::dropIfExists('printing_free_pages');
    }
}
