<?php

namespace App\Observers;

use App\Events\MatrizRequisitosEvent;
use App\Models\MatrizRequisitoLegale;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class MastrizRequisitosObserver
{
    /**
     * Handle the matriz "created" event.
     *
     * @return void
     */
    public function created(MatrizRequisitoLegale $matriz)
    {
        Queue::push(function () use ($matriz) {
            event(new MatrizRequisitosEvent($matriz, 'create', 'matriz_requisito_legales', 'Matriz'));
        });

        $this->forgetCache();
    }

    /**
     * Handle the matriz "updated" event.
     *
     * @return void
     */
    public function updated(MatrizRequisitoLegale $matriz)
    {
        Queue::push(function () use ($matriz) {
            event(new MatrizRequisitosEvent($matriz, 'update', 'matriz_requisito_legales', 'Matriz'));
        });

        $this->forgetCache();
    }

    /**
     * Handle the matriz "deleted" event.
     *
     * @return void
     */
    public function deleted(MatrizRequisitoLegale $matriz)
    {
        Queue::push(function () use ($matriz) {
            event(new MatrizRequisitosEvent($matriz, 'delete', 'matriz_requisito_legales', 'Matriz'));
        });

        $this->forgetCache();
    }

    private function forgetCache()
    {
        Cache::forget('matriz_sgsi_all');
    }
}