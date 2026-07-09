<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE TRABAJADORES</title>
</head>
<body>
@php
    // Orden de las comidas en cada grupo (según reporte solicitado)
    $mealKeys = ['DESAYUNO', 'ALMUERZO', 'LONCHE', 'CENA'];

    // Normaliza el nombre de categoría a una de las comidas del reporte
    $resolveBucket = function ($categoryName) {
        $name = strtoupper(trim((string) $categoryName));
        if ($name === 'DESAYUNO') return 'DESAYUNO';
        if ($name === 'ALMUERZO') return 'ALMUERZO';
        if ($name === 'CENA') return 'CENA';
        if (in_array($name, ['LONCHE', 'LONCHES', 'LOCHE', 'LOCHES'], true)) return 'LONCHE';
        return null;
    };
@endphp
<table>
    <thead>
    <!-- PRIMERA FILA: Títulos de grupo -->
    <tr>
        <th colspan="5" style="font-weight: bold;text-align: center;border: 1px solid black;">DATOS TRABAJADOR</th>
        @foreach($periodo as $p)
            <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">{{$p->format('d/m/Y')}}</th>
        @endforeach
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">CANTIDAD TOTAL</th>
        <th colspan="4" style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">IMPORTE TOTAL</th>
    </tr>

    <!-- SEGUNDA FILA: Sub-encabezados (datos del trabajador + comidas por grupo) -->
    <tr>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">N°</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">DNI</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">GERENCIA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;">AREA</th>
        @foreach($periodo as $p)
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">DESAYUNO</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">ALMUERZO</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">LONCHE</th>
            <th style="font-weight: bold;text-align: center;border: 1px solid black;">CENA</th>
        @endforeach
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">CANTIDAD DESAYUNO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">CANTIDAD ALMUERZO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">CANTIDAD LONCHE</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">CANTIDAD CENA</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT. DESAYUNO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT. ALMUERZO</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT. LONCHE</th>
        <th style="font-weight: bold;text-align: center;border: 1px solid black;background-color:yellow">TOT. CENA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $key => $w)
        @php
            // Acumuladores por tipo de comida (cantidad e importe) para el trabajador
            $cantidad = ['DESAYUNO' => 0, 'ALMUERZO' => 0, 'LONCHE' => 0, 'CENA' => 0];
            $importe  = ['DESAYUNO' => 0, 'ALMUERZO' => 0, 'LONCHE' => 0, 'CENA' => 0];
        @endphp
        <tr>
            <!-- Datos del trabajador -->
            <td style="text-align: center;border: 1px solid black">{{$key + 1}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->numdoc.''}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->fullName}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->managent?->name}}</td>
            <td style="text-align: center;border: 1px solid black">{{$w->area?->name}}</td>

            @foreach($periodo as $p)
                @php
                    // Importe por comida en este día (precio de venta x cantidad, dinámico)
                    $dia = ['DESAYUNO' => 0, 'ALMUERZO' => 0, 'LONCHE' => 0, 'CENA' => 0];

                    foreach($w->sales as $sale) {
                        if(empty($sale->sale_date)) {
                            continue;
                        }
                        if(!\Carbon\Carbon::parse($sale->sale_date)->isSameDay($p)) {
                            continue;
                        }

                        foreach($sale->saleDetails as $detail) {
                            $bucket = $resolveBucket($detail->product?->category?->name);
                            if($bucket === null) {
                                continue;
                            }

                            $qty = (float) ($detail->quantity ?? 0);
                            if($qty <= 0) {
                                $qty = 1;
                            }
                            // SALE_PRICE del producto que corresponde a la comida (dinámico desde la BD)
                            $price = (float) ($detail->product?->sale_price ?? $detail->sale_price ?? 0);
                            $amount = $price * $qty;

                            $dia[$bucket] += $amount;
                            $cantidad[$bucket] += $qty;
                            $importe[$bucket] += $amount;
                        }
                    }
                @endphp

                <td style="text-align: center;border: 1px solid black">@if($dia['DESAYUNO'] > 0){{ $dia['DESAYUNO'] }}@endif</td>
                <td style="text-align: center;border: 1px solid black">@if($dia['ALMUERZO'] > 0){{ $dia['ALMUERZO'] }}@endif</td>
                <td style="text-align: center;border: 1px solid black">@if($dia['LONCHE'] > 0){{ $dia['LONCHE'] }}@endif</td>
                <td style="text-align: center;border: 1px solid black">@if($dia['CENA'] > 0){{ $dia['CENA'] }}@endif</td>
            @endforeach

            <!-- CANTIDAD TOTAL -->
            <td style="text-align: center;border: 1px solid black">{{ $cantidad['DESAYUNO'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $cantidad['ALMUERZO'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $cantidad['LONCHE'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $cantidad['CENA'] }}</td>

            <!-- IMPORTE TOTAL -->
            <td style="text-align: center;border: 1px solid black">{{ $importe['DESAYUNO'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $importe['ALMUERZO'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $importe['LONCHE'] }}</td>
            <td style="text-align: center;border: 1px solid black">{{ $importe['CENA'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
