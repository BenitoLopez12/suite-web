<?php

namespace App\Mail\Minutas;

use App\Models\Minutasaltadireccion;
use App\Models\RevisionMinuta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MinutaConfirmacionRechazo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $minuta;
    public $revision;

    public function __construct(Minutasaltadireccion $minuta, RevisionMinuta $revision)
    {
        $minuta->load('planes', 'participantes', 'responsable');
        $this->minuta = $minuta;
        $this->revision = $revision;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.minutas.documento-rechazado');
    }
}
