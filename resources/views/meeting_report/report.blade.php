<html>
    <head>
        <title>REGISTRO DE ASSISTÊNCIA AS REUNIÕES CONGREGACIONAIS</title>

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
                <th style="text-align: center;">REGISTRO DE ASSISTÊNCIA AS REUNIÕES CONGREGACIONAIS</th>
            </tr>
            <tr>
                <td>
                    <span>Reunião do meio de semana</span>
                </td>
            </tr>

            <tr>
                <td>
                    <table class='report' style="margin-left: 0;">
                        <tr>
                            <th>
                                Ano de serviço <br /> <span> {{ $meetings['period']}}</span>
                            </th>
                            <th>Quantidade<br />de reuniões</th>
                            <th>Assistência<br />total</th>
                            <th>Assistência<br />média por<br />semana</th>
                        </tr>

                        @php
                            $totalMonth = 0;
                            $totalAvg = 0;
                        @endphp

                        @foreach($meetings['midweek'] as $r)

                        @php
                            if ($r['total_attendance'] > 0) {
                                $totalMonth += 1;
                                $totalAvg += $r['avg_meetings'];
                            }

                        @endphp

                            <tr>
                                <td>{{ $r['month'] }}</td>
                                <td>{{ ($r['total_meetings'] > 0) ? $r['total_meetings'] : '' }}</td>
                                <td>{{ ($r['total_attendance'] > 0) ? $r['total_attendance'] : '' }}</td>
                                <td>{{ ($r['avg_meetings'] > 0) ? $r['avg_meetings'] : '' }}</td>
                            </tr>
                        
                        @endforeach

                        <tr>
                            <td colspan="3" style="text-align: right;">Assistência média por mês</td>
                            <td>
                                {{ ($totalMonth > 0) ? round($totalAvg / $totalMonth, 2) : '' }}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr><td>&nbsp;</td></tr>

            <tr>
                <td>
                    <span>Reunião do fim de semana</span>
                </td>
            </tr>

            <tr>
                <td>
                    <table class='report' style="margin-left: 0;">
                        <tr>
                            <th>
                                Ano de serviço <br /> <span> {{ $meetings['period']}}</span>
                            </th>
                            <th>Quantidade<br />de reuniões</th>
                            <th>Assistência<br />total</th>
                            <th>Assistência<br />média por<br />semana</th>
                        </tr>

                        @php
                            $totalMonth = 0;
                            $totalAvg = 0;
                        @endphp

                        @foreach($meetings['weekend'] as $r)

                        @php
                            if ($r['total_attendance'] > 0) {
                                $totalMonth += 1;
                                $totalAvg += $r['avg_meetings'];
                            }

                        @endphp

                            <tr>
                                <td>{{ $r['month'] }}</td>
                                <td>{{ ($r['total_meetings'] > 0) ? $r['total_meetings'] : '' }}</td>
                                <td>{{ ($r['total_attendance'] > 0) ? $r['total_attendance'] : '' }}</td>
                                <td>{{ ($r['avg_meetings'] > 0) ? $r['avg_meetings'] : '' }}</td>
                            </tr>
                        
                        @endforeach

                        <tr>
                            <td colspan="3" style="text-align: right;">Assistência média por mês</td>
                            <td>
                                {{ ($totalMonth > 0) ? round($totalAvg / $totalMonth, 2) : '' }}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        
    </body>
</html>