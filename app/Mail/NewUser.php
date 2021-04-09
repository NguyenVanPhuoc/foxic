<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable {
    use SerializesModels;

    /**
     * The password instance.
     *
     * @var string $password
     */
    protected $password;

    /**
     * Create a new message instance.
     *
     * @param  string $password
     * @return void
     */
    public function __construct($password)  {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('mails.new-user')
                    ->with(['password' => $this->password]);
    }
}