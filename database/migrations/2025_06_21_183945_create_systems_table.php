<?php
   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration {
       public function up(): void
       {
           Schema::create('systems', function (Blueprint $table) {
               $table->id();
               $table->string('name');
               $table->text('description')->nullable();
               $table->foreignId('project_id')->constrained()->onDelete('cascade');
               $table->enum('status', ['active', 'inactive', 'under_development', 'deprecated'])->default('active');
               $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
               $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
               $table->boolean('is_all_users')->default(false);
               $table->timestamps();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('systems');
       }
   };