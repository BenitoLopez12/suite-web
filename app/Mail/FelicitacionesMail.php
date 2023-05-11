<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FelicitacionesMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $nombre, $correodestinatario, $imgpastel, $imgtab;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $correodestinatario, $imgpastel, $imgtab)
    {
        //
        $this->nombre = $nombre;
        $this->correodestinatario = $correodestinatario;
        $this->imgpastel = $imgpastel;
        $this->imgtab = $imgtab;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('# MAIL_FROM_ADDRESS'), env('# MAIL_FROM_NAME'))
        ->subject('Feliz Cumpleaños')
        ->view('mails.felicitaciones',
            ['empleado'=>$this->nombre,
            'pastel'=>$this->imgpastel,
            'tabantaj'=>$this->imgtab
        ]);
    }
}
