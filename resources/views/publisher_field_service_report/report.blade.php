<html>
    <head>
        <title>Relatório de {{ $publisherData['name'] }} </title>

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

            .page-break {
                page-break-after: always;
            }
            
        </style>
    </head>

    <body>

            @php
                $iniPage = 0;
            @endphp

            @foreach($arrayPages as $page)
                @if ($iniPage > 0) 
                    <div class="page-break"></div>
                @endif

                <table class="data">
                    <tr>
                        <th colspan="7" style="text-align: center;">REGISTRO DE PUBLICADOR DA CONGREGAÇÃO</th>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <span>Nome:</span> {{ $publisherData['name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <span>Data de nascimento:</span> {{ $publisherData['birthdate'] }}
                        </td>
                        <td>
                            <span>[ {{ ($publisherData['gender'] == 'M' ? 'x' : ' ') }} ] Masculino</span>
                        </td>
                        <td>
                            <span>[ {{ ($publisherData['gender'] == 'F' ? 'x' : ' ') }} ] Feminino</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <span>Data de batismo:</span>
                            {{ $publisherData['baptize'] }}
                        </td>
                        <td>
                            <span>[ {{ (!$publisherData['anointed'] ? 'x' : ' ') }} ] Outras ovelhas</span>
                        </td>
                        <td>
                            <span>[ {{ ($publisherData['anointed'] ? 'x' : ' ') }} ] Ungido</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div class='right'>
                                <span>[ {{ ($publisherData['privilege'] == 'OM' ? 'x' : ' ') }} ] Ancião</span>
                                &nbsp;
                                <span>[ {{ ($publisherData['privilege'] == 'MS' ? 'x' : ' ') }} ] Servo ministerial</span>
                                &nbsp;
                                <span>[ {{ ($publisherData['regular_pioneer'] ? 'x' : ' ') }} ] Pioneiro regular</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="7">

                            @foreach($page as $ys)
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
                                        $iniPage++;

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
                                            <td>
                                                @php
                                                    if ($r['field_service_id']) {
                                                        if (!$r['hours'] || $r['hours'] == '') {
                                                            echo "0";
                                                        } else {
                                                            echo $r['hours'];
                                                        }
                                                    } else {
                                                        echo "";
                                                    }
                                                @endphp
                                            </td>
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
                                            <td>{{ ($placements > 0) ? round($placements / $avg, 2) : 0 }}</td>
                                            <td>{{ ($videos > 0) ? round($videos / $avg, 2) : 0 }}</td>
                                            <td>{{ ($hours > 0) ? round($hours / $avg, 2) : 0 }}</td>
                                            <td>{{ ($return_visits > 0) ? round($return_visits / $avg, 2) : 0 }}</td>
                                            <td>{{ ($studies > 0) ? round($studies / $avg, 2) : 0 }}</td>
                                            <td></td>
                                        </tr>
                                </table>
                            @endforeach
                    
                        </td>
                    </tr>
                </table>
            @endforeach
        
    </body>
</html>

