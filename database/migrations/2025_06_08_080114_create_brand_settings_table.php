<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo')->nullable();
            $table->string('report_logo')->nullable();
            $table->string('dashboard_logo')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('primary_dark')->nullable();
            $table->string('primary_darker')->nullable();
            $table->string('primary_light')->nullable();
            $table->string('primary_lighter')->nullable();
            $table->string('primary_highlight')->nullable();
            $table->string('primary_shadow')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('secondary_dark')->nullable();
            $table->string('secondary_darker')->nullable();
            $table->string('secondary_light')->nullable();
            $table->string('secondary_lighter')->nullable();
            $table->string('secondary_highlight')->nullable();
            $table->string('secondary_shadow')->nullable();
            $table->string('hover_color')->nullable();
            $table->string('hover_color_two')->nullable();
            $table->string('loader_color_one')->nullable();
            $table->string('loader_color_two')->nullable();
            $table->string('loader_color_three')->nullable();
            $table->string('loader_color_four')->nullable();
            $table->string('loader_color_five')->nullable();
            $table->string('loader_color_six')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('address_4')->nullable();
            $table->string('login_picture')->nullable();
            $table->timestamps();
            $table->string('body_background')->nullable();
            $table->string('website_url')->nullable();
            $table->string('report_system_name')->nullable();
            $table->string('report_top_banner')->nullable();
            $table->string('report_bottom_banner')->nullable();
            $table->string('allowed_domain')->default('localhost');
            $table->string('left_payslip_logo')->nullable();
            $table->string('right_payslip_logo')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('email_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_settings');
    }
};
