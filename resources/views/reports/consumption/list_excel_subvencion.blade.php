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
        <th style="font-weight: bold;text-align: center">DNI</th>
        <th style="font-weight: bold;text-align: center">CLIENTE</th>
        <th style="font-weight: bold;text-align: center">AREA DE PERSONAL</th>
        <th style="font-weight: bold;text-align: center">C.COSTP</th>
        <th style="font-weight: bold;text-align: center">FECHA</th>
        <th style="font-weight: bold;text-align: center">PRODUCTO</th>
        <th style="font-weight: bold;text-align: center">PRECIO</th>
        <th style="font-weight: bold;text-align: center">CANTIDAD</th>
        <th style="font-weight: bold;text-align: center">SUBVENCION</th>
        <th style="font-weight: bold;text-align: center">TRABAJADOR</th>
        <th style="font-weight: bold;text-align: center">SUBTOTAL</th>
        <th style="font-weight: bold;text-align: center">TIPO DE DESCUENTO</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($consumptions as $c)
        @php
            $quantity = $c->saleDetails()->sum("quantity");
            $priceUnit = $c->total_sale / $quantity;
            $subvencion = $c->total_pay_company;
            $workerPrice = $c->total_dsct_form;
            $total = $c->total_sale;
        @endphp
        <tr>
            <td style="text-align: center">{{$c->worker?->numdoc.''}}</td>
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
                @if($c->worker?->grant)
                    SI SUBVENCIÓN
                @elseif($c->worker?->grant_complete)
                    SI SUBVENCIÓN COMPLETA
                 @else
                    {{$c->deal_in_form}}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
