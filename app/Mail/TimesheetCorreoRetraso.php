<?php

namespace App\Mail;

use App\Models\Empleado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TimesheetCorreoRetraso extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $times_faltantes_empleado = [];
    public $empleado;

    public function __construct(Empleado $empleado, $semanas_faltantes)
    {
        $this->semanas_faltantes = $times_faltantes_empleado;
        $this->empleado = $empleado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.timesheet.timesheet_correo_retraso')->subject('Timesheet - Recordatorio de Registro de Horas');
    }
}
