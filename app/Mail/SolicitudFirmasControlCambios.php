<?php

namespace App\Mail;

use App\Models\PlanificacionControl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudFirmasControlCambios extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $planificacionControles;

    public function __construct(PlanificacionControl $planificacionControles)
    {
        $this->planificacionControles=$planificacionControles;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.planificacionControles.solicitudfirma');
    }
}
