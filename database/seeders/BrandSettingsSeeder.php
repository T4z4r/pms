<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BrandSettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('brand_settings')->insert([
            'company_logo'         => 'images/logo/company_logo.png',
            'report_logo'          => 'images/logo/report_logo.png',
            'dashboard_logo'       => 'images/logo/dashboard_logo.png',
            'primary_dark'         => '#5A0F09',
            'primary_darker'       => '#3C0A06',
            'primary_light'        => '#8E2B20',
            'primary_lighter'      => '#A64D44',
            'primary_highlight'    => '#B75A51',
            'primary_shadow'       => '#4C0F0A',
            'secondary_dark'       => '#E0E0E0',
            'secondary_darker'     => '#C0C0C0',
            'secondary_light'      => '#F5F5F5',
            'secondary_lighter'    => '#FAFAFA',
            'secondary_highlight'  => '#F0F0F0',
            'secondary_shadow'     => '#D0D0D0',
            'loader_color_one'     => '#1d5fc9',
            'loader_color_two'     => '#05aeee',
            'loader_color_three'   => '#A64D44',
            'loader_color_four'    => '#B75A51',
            'loader_color_five'    => '#C86A61',
            'loader_color_six'     => '#D97B72',
            'address_1'            => '123 Brand Street',
            'address_2'            => 'Suite 456',
            'address_3'            => 'CityName',
            'address_4'            => 'CountryName',
            'login_picture'        => 'images/login/login_background.jpg',
            'body_background'      => '#FFFFFF',
            'website_url'          => 'https://brand.example.com',
            'report_system_name'   => 'Brand Report System',
            'report_top_banner'    => 'images/report/top_banner.jpg',
            'report_bottom_banner' => 'images/report/bottom_banner.jpg',
            'allowed_domain'       => 'localhost',
            'left_payslip_logo'    => 'images/payslip/left_logo.png',
            'right_payslip_logo'   => 'images/payslip/right_logo.png',
            'organization_name'    => 'Brand Organization',
            'email_logo'           => 'images/email/email_logo.png',

            //new data
             'primary_color' => '#1d5fc9',
            'secondary_color' => '#05aeee',
            'hover_color' => '#a3cfee',
            'hover_color_two' => '#f7c341',
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ]);
    }
}
