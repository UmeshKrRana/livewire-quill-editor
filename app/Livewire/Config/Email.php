<?php
namespace App\Livewire\Config;

use App\Models\EmailConfig;
use App\Services\DynamicEmail;
use Livewire\Component;

class Email extends Component
{

    public $driver;
    public $host;
    public $port;
    public $encryption = 'tls';
    public $username;
    public $password;
    public $from_name;
    public $from_address;
    public $reply_to_name;
    public $reply_to_address;
    public $timeout           = 60;
    public $showPasswordInput = false;

    /**
     * Function: rules
     * Decription: For Validation
     */
    public function rules()
    {
        return [
            'driver'           => 'required|string|in:smtp,sendmail',
            'host'             => 'required|string',
            'port'             => 'required|integer',
            'encryption'       => 'required|string|in:tls,ssl',
            'username'         => 'required|string',
            'password'         => $this->showPasswordInput ? 'required|string|min:6' : 'nullable',
            'from_name'        => 'required|string',
            'from_address'     => 'required|email',
            'reply_to_name'    => 'required|string',
            'reply_to_address' => 'required|email',
            'timeout'          => 'nullable|integer',
        ];
    }

    /**
     * Function: getEmailConfig
     */
    public function getEmailConfig()
    {
        return EmailConfig::first();
    }

    /**
     * Function: mount
     * Decription: To load email configuration
     */
    public function mount()
    {
        if ($emailConfig = $this->getEmailConfig()) {
            $this->driver           = $emailConfig->driver ?? 'smtp';
            $this->host             = $emailConfig->host;
            $this->port             = $emailConfig->port;
            $this->encryption       = $emailConfig->encryption;
            $this->username         = $emailConfig->username;
            $this->from_address     = $emailConfig->from_address;
            $this->from_name        = $emailConfig->from_name;
            $this->reply_to_name    = $emailConfig->reply_to_name;
            $this->reply_to_address = $emailConfig->reply_to_address;
            $this->timeout          = $emailConfig->timeout;
        }
    }

    /**
     * Function: saveConfig
     * Description: To save the email configuration
     */
    public function saveConfig()
    {

        # Trigger validation
        $validatedRequest = $this->validate();

        # Get Email Config
        $emailConfig = $this->getEmailConfig();

        # If Password is coming from Form then only we will save it by encrypting
        if (! empty($validatedRequest['password'])) {
            $validatedRequest['password'] = encrypt($validatedRequest['password']);
        } else {
            # Old Password
            unset($validatedRequest['password']);
        }

        if ($emailConfig) {
            $emailConfig->update($validatedRequest);
        } else {
            # Insert
            EmailConfig::create($validatedRequest);
        }

        # Setting Updated Email Config to Email Configuration
        DynamicEmail::applyDynamicEmailConfig();

        # Send flash message
        $this->dispatch('flash', [
            'message' => 'Email configuration saved successfully!',
            'type'    => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.config.email');
    }
}
