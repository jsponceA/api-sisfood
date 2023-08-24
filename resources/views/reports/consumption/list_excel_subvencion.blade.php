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
        <th style="font-weight: bold;text-align: center">CODIGO</th>
        <th style="font-weight: bold;text-align: center">CLIENTE</th>
        <th style="font-weight: bold;text-align: center">AREA</th>
        <th style="font-weight: bold;text-align: center">C.Costp</th>
        <th style="font-weight: bold;text-align: center">FECHA</th>
        <th style="font-weight: bold;text-align: center">PRODUCTO</th>
        <th style="font-weight: bold;text-align: center">PRECIO</th>
        <th style="font-weight: bold;text-align: center">CANTIDAD</th>
        <th style="font-weight: bold;text-align: center">PASI</th>
        <th style="font-weight: bold;text-align: center">COMEDOR</th>
        <th style="font-weight: bold;text-align: center">TOTAL</th>
        <th style="font-weight: bold;text-align: center">TIPO_DESCUENTO</th>
        <th style="font-weight: bold;text-align: center">TIPO_PLANILLA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($consumptions as $c)
        @php
                $quantity = number_format($c->saleDetails()->sum("quantity"));
                $totalPayCompany = number_format($c->total_pay_company,2);
                $totalDsctForm = number_format($c->total_dsct_form,2);
                $total = number_format($c->deal_in_form == "SUBVENCION" ? $c->total_igv : $c->total_sale,2);

        @endphp
        <tr>
            <td style="text-align: center">{{$c->worker?->numdoc.''}}</td>
            <td style="text-align: center">{{$c->worker?->numdoc.''}}</td>
            <td style="text-align: center">{{$c->worker?->surnames}} {{$c->worker?->names}}</td>
            <td style="text-align: center">{{$c->worker?->area?->name}}</td>
            <td style="text-align: center">{{$c->worker?->costCenter?->name}}</td>
            <td style="text-align: center">{{ !empty($c->sale_date) ? now()->parse($c->sale_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{$c->saleDetails()->get()->map(fn($q)=> number_format($q->quantity).'x '.$q->product->name)->implode("/ ")}}</td>
            <td style="text-align: center">{{$total}}</td>
            <td style="text-align: center">{{$quantity}}</td>
            <td style="text-align: center">{{$totalPayCompany}}</td>
            <td style="text-align: center">{{$totalDsctForm}}</td>
            <td style="text-align: center">{{$total}}</td>
            <td style="text-align: center">{{$c->deal_in_form}}</td>
            <td style="text-align: center">{{$c->worker?->typeForm?->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
