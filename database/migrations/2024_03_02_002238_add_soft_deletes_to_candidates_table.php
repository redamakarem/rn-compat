<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // In the generated migration file
public function up()
{
    Schema::table('candidates', function (Blueprint $table) {
        $table->softDeletes();
    });
}

public function down()
{
    Schema::table('candidates', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
}
