<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

class Remider extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::User();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {   
        return $this->view('mails.blanks');
    }
}
