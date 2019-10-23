@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

@if ($pendingReports > 0)
<div class="pad margin no-print">
    <div class="callout callout-warning" style="margin-bottom: 0!important;">
        <h4> Nota:</h4>
        {{ $pendingReports }} publicadores ainda não entregaram o relatório esse mês.
        <a href="{{ route('non_reported') }}" class="small-box-footer">Detalhes <i class="fa fa-arrow-circle-right"></i></a> 
    </div>
</div>
@else
<div class="pad margin no-print">
    <div class="callout callout-success" style="margin-bottom: 0!important;">
        Bom trabalho! Relatório do mês {{ $lastMonth }} compilado com sucesso.
    </div>
</div>
@endif

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
            <a href="{{ route('publisher') }}" class="small-box-footer">Detalhes <i
                    class="fa fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('pioneer') }}" class="small-box-footer">Detalhes <i
                    class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">Detalhes <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $totalIrregular }} </h3>

                <p>Irregulares</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Detalhes <i
                    class="fa fa-arrow-circle-right"></i></a>
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

<h4>Relatório mensal da Congregação</h4>

<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
                <h3 class="widget-user-username" style="margin-left: 0;">Pioneiros Regulares</h3>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Total de Relatórios <span class="pull-right badge bg-blue">{{ $regularPioneers->count() }}</span></a></li>
                    <li><a href="#">Horas <span class="pull-right badge bg-aqua">{{ $regularPioneers->sum('hours')}} </span></a></li>
                    <li><a href="#">Revisitas <span class="pull-right badge bg-green">{{ $regularPioneers->sum('return_visits')}}</span></a></li>
                    <li><a href="#">Estudos bíblicos <span class="pull-right badge bg-red">{{ $regularPioneers->sum('studies') }}</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-purple">
                <h3 class="widget-user-username" style="margin-left: 0;">Pioneiros Auxiliares</h3>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Total de Relatórios <span class="pull-right badge bg-blue">{{ $auxiliarPioneers->count() }}</span></a></li>
                    <li><a href="#">Horas <span class="pull-right badge bg-aqua">{{ $auxiliarPioneers->sum('hours')}} </span></a></li>
                    <li><a href="#">Revisitas <span class="pull-right badge bg-green">{{ $auxiliarPioneers->sum('return_visits')}}</span></a></li>
                    <li><a href="#">Estudos bíblicos <span class="pull-right badge bg-red">{{ $auxiliarPioneers->sum('studies') }}</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-aqua">
                <h3 class="widget-user-username" style="margin-left: 0;">Publicadores</h3>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Total de Relatórios <span class="pull-right badge bg-blue">{{ $publishers->count() }}</span></a></li>
                    <li><a href="#">Horas <span class="pull-right badge bg-aqua">{{ $publishers->sum('hours')}} </span></a></li>
                    <li><a href="#">Revisitas <span class="pull-right badge bg-green">{{ $publishers->sum('return_visits')}}</span></a></li>
                    <li><a href="#">Estudos bíblicos <span class="pull-right badge bg-red">{{ $publishers->sum('studies') }}</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<h4>Assistência as reuniões</h4>

<div class="row">
    <div class="col-md-6">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-yellow-active">
                <h3 class="widget-user">Meio de semana</h3>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $midweekMeeting->count() }} </h5>
                            <span class="description-text">Total de reuniões</span>
                        </div>
                    </div>
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $midweekMeeting->sum('attendance') }} </h5>
                            <span class="description-text">Total da assistência</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $midweekMeeting->avg('attendance') }} </h5>
                            <span class="description-text">Média da assistência</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-purple-active">
                <h3 class="widget-user">Final de semana</h3>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $weekendMeeting->count() }} </h5>
                            <span class="description-text">Total de reuniões</span>
                        </div>
                    </div>
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $weekendMeeting->sum('attendance') }} </h5>
                            <span class="description-text">Total da assistência</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header"> {{ $weekendMeeting->avg('attendance') }} </h5>
                            <span class="description-text">Média da assistência</span>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@stop