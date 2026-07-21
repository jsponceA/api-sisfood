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
        $cantidadAlmuerzo = 0;
        $cantidadCena = 0;
        $totalSubvencionAlmuerzo = 0;
        $totalSubvencionCena = 0;
        $totalDescuentoAlmuerzo = 0;
        $totalDescuentoCena = 0;

        $cantidadDesayunoSubvencion = 0;
        $cantidadDesayunoDescuento = 0;
        $totalSubvencionDesayuno = 0;
        $totalDescuentoDesayuno = 0;

        $cantidadAlmuerzoSubvencion = 0;
        $cantidadAlmuerzoDescuento = 0;
        $cantidadCenaSubvencion = 0;
        $cantidadCenaDescuento = 0;

        $almuerzoDescuentoBaseDia = 0;
        $almuerzoExtrasDia = 0;
        $tieneAlmuerzoDia = false;
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
                // Los sábados el almuerzo se factura completo a la empresa (subvención), sin descuento a planilla
                $esSabado = $p->isSaturday();

                $desayunoSubvencion = 0;
                $desayunoDescuento = 0;
                $almuerzoSubvencion = 0;
                $almuerzoDescuento = 0;
                $cenaSubvencion = 0;
                $cenaDescuento = 0;
                $almuerzoDescuentoBaseDia = 0;
                $almuerzoExtrasDia = 0;
                $tieneAlmuerzoDia = false;



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


                    // Verificar si esta venta tiene productos de desayuno, almuerzo o cena
                    $hasDesayuno = false;
                    $hasAlmuerzo = false;
                    $hasCena = false;
                    $montoAlmuerzoVenta = 0; // total del/los almuerzo(s) de esta venta (dinámico desde sale_details)

                    // Precios dinámicos del producto/menú: subvención = company_price, descuento = worker_price
                    $desayunoCompanyPrice = 0; // subvención desayuno
                    $desayunoWorkerPrice = 0;  // descuento desayuno
                    $almuerzoCompanyPrice = 0; // subvención almuerzo (días normales)
                    $almuerzoWorkerPrice = 0;  // descuento almuerzo
                    $almuerzoSalePrice = 0;    // precio total del menú (sábados: factura completa a la empresa)
                    $cenaCompanyPrice = 0;     // subvención cena
                    $cenaWorkerPrice = 0;      // descuento cena

                    foreach($sale->saleDetails as $detail) {
                        $categoryName = $detail->product?->category?->name;
                        $detailAmount = $detail->total ?? 0;

                        if($detailAmount <= 0) {
                            $detailQuantity = max($detail->quantity ?? 1, 1);
                            $detailAmount = ($detail->sale_price ?? 0) * $detailQuantity;
                        }

                        if($categoryName == 'DESAYUNO') {
                            $hasDesayuno = true;
                            $desayunoCompanyPrice = $detail->product?->company_price ?? 0;
                            $desayunoWorkerPrice = $detail->product?->worker_price ?? 0;
                        }
                        else if($categoryName == 'ALMUERZO') {
                            $hasAlmuerzo = true;
                            $tieneAlmuerzoDia = true;
                            $almuerzoCompanyPrice = $detail->product?->company_price ?? 0;
                            $almuerzoWorkerPrice = $detail->product?->worker_price ?? 0;
                            $almuerzoSalePrice = $detail->product?->sale_price ?? 0;
                            // Costo del menú completo del almuerzo = precio de venta del producto (dinámico desde la BD)
                            $cantidadAlmuerzo = $detail->quantity ?? 1;
                            $precioMenuAlmuerzo = $detail->product?->sale_price ?? 0;
                            if($precioMenuAlmuerzo <= 0) {
                                // Respaldo: total del detalle o precio del detalle x cantidad
                                $precioMenuAlmuerzo = ($detail->total ?? 0) > 0
                                    ? ($detail->total / max($cantidadAlmuerzo, 1))
                                    : ($detail->sale_price ?? 0);
                            }
                            $montoAlmuerzoVenta += $precioMenuAlmuerzo * $cantidadAlmuerzo;
                                $almuerzoDescuentoBaseDia += $almuerzoWorkerPrice;
                        }
                        else if($categoryName == 'CENA') {
                            $hasCena = true;
                            $cenaCompanyPrice = $detail->product?->company_price ?? 0;
                            $cenaWorkerPrice = $detail->product?->worker_price ?? 0;
                            }
                            else if(!empty($categoryName) && !in_array($categoryName, ['DESAYUNO','LONCHE','ALMUERZO','CENA'])) {
                                // Cualquier categoría que no sea comida (DESAYUNO, LONCHE, ALMUERZO,
                                // CENA) se considera adicional/EXTRA del trabajador (EXTRAS, SNACKS,
                                // BEBIDAS, GASEOSAS, TORTAS, etc.) y se suma al DESCUENTO del almuerzo.
                                $almuerzoExtrasDia += $detailAmount;
                        }
                    }

                    // Marcar con el precio del producto (subvención = company_price, descuento = worker_price)
                    if($hasDesayuno) {
                        if($sale->deal_in_form == 'SUBVENCION') {
                            $desayunoSubvencion = $desayunoCompanyPrice;
                            $cantidadDesayunoSubvencion++;
                            $totalSubvencionDesayuno += $sale->total_pay_company ?? 0;
                        }
                        if($sale->deal_in_form == 'SUBVENCION' && $sale->total_dsct_form > 0) {
                            $desayunoDescuento = $desayunoWorkerPrice;
                            $cantidadDesayunoDescuento++;
                            $totalDescuentoDesayuno += $sale->total_dsct_form ?? 0;
                        }
                    }

                    if($hasAlmuerzo) {
                        if($esSabado) {
                            // Regla sábado: la empresa factura el menú completo, sin descuento al trabajador.
                            // SUBVENCION usa sale_price (precio total del menú); descuento vacío.
                            // FACTURA suma el total del almuerzo (desde el detalle de venta) y PLANILLA = 0.
                            $almuerzoSubvencion = $almuerzoSalePrice;
                            $almuerzoDescuento = 0;
                            $cantidadAlmuerzoSubvencion++;
                            $totalSubvencionAlmuerzo += $montoAlmuerzoVenta;
                            // PLANILLA (totalDescuentoAlmuerzo) no se incrementa los sábados
                        } else {
                            if($sale->deal_in_form == 'SUBVENCION') {
                                $almuerzoSubvencion = $almuerzoCompanyPrice;
                                $cantidadAlmuerzoSubvencion++;
                                $totalSubvencionAlmuerzo += $sale->total_pay_company ?? 0;
                            }
                        }
                    }

                    if($hasCena) {
                        if($sale->deal_in_form == 'SUBVENCION') {
                            $cenaSubvencion = $cenaCompanyPrice;
                            $cantidadCenaSubvencion++;
                            $totalSubvencionCena += $sale->total_pay_company ?? 0;
                        }
                        if($sale->deal_in_form == 'SUBVENCION' && $sale->total_dsct_form > 0) {
                            $cenaDescuento = $cenaWorkerPrice;
                            $cantidadCenaDescuento++;
                            $totalDescuentoCena += $sale->total_dsct_form ?? 0;
                        }
                    }
                }

                // Descuento a planilla del almuerzo:
                //  - Días normales (no sábado) con almuerzo: costo del menú para el trabajador
                //    (worker_price) + adicionales/EXTRAS del día.
                //  - Sábados: el menú se factura completo a la empresa, sin base para el trabajador,
                //    pero los adicionales/EXTRAS sí se descuentan.
                //  - Días con adicionales/EXTRAS pero SIN almuerzo: se descuentan igualmente los EXTRAS.
                if(!$esSabado && $tieneAlmuerzoDia) {
                    $almuerzoDescuento = $almuerzoDescuentoBaseDia + $almuerzoExtrasDia;
                    $cantidadAlmuerzoDescuento++;
                    $totalDescuentoAlmuerzo += $almuerzoDescuento;
                } elseif($almuerzoExtrasDia > 0) {
                    $almuerzoDescuento = $almuerzoExtrasDia;
                    $totalDescuentoAlmuerzo += $almuerzoDescuento;
                }

                @endphp

                <!-- DESAYUNO: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($desayunoSubvencion > 0)
                        {{number_format($desayunoSubvencion, 2)}}
                    @endif
                </td>
                <!-- DESAYUNO: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($desayunoDescuento > 0)
                        {{number_format($desayunoDescuento, 2)}}
                    @endif
                </td>
                <!-- ALMUERZO: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($almuerzoSubvencion > 0)
                        {{number_format($almuerzoSubvencion, 2)}}
                    @endif
                </td>
                <!-- ALMUERZO: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($almuerzoDescuento > 0)
                        {{number_format($almuerzoDescuento, 2)}}
                    @endif
                </td>
                <!-- CENA: SUBVENCION -->
                <td style="text-align: center;border: 1px solid black">
                    @if($cenaSubvencion > 0)
                        {{number_format($cenaSubvencion, 2)}}
                    @endif
                </td>
                <!-- CENA: DESCUENTO -->
                <td style="text-align: center;border: 1px solid black">
                    @if($cenaDescuento > 0)
                        {{number_format($cenaDescuento, 2)}}
                    @endif
                </td>
            @endforeach

            <!-- TOTALES DESAYUNO -->
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadDesayunoSubvencion, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($cantidadDesayunoDescuento, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalSubvencionDesayuno, 2)}}</td>
            <td style="text-align: center;border: 1px solid black;">{{number_format($totalDescuentoDesayuno, 2)}}</td>

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
