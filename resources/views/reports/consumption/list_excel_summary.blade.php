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
        <th style="border: 1px solid black;font-weight: bold;text-align: center">INTERNO</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">PATERNO</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">MATERNO</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">NOMBRE</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL DESAYUNOS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL ALMUERZOS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">CANTIDAD TOTAL CENAS</th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">MONTO TOTAL DE SNACK</th>
        <th></th>
        <th style="border: 1px solid black;font-weight: bold;text-align: center">RESUMEN</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($sales as $s)
        @php
            $arraySurnames = explode(" ",$s->worker->surnames);
           $fatherLastName = $arraySurnames[0] ?? "";
           $motherLastName = $arraySurnames[1] ?? "";
           $totalDesayunos = collect($s->saleDetails)->where("product_name","DESAYUNO")->count();
           $totalAlmuerzos = collect($s->saleDetails)->where("product_name","ALMUERZO")->count();
           $totalCenas = collect($s->saleDetails)->where("product_name","CENA")->count();
        @endphp
        <tr>
            <td style="border: 1px solid black;text-align: center">{{$s->worker?->payrollArea?->name}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker?->numdoc.''}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker?->personal_code.''}}</td>
            <td style="border: 1px solid black;text-align: center">{{$fatherLastName}}</td>
            <td style="border: 1px solid black;text-align: center">{{$motherLastName}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->worker->names}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_desayunos}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_almuerzos}}</td>
            <td style="border: 1px solid black;text-align: center">{{$s->total_cenas}}</td>
            <td style="border: 1px solid black;text-align: center">S/. {{$s->monto_snacks}}</td>
            <td></td>
            <td style="border: 1px solid black;">S/. 123.20</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;" align="center">0</td>
        <td style="border: 2px solid black;" align="center">0</td>
        <td style="border: 2px solid black;" align="center">0</td>
        <td style="border: 2px solid black;" align="center">S/. 0</td>
        <td></td>
        <td style="border: 2px solid black;" align="center">S/. 0</td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;" colspan="9" align="right">SUMA</td>
        <td align="center">S/. 0</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;background-color: #60b760" align="center">S/. 0</td>
    </tr>
    </tbody>
</table>

</body>
</html>