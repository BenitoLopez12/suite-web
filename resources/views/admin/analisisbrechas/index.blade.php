@extends('layouts.admin')
@section('content')
<div class="card mt-5">
    <div class="col-md-10 col-sm-9 py-3 card card-body bg-primary align-self-center " style="margin-top:-40px; ">
        <h3 class="mb-2  text-center text-white"><strong>ANÁLISIS DE BRECHAS ISO 27001</strong></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-fill" id="myTabJust" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="intr-tab-just" data-toggle="tab" href="#intr-just" role="tab" aria-controls="intr-just" aria-selected="true">INTRODUCCIÓN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gap1-tab-just" data-toggle="tab" href="#gap1-just" role="tab" aria-controls="gap1-just" aria-selected="false">GAP 01</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gap2-tab-just" data-toggle="tab" href="#gap2-just" role="tab" aria-controls="gap2-just" aria-selected="false">GAP 02</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gap3-tab-just" data-toggle="tab" href="#gap3-just" role="tab" aria-controls="gap3-just" aria-selected="false">GAP 03</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dash-tab-just" data-toggle="tab" href="#dash-just" role="tab" aria-controls="dash-just" aria-selected="false">DASHBOARD</a>
                    </li>
                </ul>
                <div class="tab-content card pt-5" id="myTabContentJust">
                    <div class="tab-pane fade show active" id="intr-just" role="tabpanel" aria-labelledby="intr-tab-just">
                        @include('admin.analisisbrechas.introduccion')
                    </div>
                    <div class="tab-pane fade" id="gap1-just" role="tabpanel" aria-labelledby="gap1-tab-just">
                        @include('admin.analisisbrechas.gapuno')
                    </div>
                    <div class="tab-pane fade" id="gap2-just" role="tabpanel" aria-labelledby="gap2-tab-just">
                        @include('admin.analisisbrechas.gapdos')
                    </div>
                    <div class="tab-pane fade" id="gap3-just" role="tabpanel" aria-labelledby="gap3-tab-just">
                        @include('admin.analisisbrechas.gaptres')
                    </div>
                    <div class="tab-pane fade" id="dash-just" role="tabpanel" aria-labelledby="dash-tab-just">
                        @include('admin.analisisbrechas.dashboardab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection