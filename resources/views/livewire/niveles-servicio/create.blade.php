


<!--<span class="card-title">Agregar nivel de servicio</span>-->

{{-- <div class="col s12">
  <div class="form-group diseño-titulo" >
     <p class="center-align white-text" style="font-size:13pt;">AGREGAR NIVEL DEL SERVICIO</p>
   </div>
</div> --}}
<h4 class="sub-titulo-form col s12">AGREGAR NIVEL DEL SERVICIO</h4>
<form wire:submit.prevent="store" enctype="multipart/form-data">

    @include('livewire.niveles-servicio.form')

    <link rel="stylesheet" type="text/css" href="{{asset('css/botones.css')}}">



    <!--<button wire:click="store" class="btn green">
        Guardar
    </button>-->
    <div class="row">
        <div class="col s12 right-align" style="margin-top:40px;" >
        <button type="submit" id="submit" class="btn-redondeado btn btn-primary">Guardar</button>
        </div>
    </div>

</form>
