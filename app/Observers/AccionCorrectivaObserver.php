<?php

namespace App\Observers;

use App\Events\AccionCorrectivaEvent;
use App\Models\AccionCorrectiva;

class AccionCorrectivaObserver
{
    /**
     * Handle the AccionCorrectiva "created" event.
     *
     * @param  \App\Models\AccionCorrectiva  $accionCorrectiva
     * @return void
     */
    public function created(AccionCorrectiva $accionCorrectiva)
    {
        event(new AccionCorrectivaEvent($accionCorrectiva, 'create', 'accion-correctiva', 'Acción Correctiva'));
    }

    /**
     * Handle the AccionCorrectiva "updated" event.
     *
     * @param  \App\Models\AccionCorrectiva  $accionCorrectiva
     * @return void
     */
    public function updated(AccionCorrectiva $accionCorrectiva)
    {
        event(new AccionCorrectivaEvent($accionCorrectiva, 'update', 'accion-correctiva', 'Acción Correctiva'));
    }

    /**
     * Handle the AccionCorrectiva "deleted" event.
     *
     * @param  \App\Models\AccionCorrectiva  $accionCorrectiva
     * @return void
     */
    public function deleted(AccionCorrectiva $accionCorrectiva)
    {
        event(new AccionCorrectivaEvent($accionCorrectiva, 'delete', 'accion-correctiva', 'Acción Correctiva'));
    }

    /**
     * Handle the AccionCorrectiva "restored" event.
     *
     * @param  \App\Models\AccionCorrectiva  $accionCorrectiva
     * @return void
     */
    public function restored(AccionCorrectiva $accionCorrectiva)
    {
        //
    }

    /**
     * Handle the AccionCorrectiva "force deleted" event.
     *
     * @param  \App\Models\AccionCorrectiva  $accionCorrectiva
     * @return void
     */
    public function forceDeleted(AccionCorrectiva $accionCorrectiva)
    {
        //
    }
}
