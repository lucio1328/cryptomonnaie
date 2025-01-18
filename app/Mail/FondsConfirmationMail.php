<?php

namespace App\Mail;

use App\Models\Utilisateur;
use App\Models\Fonds;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FondsConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $fonds;
    public $confirmationLink;

    /**
     * Create a new message instance.
     *
     * @param Utilisateur $user
     * @param Fonds $fonds
     * @return void
     */
    public function __construct(Utilisateur $user, Fonds $fonds)
    {
        $this->user = $user;
        $this->fonds = $fonds;
        $this->confirmationLink = route('fonds.confirmation', ['id' => $fonds->id_fonds]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de l\'opération de fonds')
                    ->view('emails.fonds_confirmation')
                    ->with([
                        'confirmationLink' => $this->confirmationLink,
                    ]);
    }
}

