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
            // Get active email service
            $activeService = CommunicationSetting::get('email', 'general', 'active_service');
            
            if (!$activeService) {
                return false;
            }

            // Get service settings
            $settings = CommunicationSetting::getProviderSettings('email', $activeService);
            
            if (empty($settings)) {
                return false;
            }

            // Configure based on service type
            switch ($activeService) {
                case 'smtp':
                    self::configureSMTP($settings);
                    break;
                case 'mailgun':
                    self::configureMailgun($settings);
                    break;
                case 'ses':
                    self::configureSES($settings);
                    break;
                case 'postmark':
                    self::configurePostmark($settings);
                    break;
                default:
                    return false;
            }

            return true;
            
        } catch (\Exception $e) {
            \Log::error('Failed to configure mail settings: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Configure SMTP settings
     */
    private static function configureSMTP($settings)
    {
        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $settings['host'] ?? 'localhost',
            'mail.mailers.smtp.port' => (int) ($settings['port'] ?? 587),
            'mail.mailers.smtp.username' => $settings['username'] ?? '',
            'mail.mailers.smtp.password' => $settings['password'] ?? '',
            'mail.mailers.smtp.encryption' => $settings['encryption'] ?? 'tls',
            'mail.from.address' => $settings['from_address'] ?? 'noreply@sjfashionhub.in',
            'mail.from.name' => $settings['from_name'] ?? 'SJ Fashion Hub',
        ]);
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
