<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE TRABAJADORES</title>
</head>
<body>
{{--
    Los importes de este reporte se calculan en App\Http\Traits\ConsumptionTrait::calcularPlanillaPorDia()
    y llegan ya resueltos en $planilla, indexado por id de trabajador. Esta vista solo presenta.
--}}
<table>
    <thead>
    <!-- PRIMERA FILA: Títulos principales -->
    <tr>
        <th colspan="7" style="font-weight: bold;text-align: center;border: 1px solid black;">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th colspan="6" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">{{$p->format('d/m/Y')}}</th>
        @endforeach
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. DESAYUNO</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. ALMUERZO</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. CENA</th>
        <th rowspan="3" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">AUTORIZO<br>DESCUENTO</th>
    </tr>

    <!-- SEGUNDA FILA: DESAYUNO, ALMUERZO y CENA -->
    <tr>
        <th colspan="7" style="border: 1px solid black;"></th>
        @foreach($periodo as $p)
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">DESAYUNO</th>
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">ALMUERZO</th>
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">CENA</th>
        @endforeach
        <th colspan="4" style="border: 1px solid black;"></th>
        <th colspan="4" style="border: 1px solid black;"></th>
        <th colspan="4" style="border: 1px solid black;"></th>
    </tr>

    <!-- TERCERA FILA: Columnas específicas -->
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">CODIGO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">AREA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">TIPO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">CENTRO DE COSTO</th>
        @foreach($periodo as $p)
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">SUBVENCION</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">DESCUENTO</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">SUBVENCION</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">DESCUENTO</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">SUBVENCION</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">DESCUENTO</th>
        @endforeach
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.SUBVENCION</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.DESCUENTO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">FACTURA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">PLANILLA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.SUBVENCION</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.DESCUENTO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">FACTURA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">PLANILLA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.SUBVENCION</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT.DESCUENTO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">FACTURA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">PLANILLA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $key => $w)
        @php
        $datosPlanilla = $planilla[$w->id];
        $tot = $datosPlanilla["totales"];
        @endphp
        <tr>
            <!-- Datos del trabajador -->
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->personal_code}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->area?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->workerType?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->costCenter?->name}}</td>

            @foreach($periodo as $p)
                @php
                $dia = $datosPlanilla["dias"][$p->format('Y-m-d')];
                @endphp

                <!-- DESAYUNO: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["desayunoSubvencion"] > 0)
                        {{number_format($dia["desayunoSubvencion"], 2)}}
                    @endif
                </td>
                <!-- DESAYUNO: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["desayunoDescuento"] > 0)
                        {{number_format($dia["desayunoDescuento"], 2)}}
                    @endif
                </td>
                <!-- ALMUERZO: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["almuerzoSubvencion"] > 0)
                        {{number_format($dia["almuerzoSubvencion"], 2)}}
                    @endif
                </td>
                <!-- ALMUERZO: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["almuerzoDescuento"] > 0)
                        {{number_format($dia["almuerzoDescuento"], 2)}}
                    @endif
                </td>
                <!-- CENA: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["cenaSubvencion"] > 0)
                        {{number_format($dia["cenaSubvencion"], 2)}}
                    @endif
                </td>
                <!-- CENA: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($dia["cenaDescuento"] > 0)
                        {{number_format($dia["cenaDescuento"], 2)}}
                    @endif
                </td>
            @endforeach

            <!-- TOTALES DESAYUNO -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadDesayunoSubvencion"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadDesayunoDescuento"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalSubvencionDesayuno"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalDescuentoDesayuno"], 2)}}</td>

            <!-- TOTALES ALMUERZO -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadAlmuerzoSubvencion"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadAlmuerzoDescuento"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalSubvencionAlmuerzo"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalDescuentoAlmuerzo"], 2)}}</td>

            <!-- TOTALES CENA -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadCenaSubvencion"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["cantidadCenaDescuento"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalSubvencionCena"], 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($tot["totalDescuentoCena"], 2)}}</td>

            <!-- AUTORIZO DESCUENTO -->
            <td style="text-align: center;border: 1px solid black"></td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
