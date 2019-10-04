@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<h4>Dados Gerais</h4>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $totalPublishers }} </h3>

                <p>Total de Ministros</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('publisher') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $totalPioneers }}</h3>

                <p>Total de Pioneiros</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('pioneer') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $totalNonBaptizedPublishers}} </h3>

                <p>Não batizados</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('publisher') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $totalPublishers - $totalReports}} </h3>

                <p>Irregulares</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('publisher') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<h4>Grupos</h4>

<div class="row">
    @foreach ($membersGroups as $k => $m)
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-{{ $m['color'] }} ">
                <div class="inner">
                    <h3>{{ $m['total'] }} </h3>

                    <p>{{ $k }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="{{ route('publisher') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    @endforeach
</div>
@stop