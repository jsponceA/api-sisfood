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
                $quantity = number_format($c->saleDetails()->sum("quantity"));

                $priceUnit = 0;
                $subvencion = 0;
                $workerPrice = 0;
                $total = 0;



                if (($c->worker?->grant && $c->deal_in_form == "SUBVENCION")){
                    //$priceUnit = ($c->total_pay_company + $c->total_dsct_form) / $quantity;
                    $priceUnit = ($c->total_pay_company) / $quantity;
                    $subvencion = $c->total_pay_company;
                    $workerPrice = $c->total_dsct_form;
                    //$total = $subvencion + $workerPrice;
                    $total = $subvencion;
                }elseif ( $c->deal_in_form == "DESCUENTO_PLANILLA"){
                    $priceUnit = $c->total_sale/ $quantity;
                     $subvencion = 0;
                     $workerPrice = $c->total_sale;
                     $total = $c->total_sale;
                }else{
                    $priceUnit = $c->total_sale/ $quantity;
                     $subvencion = 0;
                     $workerPrice = $c->total_sale;
                     $total = $c->total_sale;
                }

                 /*if (in_array("DESAYUNO",$c->saleDetails()->pluck("product_name")->toArray())){
                    $c->deal_in_form = "NO SUBVENCION";
                }
                if (!in_array("ALMUERZO",$c->saleDetails()->pluck("product_name")->toArray())){
                    $c->deal_in_form = "DESCUENTO_PLANILLA";
                }*/




        @endphp
        <tr>
            <td style="text-align: center">{{$c->worker?->numdoc.''}}</td>
            <td style="text-align: center">{{$c->worker?->personal_code.''}}</td>
            <td style="text-align: center">{{$c->worker?->fullName}}</td>
            <td style="text-align: center">{{$c->worker?->area?->name}}</td>
            <td style="text-align: center">{{$c->worker?->costCenter?->name}}</td>
            <td style="text-align: center">{{ !empty($c->sale_date) ? now()->parse($c->sale_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{$c->saleDetails()->get()->map(fn($q)=> number_format($q->quantity).'x '.$q->product->name)->implode("/ ")}}</td>
            {{--<td style="text-align: center">
                @if(!empty($c->worker?->grant))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>--}}
            <td style="text-align: center">{{$priceUnit}}</td>
            <td style="text-align: center">{{$quantity}}</td>
            <td style="text-align: center">{{$subvencion}}</td>
            <td style="text-align: center">{{$workerPrice}}</td>
            <td style="text-align: center">{{$total}}</td>
            <td style="text-align: center">
                @if($c->deal_in_form == "SUBVENCION")
                    @if(in_array("DESAYUNO",$c->saleDetails()->pluck("product_name")->toArray()))
                        NO SUBVENCION
                    @else
                        {{$c->worker?->grant ? 'SI' : 'NO'}} {{$c->deal_in_form}}
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
