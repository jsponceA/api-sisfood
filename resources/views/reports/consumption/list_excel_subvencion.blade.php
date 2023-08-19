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
        <th style="font-weight: bold;text-align: center">PLANILLA</th>
        <th style="font-weight: bold;text-align: center">AREA</th>
        <th style="font-weight: bold;text-align: center">C.Costp</th>
        <th style="font-weight: bold;text-align: center">FECHA</th>
        <th style="font-weight: bold;text-align: center">PRODUCTO</th>
        <th style="font-weight: bold;text-align: center">PRECIO</th>
        <th style="font-weight: bold;text-align: center">CANTIDAD</th>
        <th style="font-weight: bold;text-align: center">PASI</th>
        <th style="font-weight: bold;text-align: center">COMEDOR</th>
        <th style="font-weight: bold;text-align: center">TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($consumptions as $c)
        <tr>
            <td style="text-align: center">{{$c->sale?->worker?->numdoc}}</td>
            <td style="text-align: center">{{$c->sale?->worker?->numdoc}}</td>
            <td style="text-align: center">{{$c->sale?->worker?->names}} {{$c->sale->worker?->surnames}}</td>
            <td style="text-align: center">{{$c->sale?->worker?->typeForm?->name}}</td>
            <td style="text-align: center">{{$c->sale?->worker?->area?->name}}</td>
            <td style="text-align: center">{{$c->sale?->worker?->area?->name}}</td>
            <td style="text-align: center">{{ !empty($c->sale->sale_date) ? now()->parse($c->sale->sale_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{$c->product_name}}</td>
            <td style="text-align: center">{{number_format($c->sale?->total_igv,2)}}</td>
            <td style="text-align: center">{{number_format($c->quantity,2)}}</td>
            <td style="text-align: center">{{number_format($c->sale?->total_pay_company,2)}}</td>
            <td style="text-align: center">{{number_format($c->sale?->total_dsct_form,2)}}</td>
            <td style="text-align: center">{{number_format($c->sale?->total_igv * $c->quantity,2)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
