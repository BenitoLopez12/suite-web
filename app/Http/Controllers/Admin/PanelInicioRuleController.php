<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PanelInicioRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PanelInicioRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('bd_empleados_configurar_vista_datos'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.panel-inicio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PanelInicioRule  $panelInicioRule
     * @return \Illuminate\Http\Response
     */
    public function show(PanelInicioRule $panelInicioRule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PanelInicioRule  $panelInicioRule
     * @return \Illuminate\Http\Response
     */
    public function edit(PanelInicioRule $panelInicioRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PanelInicioRule  $panelInicioRule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PanelInicioRule $panelInicioRule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PanelInicioRule  $panelInicioRule
     * @return \Illuminate\Http\Response
     */
    public function destroy(PanelInicioRule $panelInicioRule)
    {
        //
    }
}
