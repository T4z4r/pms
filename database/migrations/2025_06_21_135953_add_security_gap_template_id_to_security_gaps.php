<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('security_gaps', function (Blueprint $table) {
            $table->foreignId('security_gap_template_id')->nullable()->constrained('security_gap_templates')->onDelete('set null')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('security_gaps', function (Blueprint $table) {
            $table->dropForeign(['security_gap_template_id']);
            $table->dropColumn('security_gap_template_id');
        });
    }
};
