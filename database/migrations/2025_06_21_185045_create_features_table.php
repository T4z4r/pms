<?php
   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration {
       public function up(): void
       {
           Schema::create('features', function (Blueprint $table) {
               $table->id();
               $table->foreignId('system_id')->constrained()->onDelete('cascade');
               $table->string('title');
               $table->text('description')->nullable();
               $table->enum('status', ['planned', 'in_progress', 'completed', 'on_hold'])->default('planned');
               $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
               $table->timestamps();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('features');
       }
   };