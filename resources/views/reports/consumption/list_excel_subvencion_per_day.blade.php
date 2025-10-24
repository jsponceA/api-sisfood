<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE TRABAJADORES</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">{{$p->format('d/m/Y')}}</th>
        @endforeach
    </tr>
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">AREA</th>
        @foreach($periodo as $p)
            <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">SUVENCION</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#FFFFEE">DESCUENTO</th>
        @endforeach
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.SUVENCION</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.DESCUENTO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">FACTURA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">PLANILLA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $key => $w)
        @php
        $cantidadSubvencion = 0;
        $totalSubvencion = 0;
        @endphp
        <tr>
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->area?->name}}</td>

            @foreach($periodo as $p)
                <td style="text-align: center;border: 1px solid black">
                    @if($w->sales()->whereDate('sale_date', $p->format('Y-m-d'))->count() > 0)
                    @php
                        $cantidadSubvencion++;
                        $totalSubvencion += $w->sales()->whereDate('sale_date', $p->format('Y-m-d'))->sum('total_pay_company');
                    @endphp
                        1
                    @endif
                </td>
                <td style="text-align: center;border: 1px solid black"></td>
            @endforeach

            <td style="text-align: center;border: 1px solid black">{{$cantidadSubvencion}}</td>
            <td style="text-align: center;border: 1px solid black">0</td>
            <td style="text-align: center;border: 1px solid black">{{$totalSubvencion * $cantidadSubvencion}}</td>
            <td style="text-align: center;border: 1px solid black">0</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
