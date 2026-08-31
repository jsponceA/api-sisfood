<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PLANILLA DE SUBVENCION</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th  style="font-weight: bold;text-align: center">AREA</th>
        <th style="font-weight: bold;text-align: center">DNI</th>
        <th style="font-weight: bold;text-align: center">CODIGO</th>
        <th style="font-weight: bold;text-align: center">CLIENTE</th>
        <th style="font-weight: bold;text-align: center">AREA DE PERSONAL</th>
        <th style="font-weight: bold;text-align: center">C.COSTP</th>
        <th style="font-weight: bold;text-align: center">FECHA</th>
        <th style="font-weight: bold;text-align: center">PRODUCTO</th>
{{--        <th style="font-weight: bold;text-align: center">SUBVENCIONADO</th>--}}
        <th style="font-weight: bold;text-align: center">PRECIO</th>
        <th style="font-weight: bold;text-align: center">CANTIDAD</th>
        <th style="font-weight: bold;text-align: center">SUBVENCION</th>
        <th style="font-weight: bold;text-align: center">TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center">SUBTOTAL</th>
        <th style="font-weight: bold;text-align: center">TIPO DE DESCUENTO</th>
        <th style="font-weight: bold;text-align: center">RELACIÓN LABORAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($consumptions as $c)
        @php
            //los importes se toman de la venta, no de valores fijos:
            //asi el reporte refleja el reparto real registrado en cada consumo
            $detalles = $c->saleDetails;
            $quantity = $detalles->sum("quantity");

            if (in_array($c->deal_in_form, ["SUBVENCION","SUBVENCION_TOTAL"])) {
                $subvencion  = (float) $c->total_pay_company;   //lo que asume la empresa
                $workerPrice = (float) $c->total_dsct_form;     //lo que paga el trabajador
                $total       = $subvencion + $workerPrice;      //costo del consumo
            } else {
                //descuento por planilla o efectivo: el trabajador asume el importe completo
                $subvencion  = 0;
                $workerPrice = (float) $c->total_sale;
                $total       = (float) $c->total_sale;
            }

            $priceUnit = $quantity > 0 ? round($total / $quantity, 2) : 0;
        @endphp
        <tr>
            <td style="text-align: center">{{$c->worker?->payrollArea?->name}}</td>
            <td style="text-align: center">{{$c->worker?->numdoc.''}}</td>
            <td style="text-align: center">{{$c->worker?->personal_code.''}}</td>
            <td style="text-align: center">{{$c->worker?->fullName}}</td>
            <td style="text-align: center">{{$c->worker?->area?->name}}</td>
            <td style="text-align: center">{{$c->worker?->costCenter?->name}}</td>
            <td style="text-align: center">{{ !empty($c->sale_date) ? now()->parse($c->sale_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{$c->saleDetails()->get()->map(fn($q)=> number_format($q->quantity).'x '.$q->product->name)->implode("/ ")}}</td>
            <td style="text-align: center">{{$priceUnit}}</td>
            <td style="text-align: center">{{number_format($quantity)}}</td>
            <td style="text-align: center">{{$subvencion}}</td>
            <td style="text-align: center">{{$workerPrice}}</td>
            <td style="text-align: center">{{$total}}</td>
            <td style="text-align: center">
                @if($c->deal_in_form == 'SUBVENCION_TOTAL')
                    SUBVENCIÓN 100% EMPRESA
                @elseif($c->deal_in_form == 'SUBVENCION')
                    @if($c->worker?->grant)
                        SI SUBVENCIÓN
                    @else
                        NO SUBVENCIÓN
                    @endif
                @else
                    {{$c->deal_in_form}}
                @endif
            </td>
            <td style="text-align: center">{{$c->worker?->typeForm?->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
