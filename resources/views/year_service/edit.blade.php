@extends('adminlte::page')

@section('title', 'year_service edit')

@section('content_header')
<h1>{{ $title }}</h1>
@stop

@section('content')

@include('components.alerts', [
    'type' => 'all',
    'display' => 'none'
    ]
)

<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action="{{ $action }}">
                            {{csrf_field()}}
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                            <input type="hidden" name="id" value="{{ $yearService->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Início</label>
                                        <input name="start_at" type="text" class="form-control" data-inputmask="'mask': ['99/99/9999']" data-mask=""
                                        placeholder="" value="{{ ($yearService->start_at) ? date('d/m/Y', strtotime($yearService->start_at)) : '' }}" {{ ($disabled)
                                            ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Fim</label>
                                        <input name="finish_at" type="text" class="form-control" data-inputmask="'mask': ['99/99/9999']" data-mask=""
                                        placeholder="" value="{{ ($yearService->finish_at) ? date('d/m/Y', strtotime($yearService->finish_at)) : '' }}" {{ ($disabled)
                                            ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-2">
                                    <button type="reset" class="btn btn-lg btn-block btn-info"  onclick="javascript: history.go(-1);" id="btnVoltar">{{ ($disabled) ? 'Voltar' : 'Cancelar' }}</button>
                                </div>


                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-lg btn-block btn-success">Salvar</button>
                                </div>


                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script src="https://adminlte.io/themes/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $( function() {
        $('[data-mask]').inputmask()

        $('form').on('submit', function() {

            if(/voltar/g.test(this.action)) return true
            if(/editar/g.test(this.action)) return true
            if(/atender/g.test(this.action)) return true

            // var retorno = false
            // $.ajax({
            //     type: 'POST',
            //     url: '',
            //     data: $('form').serialize(),
            //     async: false,
            //     success: function(data) {
            //         console.log(data)
            //         if(data === "OK") {
            //             retorno = data
            //         } else {
            //             showErrors(data)
            //         }
            //     }
            // })
            // return retorno
            return true
        })
    })

</script>





@endpush
