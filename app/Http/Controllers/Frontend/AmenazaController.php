<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\CreateAmenazaRequest;
use App\Http\Requests\UpdateAmenazaRequest;
use App\Models\Amenaza;
use App\Repositories\AmenazaRepository;
use Flash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AmenazaController extends AppBaseController
{
    use CsvImportTrait;
    /** @var AmenazaRepository */
    private $amenazaRepository;

    public function __construct(AmenazaRepository $amenazaRepo)
    {
        $this->amenazaRepository = $amenazaRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Amenaza::orderByDesc('id')->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'amenazas';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('nombre', function ($row) {
                return $row->nombre ? $row->nombre : '';
            });
            $table->editColumn('categoria', function ($row) {
                return $row->categoria ? $row->categoria : '';
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('frontend.amenazas.index');
    }

    /**
     * Show the form for creating a new Amenaza.
     *
     * @return Response
     */
    public function create()
    {
        return view('frontend.amenazas.create');
    }

    /**
     * Store a newly created Amenaza in storage.
     *
     * @param CreateAmenazaRequest $request
     *
     * @return Response
     */
    public function store(CreateAmenazaRequest $request)
    {
        $input = $request->all();

        $amenaza = $this->amenazaRepository->create($input);

        Flash::success('Amenaza añadida satisfactoriamente.');

        return redirect(route('amenazas.index'));
    }

    /**
     * Display the specified Amenaza.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Amenaza $amenaza)
    {
        return view('frontend.amenazas.show')->with('amenaza', $amenaza);
    }

    /**
     * Show the form for editing the specified Amenaza.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $amenaza = $this->amenazaRepository->find($id);

        if (empty($amenaza)) {
            Flash::error('Amenaza not found');

            return redirect(route('amenazas.index'));
        }

        return view('frontend.amenazas.edit')->with('amenaza', $amenaza);
    }

    /**
     * Update the specified Amenaza in storage.
     *
     * @param  int              $id
     * @param UpdateAmenazaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAmenazaRequest $request)
    {
        $amenaza = $this->amenazaRepository->find($id);

        if (empty($amenaza)) {
            Flash::error('Amenaza not found');

            return redirect(route('amenazas.index'));
        }

        $amenaza = $this->amenazaRepository->update($request->all(), $id);

        Flash::success('Amenaza actualizada.');

        return redirect(route('amenazas.index'));
    }

    /**
     * Remove the specified Amenaza from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $amenaza = $this->amenazaRepository->find($id);

        if (empty($amenaza)) {
            Flash::error('Amenaza not found');

            return redirect(route('amenazas.index'));
        }

        $this->amenazaRepository->delete($id);

        Flash::success('Amenaza eliminada satisfactoriamente.');

        return redirect(route('amenazas.index'));
    }

    public function massDestroy(Request $request)
    {
        Amenaza::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
