<div class="d-inline-block" style="float: right;">
    <strong>Periodo: </strong>
    <span>{{ \Carbon\Carbon::parse($last_evaluacion->fecha_inicio)->format('d/m/Y') }}
        -
        {{ \Carbon\Carbon::parse($last_evaluacion->fecha_fin)->format('d/m/Y') }}</span>
    <span style="float: right;cursor: pointer;margin-top: -18px;font-size: 17px;" @click="show=!show"><i
            class="fas" :class="[show ? 'fa-minus' : 'fa-plus']"></i></span>
</div>
