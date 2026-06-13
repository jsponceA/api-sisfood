<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE TRABAJADORES</title>
</head>
<body>
<table>
    <thead>
    <!-- PRIMERA FILA: Títulos principales -->
    <tr>
        <th colspan="6" style="font-weight: bold;text-align: center;border: 1px solid black;">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">{{$p->format('d/m/Y')}}</th>
        @endforeach
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. ALMUERZO</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. CENA</th>
        <th rowspan="3" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">AUTORIZO<br>DESCUENTO</th>
    </tr>

    <!-- SEGUNDA FILA: ALMUERZO y CENA -->
    <tr>
        <th colspan="6" style="border: 1px solid black;"></th>
        @foreach($periodo as $p)
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">ALMUERZO</th>
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">CENA</th>
        @endforeach
        <th colspan="4" style="border: 1px solid black;"></th>
        <th colspan="4" style="border: 1px solid black;"></th>
    </tr>

    <!-- TERCERA FILA: Columnas específicas -->
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">AREA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">TIPO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">CENTRO DE COSTO</th>
        @foreach($periodo as $p)
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
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $key => $w)
        @php
        $cantidadAlmuerzo = 0;
        $cantidadCena = 0;
        $totalSubvencionAlmuerzo = 0;
        $totalSubvencionCena = 0;
        $totalDescuentoAlmuerzo = 0;
        $totalDescuentoCena = 0;

        $cantidadAlmuerzoSubvencion = 0;
        $cantidadAlmuerzoDescuento = 0;
        $cantidadCenaSubvencion = 0;
        $cantidadCenaDescuento = 0;
        @endphp
        <tr>
            <!-- Datos del trabajador -->
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->area?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->workerType?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->costCenter?->name}}</td>

            @foreach($periodo as $p)
                @php
                $almuerzoSubvencion = 0;
                $almuerzoDescuento = 0;
                $cenaSubvencion = 0;
                $cenaDescuento = 0;



                // Recorrer las ventas del trabajador para el día específico
                foreach($w->sales as $sale) {
                      // Verificar si la venta corresponde a la fecha del período actual
                        if(!empty($sale->sale_date)) {
                            $saleDate = \Carbon\Carbon::parse($sale->sale_date);
                            if(!$saleDate->isSameDay($p)) {
                                continue; // Saltar a la siguiente venta si la fecha no coincide
                            }
                        } else {
                            continue; // Saltar si no hay fecha de venta
                        }


                    // Verificar si esta venta tiene productos de almuerzo o cena
                    $hasAlmuerzo = false;
                    $hasCena = false;

                    foreach($sale->saleDetails as $detail) {
                        $categoryName = $detail->product?->category?->name;

                        if($categoryName == 'ALMUERZO') {
                            $hasAlmuerzo = true;
                        }
                        else if($categoryName == 'CENA') {
                            $hasCena = true;
                        }
                    }

                    // Marcar con 1 si hubo almuerzo o cena según el tipo
                    if($hasAlmuerzo) {
                        if($sale->deal_in_form == 'SUBVENCION') {
                            $almuerzoSubvencion = 1;
                            $cantidadAlmuerzoSubvencion++;
                            $totalSubvencionAlmuerzo += $sale->total_pay_company ?? 0;
                        }
                        if($sale->deal_in_form == 'SUBVENCION' && $sale->total_dsct_form > 0) {
                            $almuerzoDescuento = 1;
                            $cantidadAlmuerzoDescuento++;
                            $totalDescuentoAlmuerzo += $sale->total_dsct_form ?? 0;
                        }
                    }

                    if($hasCena) {
                        if($sale->deal_in_form == 'SUBVENCION') {
                            $cenaSubvencion = 1;
                            $cantidadCenaSubvencion++;
                            $totalSubvencionCena += $sale->total_pay_company ?? 0;
                        }
                        if($sale->deal_in_form == 'SUBVENCION' && $sale->total_dsct_form > 0) {
                            $cenaDescuento = 1;
                            $cantidadCenaDescuento++;
                            $totalDescuentoCena += $sale->total_dsct_form ?? 0;
                        }
                    }
                }
                @endphp

                <!-- ALMUERZO: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($almuerzoSubvencion > 0)
                        {{$almuerzoSubvencion}}
                    @endif
                </td>
                <!-- ALMUERZO: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($almuerzoDescuento > 0)
                        {{$almuerzoDescuento}}
                    @endif
                </td>
                <!-- CENA: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($cenaSubvencion > 0)
                        {{$cenaSubvencion}}
                    @endif
                </td>
                <!-- CENA: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($cenaDescuento > 0)
                        {{$cenaDescuento}}
                    @endif
                </td>
            @endforeach

            <!-- TOTALES ALMUERZO -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadAlmuerzoSubvencion, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadAlmuerzoDescuento, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalSubvencionAlmuerzo, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalDescuentoAlmuerzo, 2)}}</td>

            <!-- TOTALES CENA -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadCenaSubvencion, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadCenaDescuento, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalSubvencionCena, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalDescuentoCena, 2)}}</td>

            <!-- AUTORIZO DESCUENTO -->
            <td style="text-align: center;border: 1px solid black"></td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
