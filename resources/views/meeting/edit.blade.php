@extends('adminlte::page')

@section('title', 'publisher edit')

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

                            <input type="hidden" name="id" value="{{ $meeting->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Data</label>
                                        <input name="date" type="text" class="form-control" data-inputmask="'mask': ['99/99/9999']" data-mask=""
                                        placeholder="" value="{{ ($meeting->date) ? date('d/m/Y', strtotime($meeting->date)) : '' }}" {{ ($disabled)
                                            ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Assistência</label>
                                        <input name="attendance" type="number" class="form-control" placeholder="" value="{{ $meeting->attendance }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Observações</label>
                                        <input name="observations" type="text" class="form-control" placeholder="" value="{{ $meeting->observations }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
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

        $('.publisherSelect').select2();


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

        $('#selectResposta').on('change', function(){
            if($('#selectResposta option:selected').val() == '') {
                $('#taResposta').val('')
            } else {
                $('#taResposta').val($('#selectResposta option:selected').val())
            }
        })

        function showErrors(msg) {
            $('.alert').hide()
            $('.alert-danger').show()
            $('#msgError').text(msg)
        }

        let cep = ""
        $('#zipcode').on('keypress', function(e) {
            cep = this.value.replace("-","")
            getAddress(cep)
        })
        $('#getAddress').click(function(){
            if(cep == "") {
                cep = $('#zipcode').val().replace("-","")
                getAddress(cep)
            }
        })

        function getAddress(cep) {
            $.ajax({
                type: 'get',
                url: '//viacep.com.br/ws/'+cep+'/json/',
                async: true,
                success: function(data) {
                    console.log(data)
                    $('[name=address]').val(data.logradouro)
                    $('[name=neighborhood]').val(data.bairro)
                    $('[name=city]').val(data.localidade)
                    $('[name=state]').val(data.uf)
                    $('[name=country]').val("Brasil")
                }
            })
        }
    })

</script>





@endpush
