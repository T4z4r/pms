<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_design_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_design_id')->constrained('system_designs')->onDelete('cascade');
            $table->string('version')->default('1.0');
            $table->longText('data'); // Compressed draw.io XML
            $table->string('thumbnail')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_design_versions');
    }
};