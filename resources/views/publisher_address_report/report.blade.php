<html>
    <head>
        <title>REGISTRO DE ENDEREÇOS DE PUBLICADORES</title>

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

                    <table class='report' style="margin-left: 0;">

                        <tr>
                            <th colspan="4">REGISTRO DE ENDEREÇOS DE PUBLICADORES</th>
                        </tr>
                        
                        @php
                            $i = 0;
                        @endphp

                        @foreach($data as $r)

                            @php
                                $i++;
                            @endphp

                            <tr>
                                <th>Nome</th>
                                <th>{{ $r['name'] }}</th>
                                <th>Telefone</th>
                                <th>{{ $r['phones'] }}</th>
                            </tr>

                            @foreach($r['family'] as $f)
                                
                                <tr>
                                    <td>Nome</td>
                                    <td>{{ $f['name'] }}</td>
                                    <td>Telefone</td>
                                    <td>{{ $f['phone_numbers'] }}</td>
                                </tr>

                            @endforeach

                            <tr>
                                <td>Endereço:</td>
                                <td colspan="3">{{ $r['address'] }}</td>
                            </tr>

                            @if (count($data) > $i)
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                            @endif


                        @endforeach

                    </table>
                </td>

        
    </body>
</html>