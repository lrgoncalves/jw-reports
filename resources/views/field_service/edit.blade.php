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

@include('components.confirmwarning', [
    'display'=>'none',
    'message'=>'Tem certeza que o publicador ficou irregular no mês?',
    'txtButton'=>'Sim!',
    'jqueryBtn'=>true
])

@include('components.confirmNonIrregular', [
    'display'=>'none',
    'txtButton'=>'Sim, deu testemunho!',
    'jqueryBtn'=>true
])

<div class="row">
    <div class="col-xs-12">
        <div class="box">


            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action="{{ $action }}">
                            {{csrf_field()}}
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                            <input type="hidden" name="id" value="{{ $fieldService->id }}">
                            
                            <input type="hidden" name="irregular" id="irregular" value="{{ $fieldService->irregular }}">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Publicador</label>
                                        <select class="form-control publisherSelect" id="publisherSelect" name="publisher_id" required>
                                            @foreach ($publishers as $item)
                                                <option value="{{ $item->id }}"
                                                {{ (($fieldService->publisher_id == $item->id) or ($pbid == $item->id)) ? 'selected' : ''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Perfil</label>
                                        <select class="form-control serviceTypesSelect" id="serviceTypesSelect" name="service_type_id" required>
                                            @foreach ($serviceTypes as $item)
                                                <option value="{{ $item->id }}"

                                                @if (($fieldService->service_type_id == $item->id))
                                                    selected
                                                @elseif ($item->id == $publisherServiceTypeId) 
                                                    selected
                                                @else
                                                    ''
                                                @endif
                                                >
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Ano de Serviço</label>
                                        <select class="form-control yearserviceSelect" id="yearserviceSelect" name="year_service_id" required>
                                            @foreach ($yearServices as $item)
                                                <option value="{{ $item->id }}"
                                                {{ (($fieldService->year_service_id == $item->id)) ? 'selected' : ''}}>
                                                    {{ $item->start_at->format('Y') }} / {{ $item->finish_at->format('Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mês</label>
                                        <select name="month" id="monthSelect" class="form-control monthSelect" required>
                                            <option value="">Selectione</option>
                                            <option value="9" {{ (($fieldService->month == 9) || ($lastMonth == 9)) ? 'selected' : ''}} >Setembro</option>
                                            <option value="10" {{ (($fieldService->month == 10) || ($lastMonth == 10)) ? 'selected' : ''}} >Outubro</option>
                                            <option value="11" {{ (($fieldService->month == 11) || ($lastMonth == 11)) ? 'selected' : ''}} >Novembro</option>
                                            <option value="12" {{ (($fieldService->month == 12) || ($lastMonth == 12)) ? 'selected' : ''}} >Dezembro</option>
                                            <option value="1" {{ (($fieldService->month == 1) || ($lastMonth == 1)) ? 'selected' : ''}} >Janeiro</option>
                                            <option value="2" {{ (($fieldService->month == 2) || ($lastMonth == 2)) ? 'selected' : ''}} >Fevereiro</option>
                                            <option value="3" {{ (($fieldService->month == 3) || ($lastMonth == 3)) ? 'selected' : ''}} >Março</option>
                                            <option value="4" {{ (($fieldService->month == 4) || ($lastMonth == 4)) ? 'selected' : ''}} >Abril</option>
                                            <option value="5" {{ (($fieldService->month == 5) || ($lastMonth == 5)) ? 'selected' : ''}} >Maio</option>
                                            <option value="6" {{ (($fieldService->month == 6) || ($lastMonth == 6)) ? 'selected' : ''}} >Junho</option>
                                            <option value="7" {{ (($fieldService->month == 7) || ($lastMonth == 7)) ? 'selected' : ''}} >Julho</option>
                                            <option value="8" {{ (($fieldService->month == 8) || ($lastMonth == 8)) ? 'selected' : ''}} >Agosto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Publicações</label>
                                        <input name="placements" type="number" class="form-control" placeholder="" value="{{ $fieldService->placements }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Vídeos</label>
                                        <input name="videos" type="number" class="form-control" placeholder="" value="{{ $fieldService->videos }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Horas</label>
                                        <input name="hours" id="input_hours" type="number" class="form-control" placeholder="" value="{{ $fieldService->hours }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Revisitas</label>
                                        <input name="return_visits" type="number" class="form-control" placeholder="" value="{{ $fieldService->return_visits }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Estudos</label>
                                        <input name="studies" type="number" class="form-control" placeholder="" value="{{ $fieldService->studies }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Observações</label>
                                        <input name="observations" id="input_observations" type="text" class="form-control" placeholder="" value="{{ $fieldService->observations }}"
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

                                <div class="col-md-2 right">
                                    <button type="button" class="btn btn-lg btn-block btn-danger" id="btn-irregular">Irregular</button>
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

            var hours = $('#input_hours').val();
            var irregular = $('#irregular').val();
            var observations = $('#input_observations').val();
            if (hours == '' && irregular == '0' && observations == '') {
                $('#confirmNonIrregular').show();
                return false;                
            }

            // console.log({hours, irregular, observations});
            // alert('chegou aqui');
            // return false;

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

        $('#btn-irregular').click(() => {
            $('#confirmWarning').show();
            return false;
        });

        $('.btn-warning-confirm').on('click', () => {

            $('#irregular').val(1);
            console.log($('form').serialize())
            $('form').submit();
            return false;
        })

        $('.btn-confirmNonIrregular-confirm').on('click', () => {
            $('#input_observations').val('Deu testemunho');
            console.log($('form').serialize())
            $('form').submit();
            return false;
        });

        function showErrors(msg) {
            $('.alert').hide()
            $('.alert-danger').show()
            $('#msgError').text(msg)
        }
    })

</script>





@endpush
