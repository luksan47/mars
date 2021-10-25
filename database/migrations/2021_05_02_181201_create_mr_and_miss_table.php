<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMrAndMissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $originalCategories = [
            'Mr. Eötvös',
            'Mr. BA/BSc',
            'Mr. MA/MSc',
            'Mr. Osztatlan',
            'Mr. Választmány',
            'Mr. GóJa',
            'Mr. Hang',
            'Mr. A legsármosabb tekintet',
            'Mr. Divat',
            'Mr. A legmacsóbb borosta',
            'Mr. Filosz',
            'Mr. Dögész',
            'Mr. TáTiKa',
            'Mr. Deréktól felfelé',
            'Mr. Szórakozott professzor',
            'Mr. Minden lében kanál',
            'Mr. Fészbúk',
            'Mr. Szeretném, ha rámírna',
            'Mr. Bárcsak szingli lenne',
            'Mr. Már túl vagyok rajta',
            'Mr. Bárcsak a szobatársam lenne',
            'Mr. Akivel szívesen ragadnék karanténban',
            'Mr. Meme',
            'Mr. Teamses baki',
            'Mr. Bárcsak az apukám lenne',
            'Mr. Corona',
            'Mr. Abszolút',
            'Miss Eötvös',
            'Miss BA/BSc',
            'Miss MA/MSc',
            'Miss Osztatlan',
            'Miss GóJa',
            'Miss Választmány',
            'Miss Hang',
            'Miss A legigézőbb tekintet',
            'Miss Filosz',
            'Miss Dögész',
            'Miss TáTiKa',
            'Miss Divat',
            'Miss Szeretném, ha rámírna',
            'Miss Frizura',
            'Miss A legszebb mosoly',
            'Miss Akinek mellszobrot állítanék',
            'Miss Fészbúk',
            'Miss Minden lében kanál',
            'Misstérium',
            'Miss Mrs',
            'Miss A legangyalibb',
            'Miss A legördögibb',
            'Miss Bárcsak az anyukám lenne',
            'Miss Bárcsak a szobatársam lenne',
            'Miss Bárcsak szingli lenne',
            'Miss Már túl vagyok rajta',
            'Miss Akivel szívesen ragadnék karanténban',
            'Miss Meme',
            'Miss Teamses baki',
            'Miss Corona',
        ];
        $category_map = array_map(fn ($category) => ['title' => $category, 'mr' => substr($category, 0, 2) == 'Mr'], $originalCategories);

        Schema::create('mr_and_miss_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('mr');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('hidden')->default(false); // Should be visible for voting/results?
            $table->boolean('public')->default(true);
            $table->boolean('custom')->default(false);
            $table->timestamps();
        });

        Schema::create('mr_and_miss_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voter');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('votee_id')->nullable();
            $table->string('votee_name')->nullable();
            $table->unsignedSmallInteger('semester');

            $table->foreign('voter')->references('id')->on('users');
            $table->foreign('category')->references('id')->on('mr_and_miss_categories');
            $table->foreign('votee_id')->references('id')->on('users');
            $table->foreign('semester')->references('id')->on('semesters');
        });

        DB::table('mr_and_miss_categories')->insertOrIgnore($category_map);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mr_and_miss_categories');
        Schema::dropIfExists('mr_and_miss_votes');
    }
}
