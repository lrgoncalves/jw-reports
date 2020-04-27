<html>
    <head>
        <title>Relatórios Gerais da Congregação </title>

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

    @foreach ($data as $d)

        <table class="data">
            <tr>
                <th colspan="7" style="text-align: center;"> {{ $d['type'] }}</th>
            </tr>
            <tr>
                <td colspan="7">

                    <table class='report' style="margin-left: 0;">
                        <tr>
                            <th>
                                Ano de serviço <br /> <span>{{ $d['year_service']}}</span>
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

                        @foreach($d['report'] as $r)

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
                
                </td>
            </tr>
        </table>        

        <div class="page-break"></div>
        
        @endforeach

    
    
    
    </body>
</html>

