<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>RESUMEN DE COMEDOR</title>
</head>
<body>
@php
    $bucketKeys = array_keys($buckets);

    // Estilos reutilizables
    $blueTitle  = "background-color:#305496;color:#FFFFFF;font-weight:bold;text-align:center;border:1px solid #305496;";
    $blueHead   = "background-color:#4472C4;color:#FFFFFF;font-weight:bold;text-align:center;border:1px solid #FFFFFF;";
    $orangeTitle= "background-color:#C55A11;color:#FFFFFF;font-weight:bold;text-align:center;border:1px solid #C55A11;";
    $orangeHead = "background-color:#ED7D31;color:#FFFFFF;font-weight:bold;text-align:center;border:1px solid #FFFFFF;";
    $cellName   = "border:1px solid #BFBFBF;text-align:left;";
    $cellNum    = "border:1px solid #BFBFBF;text-align:center;";
    $cellMoney  = "border:1px solid #BFBFBF;text-align:right;";
    $totalName  = "background-color:#D9E1F2;font-weight:bold;border:1px solid #BFBFBF;text-align:left;";
    $totalNum   = "background-color:#D9E1F2;font-weight:bold;border:1px solid #BFBFBF;text-align:center;";
    $totalBlueMoney   = "background-color:#D9E1F2;font-weight:bold;border:1px solid #BFBFBF;text-align:right;";
    $totalOrangeName  = "background-color:#FCE4D6;font-weight:bold;border:1px solid #BFBFBF;text-align:left;";
    $totalOrangeMoney = "background-color:#FCE4D6;font-weight:bold;border:1px solid #BFBFBF;text-align:right;";

    $granTotalCant = array_sum($totalCant);
    $granTotalImp  = array_sum($totalImp);
@endphp
<table>
    <thead>
    <!-- Título del reporte + rango de fechas -->
    <tr>
        <th colspan="{{ count($bucketKeys) * 2 + 5 }}" style="font-weight:bold;text-align:center;font-size:14px;">{{ $title }}</th>
    </tr>
    <!-- Títulos de cada cuadro -->
    <tr>
        <th colspan="{{ count($bucketKeys) + 2 }}" style="{{ $blueTitle }}">Cuenta de REFRIGERIO</th>
        <th style="border:none;"></th>
        <th colspan="{{ count($bucketKeys) + 2 }}" style="{{ $orangeTitle }}">Suma de PRECIO_REFRIG</th>
    </tr>
    <!-- Encabezados de columna -->
    <tr>
        <th style="{{ $blueHead }}">GERENCIA</th>
        @foreach($bucketKeys as $b)
            <th style="{{ $blueHead }}">{{ $buckets[$b] }}</th>
        @endforeach
        <th style="{{ $blueHead }}">TOTAL[CANT.]</th>
        <th style="border:none;"></th>
        <th style="{{ $orangeHead }}">GERENCIA</th>
        @foreach($bucketKeys as $b)
            <th style="{{ $orangeHead }}">{{ $buckets[$b] }}</th>
        @endforeach
        <th style="{{ $orangeHead }}">TOTAL[IMP.]</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $gerencia => $data)
        @php
            $rowCant = array_sum($data['cant']);
            $rowImp  = array_sum($data['imp']);
        @endphp
        <tr>
            <!-- Cuadro azul: cantidades -->
            <td style="{{ $cellName }}">{{ $gerencia }}</td>
            @foreach($bucketKeys as $b)
                <td style="{{ $cellNum }}">@if($data['cant'][$b] > 0){{ number_format($data['cant'][$b], 0) }}@endif</td>
            @endforeach
            <td style="{{ $cellNum }}">{{ number_format($rowCant, 0) }}</td>

            <td style="border:none;"></td>

            <!-- Cuadro naranja: importes -->
            <td style="{{ $cellName }}">{{ $gerencia }}</td>
            @foreach($bucketKeys as $b)
                <td style="{{ $cellMoney }}">@if($data['imp'][$b] > 0)S/ {{ number_format($data['imp'][$b], 2) }}@endif</td>
            @endforeach
            <td style="{{ $cellMoney }}">S/ {{ number_format($rowImp, 2) }}</td>
        </tr>
    @endforeach

    <!-- Totales por columna -->
    <tr>
        <td style="{{ $totalName }}">TOTAL[CANT.]</td>
        @foreach($bucketKeys as $b)
            <td style="{{ $totalNum }}">{{ number_format($totalCant[$b], 0) }}</td>
        @endforeach
        <td style="{{ $totalNum }}">{{ number_format($granTotalCant, 0) }}</td>

        <td style="border:none;"></td>

        <td style="{{ $totalOrangeName }}">TOTAL[IMP.]</td>
        @foreach($bucketKeys as $b)
            <td style="{{ $totalOrangeMoney }}">S/ {{ number_format($totalImp[$b], 2) }}</td>
        @endforeach
        <td style="{{ $totalOrangeMoney }}">S/ {{ number_format($granTotalImp, 2) }}</td>
    </tr>
    </tbody>
</table>

</body>
</html>
