<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DESCUENTOS DE CONSUMO</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">CODIGO:</th>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">NOMBRE:</th>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">TIPO:</th>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">FECHA DE COMPRA:</th>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">TOTAL:</th>
        <th style="font-weight: bold;text-align: center;color: white;background-color: black">DETALLE DE COMPRA:</th>

    </tr>
    </thead>
    <tbody>
    @foreach ($consumptions as $c)
        <tr>
            <td style="border: 1px solid black;background-color: #C6E0B4">{{$c->worker?->numdoc}}</td>
            <td style="border: 1px solid black;background-color: #C6E0B4">{{$c->worker?->names}} {{$c->worker?->surnames}}</td>
            <td style="border: 1px solid black;background-color: #C6E0B4">{{$c->worker?->typeForm?->name}}</td>
            <td style="border: 1px solid black;background-color: #C6E0B4">{{ !empty($c->sale_date) ? now()->parse($c->sale_date)->format("d/m/Y") : ""}}</td>
            <td style="border: 1px solid black;background-color: #C6E0B4">{{$c->total_sale}}</td>
            <td style="border: 1px solid black;background-color: #C6E0B4">
                @foreach($c->saleDetails as $det)
                    {{$det->product_name.'/'}}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
