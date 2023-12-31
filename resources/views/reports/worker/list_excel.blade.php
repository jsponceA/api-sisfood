<!doctype html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REPORTE DE TRABAJADORES</title>

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
        <th style="font-weight: bold;text-align: center">N° DOCUMENTO</th>
        <th style="font-weight: bold;text-align: center">APELLIDOS Y NOMBRES</th>
        <th style="font-weight: bold;text-align: center">FECHA DE INGRESO</th>
        <th style="font-weight: bold;text-align: center">FECHA DE CESE</th>
        <th style="font-weight: bold;text-align: center">AREA</th>
        <th style="font-weight: bold;text-align: center">TIPO PLANILLA</th>
        <th style="font-weight: bold;text-align: center">CENTRO DE COSTO</th>
        <th style="font-weight: bold;text-align: center">DESAYUNO</th>
        <th style="font-weight: bold;text-align: center">ALMUERZO</th>
        <th style="font-weight: bold;text-align: center">CENA</th>
        <th style="font-weight: bold;text-align: center">FEC. REGISTRO</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $w)
        <tr>
            <td style="text-align: center">{{ $w->numdoc.'' }}</td>
            <td style="text-align: center">{{ $w->surnames.' '.$w->names }}</td>
            <td style="text-align: center">{{ !empty($w->admission_date) ? now()->parse($w->admission_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{ !empty($w->suspension_date) ? now()->parse($w->suspension_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{ $w->area->name }}</td>
            <td style="text-align: center">{{ $w->typeForm->name }}</td>
            <td style="text-align: center">{{ $w->costCenter->name }}</td>
            <td style="text-align: center">
                @if(!empty($w->breakfast))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(!empty($w->lunch))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">
                @if(!empty($w->dinner))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
            <td style="text-align: center">{{ !empty($w->created_at) ? now()->parse($w->created_at)->format("d/m/Y") : ""}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
