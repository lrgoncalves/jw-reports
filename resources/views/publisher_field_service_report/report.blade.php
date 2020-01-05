<html>
    <head>
        <title>Relatório de {{ $data['name'] }} </title>

        <style>
            body {
                font-family: Times New Roman;
            }

            table.data th {
                padding-bottom: 10px;
            }

            table.data td {
                font-size: 14px;
            }

            table.data td span {
                font-weight: bold;
                padding-right: 10px;
            }

            table.data td div.right {
                text-align: right
            }

            table.report {
                border-collapse: collapse;
                margin-top: 10px;
            }

            table.report, table.report th, table.report td {
                min-width: 70px;
                padding: 3px 10px 2px 10px;
                text-align: center;
                font-size: 12px;
            }

            table.report {
                border: 2px solid black;
            }

            table.report th, table.report td {
                border: 1px solid black;
            }

            table.report td.left {
                text-align: left;
            }

            table.report th span {
                font-weight: normal;
            }

            .bold {
                font-weight: bold;
            }
            
            th.obs, td.obs {
                min-width: 150px !important;;
                max-width: 150px;
            }
            
        </style>
    </head>

    <body>

        <table class="data">
            <tr>
                <th colspan="7" style="text-align: center;">REGISTRO DE PUBLICADOR DA CONGREGAÇÃO</th>
            </tr>
            <tr>
                <td colspan="7">
                    <span>Nome:</span> {{ $data['name'] }}
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <span>Data de nascimento:</span> {{ $data['birthdate'] }}
                </td>
                <td>
                    <span>[ {{ ($data['gender'] == 'M' ? 'x' : ' ') }} ] Masculino</span>
                </td>
                <td>
                    <span>[ {{ ($data['gender'] == 'F' ? 'x' : ' ') }} ] Feminino</span>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <span>Data de batismo:</span>
                    {{ $data['baptize'] }}
                </td>
                <td>
                    <span>[ {{ (!$data['anointed'] ? 'x' : ' ') }} ] Outras ovelhas</span>
                </td>
                <td>
                    <span>[ {{ ($data['anointed'] ? 'x' : ' ') }} ] Ungido</span>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <div class='right'>
                        <span>[ {{ ($data['privilege'] == 'OM' ? 'x' : ' ') }} ] Ancião</span>
                        &nbsp;
                        <span>[ {{ ($data['privilege'] == 'MS' ? 'x' : ' ') }} ] Servo ministerial</span>
                        &nbsp;
                        <span>[ {{ ($data['regular_pioneer'] ? 'x' : ' ') }} ] Pioneiro regular</span>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="7">

                    @foreach($data['year_services'] as $ys)
                        <table class='report' style="margin-left: 0;">
                            <tr>
                                <th>
                                    Ano de serviço <br /> <span>{{ $ys['period']}}</span>
                                </th>
                                <th>Publicações</th>
                                <th>Vídeos <br /> mostrados</th>
                                <th>Horas</th>
                                <th>Revisitas</th>
                                <th>Estudos <br />bíblicos</th>
                                <th class="obs">Observações</th>
                            </tr>

                            @php
                                $placements = 0;
                                $videos = 0;
                                $hours = 0;
                                $return_visits = 0;
                                $studies = 0;

                                $avg = 0;
                            @endphp

                            @foreach($ys['report'] as $r)

                                @php
                                    $placements += $r['placements'];
                                    $videos += $r['videos'];
                                    $hours += $r['hours'];
                                    $return_visits += $r['return_visits'];
                                    $studies += $r['studies'];

                                    if ($r['hours'] > 0) {
                                        $avg++;
                                    }

                                @endphp

                                <tr>
                                    <td class="left">{{ $r['month'] }}</td>
                                    <td>{{ $r['placements'] }}</td>
                                    <td>{{ $r['videos'] }}</td>
                                    <td>{{ $r['hours'] }}</td>
                                    <td>{{ $r['return_visits'] }}</td>
                                    <td>{{ $r['studies'] }}</td>
                                    <td class="obs">{{ $r['observations'] }}</td>
                                </tr>
                            @endforeach

                                <tr>
                                    <td class="left bold">Total</td>
                                    <td>{{ $placements }}</td>
                                    <td>{{ $videos }}</td>
                                    <td>{{ $hours }}</td>
                                    <td>{{ $return_visits }}</td>
                                    <td>{{ $studies }}</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td class="left bold">Média</td>
                                    <td>{{ round($placements / $avg, 2) }}</td>
                                    <td>{{ round($videos / $avg, 2) }}</td>
                                    <td>{{ round($hours / $avg, 2) }}</td>
                                    <td>{{ round($return_visits / $avg, 2) }}</td>
                                    <td>{{ round($studies / $avg, 2) }}</td>
                                    <td></td>
                                </tr>
                        </table>
                    @endforeach
                
                </td>
            </tr>
        
        
    </body>
</html>

