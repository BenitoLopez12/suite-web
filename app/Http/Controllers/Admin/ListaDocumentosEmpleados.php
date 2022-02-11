<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListaDocumentoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ListaDocumentosEmpleados extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lista_documentos_empleados_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $docs = ListaDocumentoEmpleado::get();

        return view('admin.lista_documentos_empleados.index', compact('docs'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('lista_documentos_empleados_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $crear_doc = ListaDocumentoEmpleado::create($request->all());

        return back()->with(['success' => 'Documento agregado']);
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('lista_documentos_empleados_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $eliminar_doc = ListaDocumentoEmpleado::find($id);

        $eliminar_doc->delete();

        return back()->with(['success' => 'Documento eliminado']);
    }
}
