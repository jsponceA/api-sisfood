<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE EMPLEADOS MENSUAL</title>
</head>
<body>
{{--
    Descuento acumulado por dia (menu + adicionales). Los importes se calculan en
    App\Http\Traits\ConsumptionTrait::calcularPlanillaPorDia(), el mismo metodo que
    usa el reporte de planilla, y llegan resueltos en $planilla indexado por trabajador.
--}}
<table>
    <thead>
    <!-- PRIMERA FILA: datos del trabajador + fechas del periodo -->
    <tr>
        <th colspan="{{ 6 }}" style="font-weight: bold;text-align: center;border: 1px solid black;">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">{{$p->format('d/m/Y')}}</th>
        @endforeach
        <th rowspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">SUBTOTAL</th>
    </tr>

    <!-- SEGUNDA FILA: nombres de las columnas fijas -->
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">CODIGO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">TIPO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">CENTRO DE COSTO</th>
        @foreach($periodo as $p)
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">DESCUENTO</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $key => $w)
        @php
        $datosPlanilla = $planilla[$w->id];
        @endphp
        <tr>
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->personal_code}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->workerType?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->costCenter?->name}}</td>

            @foreach($periodo as $p)
                @php
                $descuentoDia = $datosPlanilla["dias"][$p->format('Y-m-d')]["descuentoDia"];
                @endphp
                <td style="text-align: center;border: 1px solid black">
                    @if($descuentoDia > 0)
                        {{number_format($descuentoDia, 2, '.', '')}}
                    @endif
                </td>
            @endforeach

            <!-- SUBTOTAL del trabajador en todo el periodo -->
            <td style="text-align: center;border: 1px solid black;font-weight: bold;">
                @if($datosPlanilla["totales"]["descuentoGeneral"] > 0)
                    {{number_format($datosPlanilla["totales"]["descuentoGeneral"], 2, '.', '')}}
                @endif
            </td>
        </tr>
    @endforeach

    <!-- TOTAL GENERAL: suma de todos los trabajadores -->
    <tr>
        <td colspan="6" style="text-align: right;border: 1px solid black;font-weight: bold;background-color:yellow">TOTAL GENERAL</td>
        @foreach($periodo as $p)
            @php
            $totalDia = $totalesPorDia[$p->format('Y-m-d')] ?? 0;
            @endphp
            <td style="text-align: center;border: 1px solid black;font-weight: bold;background-color:yellow">
                @if($totalDia > 0)
                    {{number_format($totalDia, 2, '.', '')}}
                @endif
            </td>
        @endforeach
        <td style="text-align: center;border: 1px solid black;font-weight: bold;background-color:yellow">
            @if($totalGeneral > 0)
                {{number_format($totalGeneral, 2, '.', '')}}
            @endif
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
