<?php
namespace App\Services;

use App\Models\EmailConfig;

class DynamicEmail
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function applyDynamicEmailConfig()
    {
        $emailConfig = EmailConfig::first();

        if (! $emailConfig) {
            return null;
        }

        config([
            'mail.default'                         => $emailConfig->driver,
            'mail.mailers.' . $emailConfig->driver => [
                'transport' => $emailConfig->driver,
                'host'      => $emailConfig->host,
                'port'      => $emailConfig->port,
                'username'  => $emailConfig->username,
                'password'  => $emailConfig->password ? decrypt($emailConfig->password) : null,
                'timeout'   => $emailConfig->timeout,
            ],
            'mail.from'                            => [
                'address' => $emailConfig->from_address,
                'name'    => $emailConfig->from_name,
            ],

        ]);
    }
}
