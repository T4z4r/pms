<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Open', 'In Progress', 'Closed'])->default('Open');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            // $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });



    }

    public function down(): void
    {
    Schema::dropIfExists('issues');
    }
};
