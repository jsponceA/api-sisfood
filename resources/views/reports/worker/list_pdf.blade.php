<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REPORTE DE TRABAJADORES</title>

    <style>
        body{
            text-transform: uppercase;
            font-size: 10px !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr th {
            border-bottom: 2px solid #000;
            border-top: 2px solid #000;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<div style="text-align: right">
    <p style="margin-top: 0 !important;margin-bottom: 0!important">FECHA : {{now()->format('d/m/Y')}}</p>
</div>

<div style="text-align: center">
    <p style="font-weight: bold;">LISTADO DE TRABAJADORES</p>
</div>

<table>
    <thead>
    <tr>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">DNI</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">DEPARTAMENTO</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">ÁREA</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">SECCIÓN</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">PUESTO_TRABAJO</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">CONDICIÓN</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">FECHA DE INGRESO</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">SUBVENCIÓN</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">SUBVENCIÓN COMPLETA</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">DESAYUNO</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">ALMUERZO</th>
        <th style="font-weight: bold;text-align: center;background-color: #002060;color: white">CENA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $w)
        <tr>
            <td style="text-align: center">{{ $w->numdoc.' ' }}</td>
            <td style="text-align: center">{{ $w->names }}</td>
            <td style="text-align: center">{{ $w->organizationalUnit->name }}</td>
            <td style="text-align: center">{{ $w->area->name }}</td>
            <td style="text-align: center">{{ $w->costCenter->name }}</td>
            <td style="text-align: center">{{ $w->charge->name }}</td>
            <td style="text-align: center">{{ $w->condition }}</td>
            <td style="text-align: center">{{ !empty($w->admission_date) ? now()->parse($w->admission_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">
                @if(!empty($w->grant))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(!empty($w->grant_complete))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(in_array(1,$w->allowed_meals))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(in_array(2,$w->allowed_meals))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(in_array(3,$w->allowed_meals))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
