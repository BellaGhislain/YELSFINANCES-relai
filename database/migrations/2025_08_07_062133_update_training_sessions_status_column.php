<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrainingSessionsStatusColumn extends Migration
{
    public function up()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->string('status')->default('en cours')->after('price');
        });
    }

    public function down()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('is_active')->default(true)->after('price');
        });
    }
}
