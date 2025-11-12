<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE TRABAJADORES</title>
</head>
<body>
<table>
    <thead>
    @php
        $numDays = $periodo->count();
        $totalColumns = 5 + ($numDays * 6) + 12 + 1; // 5 fijas + días*6 + 12 totales + 1 snacks
        $dateStart = \Carbon\Carbon::parse($dateStartConsumption)->format('d/m/Y');
        $dateEnd = \Carbon\Carbon::parse($dateEndConsumption)->format('d/m/Y');
    @endphp
    <!-- FILA DE TÍTULO -->
    <tr>
        <th colspan="{{$totalColumns}}" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:#4472C4;color:white;font-size:14px;">
            REPORTE DE CONSUMO POR PERSONA DESDE: {{$dateStart}} HASTA {{$dateEnd}}
        </th>
    </tr>
    <!-- SEGUNDA FILA: Títulos principales -->
    <tr>
        <th colspan="5" style="font-weight: bold;text-align: center;border: 1px solid black;">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th colspan="6" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">{{$p->format('d/m/Y')}}</th>
        @endforeach
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. ALMUERZO</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. CENA</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;">TOT. LONCHE</th>
        <th rowspan="3" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT. SNACKS</th>
    </tr>

    <!-- TERCERA FILA: ALMUERZO, LONCHE y CENA -->
    <tr>
        <th colspan="5" style="border: 1px solid black;"></th>
        @foreach($periodo as $p)
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">ALMUERZO</th>
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">CENA</th>
            <th colspan="2" style="font-weight: bold;text-align: center;border: 1px solid black;">LONCHE</th>
        @endforeach
        <th colspan="4" style="border: 1px solid black;"></th>
        <th colspan="4" style="border: 1px solid black;"></th>
        <th colspan="4" style="border: 1px solid black;"></th>
    </tr>

    <!-- CUARTA FILA: Columnas específicas -->
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">TIPO TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">AREA</th>
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
            $cantidadAlmuerzo = 0;
            $cantidadLonche = 0;
            $cantidadCena = 0;
            $cantidadSnacks = 0;
            $totalSubvencionAlmuerzo = 0;
            $totalSubvencionLonche = 0;
            $totalSubvencionCena = 0;
            $otalSnacks = 0;
            $totalDescuentoAlmuerzo = 0;
            $totalDescuentoLonche = 0;
            $totalDescuentoCena = 0;
            $totalDescuentoSnacks = 0;

            $cantidadAlmuerzoSubvencion = 0;
            $cantidadAlmuerzoDescuento = 0;
            $cantidadLoncheSubvencion = 0;
            $cantidadLoncheDescuento = 0;
            $cantidadCenaSubvencion = 0;
            $cantidadCenaDescuento = 0;
            $cantidadSnacksTotal = 0;
        @endphp
        <tr>
            <!-- Datos del trabajador -->
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->workerType?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->area?->name}}</td>

            @foreach($periodo as $p)
                @php
                    $almuerzoSubvencion = 0;
                    $almuerzoDescuento = 0;
                    $loncheSubvencion = 0;
                    $loncheDescuento = 0;
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

                        // Verificar si esta venta tiene productos de almuerzo, lonche, cena o snacks
                        $hasAlmuerzo = false;
                        $hasLonche = false;
                        $hasCena = false;
                        $hasSnacks = false;

                        foreach($sale->saleDetails as $detail) {
                            $categoryName = $detail->product?->category?->name;

                            if($categoryName == 'ALMUERZO') {
                                $hasAlmuerzo = true;
                            }
                             if($categoryName == 'LONCHE') {
                                $hasLonche = true;
                            }
                             if($categoryName == 'CENA') {
                                $hasCena = true;
                            }
                            // Si no es ninguna de las categorías principales, es un snack
                            if($categoryName != 'ALMUERZO' && $categoryName != 'LONCHE' && $categoryName != 'CENA') {
                                $hasSnacks = true;
                            }
                        }

                        // Marcar con 1 si hubo almuerzo, lonche o cena según el tipo
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

                        if($hasLonche) {
                            if($sale->deal_in_form == 'SUBVENCION') {
                                $loncheSubvencion = 1;
                                $cantidadLoncheSubvencion++;
                                $totalSubvencionLonche += $sale->total_pay_company ?? 0;
                            }
                            if($sale->deal_in_form == 'SUBVENCION' && $sale->total_dsct_form > 0) {
                                $loncheDescuento = 0;
                                //$cantidadLoncheDescuento++;
                               // $totalDescuentoLonche += $sale->total_dsct_form ?? 0;
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

                        // Contar snacks
                        if($hasSnacks) {
                            if($sale->deal_in_form == 'DESCUENTO_PLANILLA') {
                                $cantidadSnacksTotal++;
                                $otalSnacks += $sale->total_sale ?? 0;
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
                <!-- LONCHE: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($loncheSubvencion > 0)
                        {{$loncheSubvencion}}
                    @endif
                </td>
                <!-- LONCHE: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($loncheDescuento > 0)
                        {{$loncheDescuento}}
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

            <!-- TOTALES LONCHE -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadLoncheSubvencion, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadLoncheDescuento, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalSubvencionLonche, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalDescuentoLonche, 2)}}</td>

            <!-- TOTAL DE SNACKS (productos distintos a ALMUERZO, CENA, LONCHE) -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadSnacksTotal, 2)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
