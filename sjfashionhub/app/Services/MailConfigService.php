<?php

namespace App\Services;

use App\Models\CommunicationSetting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    /**
     * Configure mail settings from database
     */
    public static function configure()
    {
        try {
            \Log::info('Starting mail configuration from database');

            // Get active email service
            $activeService = CommunicationSetting::get('email', 'general', 'active_service');
            \Log::info('Active email service: ' . ($activeService ?: 'none'));

            if (!$activeService) {
                \Log::warning('No active email service configured');
                return false;
            }

            // Get service settings
            $settings = CommunicationSetting::getProviderSettings('email', $activeService);
            \Log::info('Retrieved settings for ' . $activeService . ': ' . json_encode(array_keys($settings->toArray())));

            if (empty($settings)) {
                \Log::warning('No settings found for service: ' . $activeService);
                return false;
            }

            // Configure based on service type
            switch ($activeService) {
                case 'smtp':
                    self::configureSMTP($settings->toArray());
                    break;
                case 'mailgun':
                    self::configureMailgun($settings->toArray());
                    break;
                case 'ses':
                    self::configureSES($settings->toArray());
                    break;
                case 'postmark':
                    self::configurePostmark($settings->toArray());
                    break;
                default:
                    \Log::warning('Unknown email service: ' . $activeService);
                    return false;
            }

            \Log::info('Mail configuration completed successfully for: ' . $activeService);
            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to configure mail settings: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Configure SMTP settings
     */
    private static function configureSMTP($settings)
    {
        \Log::info('Configuring SMTP with settings: ' . json_encode([
            'host' => $settings['host'] ?? 'not set',
            'port' => $settings['port'] ?? 'not set',
            'username' => $settings['username'] ?? 'not set',
            'encryption' => $settings['encryption'] ?? 'not set',
            'from_address' => $settings['from_address'] ?? 'not set',
            'from_name' => $settings['from_name'] ?? 'not set',
        ]));

        $config = [
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $settings['host'] ?? 'localhost',
            'mail.mailers.smtp.port' => (int) ($settings['port'] ?? 587),
            'mail.mailers.smtp.username' => $settings['username'] ?? '',
            'mail.mailers.smtp.password' => $settings['password'] ?? '',
            'mail.mailers.smtp.encryption' => $settings['encryption'] ?? 'tls',
            'mail.from.address' => $settings['from_address'] ?? 'noreply@sjfashionhub.in',
            'mail.from.name' => $settings['from_name'] ?? 'SJ Fashion Hub',
        ];

        Config::set($config);
        \Log::info('SMTP configuration applied successfully');
    }

    /**
     * Configure Mailgun settings
     */
    private static function configureMailgun($settings)
    {
        Config::set([
            'mail.default' => 'mailgun',
            'mail.mailers.mailgun.transport' => 'mailgun',
            'services.mailgun.domain' => $settings['domain'] ?? '',
            'services.mailgun.secret' => $settings['api_key'] ?? '',
            'mail.from.address' => $settings['from_address'] ?? 'noreply@sjfashionhub.in',
            'mail.from.name' => $settings['from_name'] ?? 'SJ Fashion Hub',
        ]);
    }

    /**
     * Configure SES settings
     */
    private static function configureSES($settings)
    {
        Config::set([
            'mail.default' => 'ses',
            'mail.mailers.ses.transport' => 'ses',
            'services.ses.key' => $settings['api_key'] ?? '',
            'services.ses.secret' => $settings['secret_key'] ?? '',
            'services.ses.region' => $settings['region'] ?? 'us-east-1',
            'mail.from.address' => $settings['from_address'] ?? 'noreply@sjfashionhub.in',
            'mail.from.name' => $settings['from_name'] ?? 'SJ Fashion Hub',
        ]);
    }

    /**
     * Configure Postmark settings
     */
    private static function configurePostmark($settings)
    {
        Config::set([
            'mail.default' => 'postmark',
            'mail.mailers.postmark.transport' => 'postmark',
            'services.postmark.token' => $settings['api_key'] ?? '',
            'mail.from.address' => $settings['from_address'] ?? 'noreply@sjfashionhub.in',
            'mail.from.name' => $settings['from_name'] ?? 'SJ Fashion Hub',
        ]);
    }
}
