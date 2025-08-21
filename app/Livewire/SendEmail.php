<?php
namespace App\Livewire;

use App\Mail\SendTestEmail;
use App\Services\DynamicEmail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendEmail extends Component
{
    use WithFileUploads;

    #[Validate('required|email')]
    public $to;

    #[Validate('required|string')]
    public $subject;

    #[Validate('required|string|min:5')]
    public $message;

    #[Validate('nullable|file|max:5120')]
    public $attachment = null;

    /**
     * Function: send
     * Description: To send email
     */
    public function send()
    {
        # Validate form
        $this->validate();

        try {

            $mailConfig = config('mail.mailers.smtp');

            if (empty($mailConfig['username'])) {
                DynamicEmail::applyDynamicEmailConfig();
            }

            # Handle mail send with attachment
            $attachmentPath = null;
            if ($this->attachment) {
                $attachmentPath = $this->attachment->store('attachments', 'public');
                $attachmentPath = storage_path('app/public/' . $attachmentPath);
            }

            Mail::to($this->to)->send(new SendTestEmail($this->subject, $this->message, $attachmentPath));

            # Dispatch flash message
            $this->dispatch('flash', [
                'message' => 'Email sent successfully!',
                'type'    => 'success',
            ]);

        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.send-email');
    }
}
