<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeatureIdToTestCasesTable extends Migration
{
    public function up()
    {
        Schema::table('test_cases', function (Blueprint $table) {
            $table->foreignId('feature_id')->nullable()->constrained('features')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('test_cases', function (Blueprint $table) {
            $table->dropForeign(['feature_id']);
            $table->dropColumn('feature_id');
        });
    }
}
