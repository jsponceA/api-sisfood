<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REPORTE DE CONSUMOS</title>
</head>
<body>
<table>
    <thead>
    <tr>
        @if(!empty($params->dateStartConsumption) && !empty($params->dateEndConsumption))
            <th colspan="10"
                style="border: 1px solid black;font-weight: bold;text-align: center;background-color: #b7bdc1">REPORTE
                DE CONSUMOS DESDE {{now()->parse($params->dateStartConsumption)->format("d/m/Y")}}
                HASTA {{now()->parse($params->dateEndConsumption)->format("d/m/Y")}}</th>
        @endif
    </tr>
    <tr>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">AREA</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">DNI</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">NOMBRE</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">SUBVENCIONADO</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL DESAYUNOS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL ALMUERZOS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL CENAS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">MONTO TOTAL DE SNACK</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">TRABAJADOR DESCUENTO</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">SUBVENCIÓN EMPRESA</th>
    </tr>
    </thead>
    <tbody>
    @php
        $granTotalDesayunos = 0;
        $granTotalAlmuerzos = 0;
        $granTotalCenas = 0;

        $granTotalSnacks = 0;
        $granTotalResumen = 0;
        $granTotalSubvencion = 0;

    @endphp
    @foreach ($sales as $s)
        @php

              $granTotalDesayunos += $s->total_desayunos;
              $granTotalAlmuerzos += $s->total_almuerzos;
              $granTotalCenas += $s->total_cenas;

            // $totalResumen = $s->monto_desayunos + $s->monto_almuerzos + $s->monto_cenas + $s->monto_snacks;
             $totalResumen = $s->worker_price;
             $totalSubvencion = $s->total_subvencion;


              $granTotalResumen += $totalResumen;
              $granTotalSnacks += $s->monto_snacks;

              $granTotalSubvencion += $totalSubvencion;
        @endphp
        <tr>
            <td style="border: 1px solid black;text-align: center">{{$s->worker?->payrollArea?->name}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker?->numdoc.''}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker->names}}</td>
            <td style="border: 1px solid black;text-align: center">
                @if($s->worker->grant )
                    SI SUBVENCIÓN
                @elseif($s->worker->grant_complete)
                    SI SUBVENCIÓN COMPLETA
                @else
                    NO SUBVENCIÓN
                @endif
            </td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_desayunos}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_almuerzos}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_cenas}}</td>
            <td style="border: 1px solid black;text-align: center">S/ {{number_format($s->monto_snacks,2)}}</td>
            <td style="border: 1px solid black;" align="center">S/ {{number_format($totalResumen,2)}}</td>
            <td style="border: 1px solid black;" align="center">S/ {{number_format($totalSubvencion,2)}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;" align="center">{{$granTotalDesayunos}}</td>
        <td style="border: 2px solid black;" align="center">{{$granTotalAlmuerzos}}</td>
        <td style="border: 2px solid black;" align="center">{{$granTotalCenas}}</td>
        <td style="border: 2px solid black;" align="center">S/ {{number_format($granTotalSnacks,2)}}</td>
        <td style="border: 2px solid black;" align="center">S/ {{number_format($granTotalResumen,2)}}
        <td style="border: 2px solid black;" align="center">S/ {{number_format($granTotalSubvencion,2)}}</td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;font-weight: bold;" align="right">SUMA</td>
        <td style="border: 2px solid black" align="center">
            S/ {{number_format($granTotalResumen - $granTotalSnacks,2)}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;background-color: #60b760" align="center">
            S/ {{number_format($granTotalResumen,2)}}</td>
    </tr>
    </tbody>
</table>

</body>
</html>
