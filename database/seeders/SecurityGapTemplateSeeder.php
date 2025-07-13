<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\SecurityGapTemplate;
use Illuminate\Database\Seeder;

class SecurityGapTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure an admin user exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@flexworkspace.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        // OWASP Top 10 data
        $owaspTop10 = [
            [
                'title' => 'A01:2021-Broken Access Control',
                'description' => 'Allows unauthorized access to resources or functions due to improper access controls. Mitigate with strict authorization checks and least privilege principles.',
            ],
            [
                'title' => 'A02:2021-Cryptographic Failures',
                'description' => 'Exposes sensitive data due to weak or missing encryption. Use strong cryptographic algorithms and secure key management.',
            ],
            [
                'title' => 'A03:2021-Injection',
                'description' => 'Allows attackers to execute malicious code via unvalidated input. Prevent with parameterized queries and input validation.',
            ],
            [
                'title' => 'A04:2021-Insecure Design',
                'description' => 'Results from flawed application design. Adopt threat modeling and secure design patterns.',
            ],
            [
                'title' => 'A05:2021-Security Misconfiguration',
                'description' => 'Arises from improper configuration of servers or applications. Harden configurations and remove unused features.',
            ],
            [
                'title' => 'A06:2021-Vulnerable and Outdated Components',
                'description' => 'Exploits unpatched libraries or frameworks. Maintain an inventory and apply updates promptly.',
            ],
            [
                'title' => 'A07:2021-Identification and Authentication Failures',
                'description' => 'Allows unauthorized access due to weak authentication. Implement multi-factor authentication and strong password policies.',
            ],
            [
                'title' => 'A08:2021-Software and Data Integrity Failures',
                'description' => 'Permits tampering due to unverified updates or data. Use digital signatures and integrity checks.',
            ],
            [
                'title' => 'A09:2021-Security Logging and Monitoring Failures',
                'description' => 'Hinders detection due to insufficient logging. Implement comprehensive logging and real-time monitoring.',
            ],
            [
                'title' => 'A10:2021-Server-Side Request Forgery (SSRF)',
                'description' => 'Allows attackers to make unauthorized server requests. Validate and sanitize all URLs.',
            ],
        ];

        // Seed OWASP Top 10 templates
        foreach ($owaspTop10 as $gap) {
            SecurityGapTemplate::firstOrCreate(
                ['title' => $gap['title'], 'version_number' => 1],
                [
                    'description' => $gap['description'],
                    'version_number' => 1,
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
