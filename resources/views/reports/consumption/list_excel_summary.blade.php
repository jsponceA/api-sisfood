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
            <th colspan="18"
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
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL CENAS</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL MENUS A</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE TRABAJADOR MENU A</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE SUBVENCIÓN MENU A</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL MENUS B</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE TRABAJADOR MENU B</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE SUBVENCIÓN MENU B</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL MENUS C</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE TRABAJADOR MENU C</th>
        <th style="background-color: yellow;border: 1px solid black;font-weight: bold;text-align: center">IMPORTE SUBVENCIÓN MENU C</th>
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

        $granTotalMenuA = 0;
        $granTotalMenuB = 0;
        $granTotalMenuC = 0;

        $granTotalSnacks = 0;
        $granTotalTrabajador = 0;
        $granTotalSubvencion = 0;

        $granTotalTrabajadorMenuA = 0;
        $granTotalSubvencionMenuA = 0;

        $granTotalTrabajadorMenuB = 0;
        $granTotalSubvencionMenuB = 0;

        $granTotalTrabajadorMenuC = 0;
        $granTotalSubvencionMenuC = 0;

    @endphp
    @foreach ($sales as $s)
        @php

              $granTotalDesayunos += $s->total_desayunos;
              $granTotalAlmuerzos += $s->total_almuerzos;
              $granTotalCenas += $s->total_cenas;
              $granTotalMenuA += $s->total_menu_a;
              $granTotalMenuB += $s->total_menu_b;
              $granTotalMenuC += $s->total_menu_c;

              $granTotalSnacks += $s->monto_snacks;
              $granTotalTrabajador += $s->worker_price;
              $granTotalSubvencion += $s->total_subvencion;

              $granTotalTrabajadorMenuA += $s->worker_price_menu_a;
              $granTotalSubvencionMenuA += $s->total_subvencion_menu_a;

              $granTotalTrabajadorMenuB += $s->worker_price_menu_b;
              $granTotalSubvencionMenuB += $s->total_subvencion_menu_b;

              $granTotalTrabajadorMenuC += $s->worker_price_menu_c;
              $granTotalSubvencionMenuC += $s->total_subvencion_menu_c;
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
            <td style="border: 1px solid black;text-align: center">{{$s->total_cenas}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_menu_a}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_subvencion_menu_a}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker_price_menu_a}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_menu_b}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_subvencion_menu_b}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker_price_menu_b}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_menu_c}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_subvencion_menu_c}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker_price_menu_c}}</td>
            <td style="border: 1px solid black;text-align: center">S/ {{number_format($s->monto_snacks,2)}}</td>
            <td style="border: 1px solid black;" align="center">S/ {{number_format($s->worker_price,2)}}</td>
            <td style="border: 1px solid black;" align="center">S/ {{number_format($s->total_subvencion,2)}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4"></td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalDesayunos}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalCenas}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalMenuA}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalTrabajadorMenuA}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalSubvencionMenuA}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalMenuB}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalTrabajadorMenuB}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalSubvencionMenuB}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalMenuC}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalTrabajadorMenuC}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">{{$granTotalSubvencionMenuC}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">S/ {{number_format($granTotalSnacks,2)}}</td>
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">S/ {{number_format($granTotalTrabajador,2)}}
        <td style="background-color: #6292fa;border: 2px solid black;" align="center">S/ {{number_format($granTotalSubvencion,2)}}</td>
    </tr>
   {{-- <tr>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td style="border: 2px solid black;font-weight: bold;" align="right">SUMA</td>
        <td style="border: 2px solid black" align="center">
            S/ {{number_format($granTotalResumen - $granTotalSnacks,2)}}</td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td style="border: 2px solid black;background-color: #60b760" align="center">
            S/ {{number_format($granTotalResumen,2)}}</td>
    </tr>--}}
    </tbody>
</table>

</body>
</html>
