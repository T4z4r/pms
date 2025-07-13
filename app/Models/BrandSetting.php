<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandSetting extends Model
{
    protected $fillable = [
        'company_logo', 'report_logo', 'dashboard_logo', 'primary_color', 'primary_dark', 'primary_darker',
        'primary_light', 'primary_lighter', 'primary_highlight', 'primary_shadow', 'secondary_color',
        'secondary_dark', 'secondary_darker', 'secondary_light', 'secondary_lighter', 'secondary_highlight',
        'secondary_shadow', 'hover_color', 'hover_color_two', 'loader_color_one', 'loader_color_two',
        'loader_color_three', 'loader_color_four', 'loader_color_five', 'loader_color_six', 'address_1',
        'address_2', 'address_3', 'address_4', 'login_picture', 'body_background', 'website_url',
        'report_system_name', 'report_top_banner', 'report_bottom_banner', 'allowed_domain',
        'left_payslip_logo', 'right_payslip_logo', 'organization_name', 'email_logo'
    ];
}
