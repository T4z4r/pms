<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
       public function up()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('submodule_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropForeign(['submodule_id']);
            $table->dropColumn(['module_id', 'submodule_id']);
        });
    }

};
