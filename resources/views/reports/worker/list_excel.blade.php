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
        <th style="font-weight: bold;text-align: center">Nº PERS.</th>
        <th style="font-weight: bold;text-align: center">NOMBRE DEL PERSONAL</th>
        <th style="font-weight: bold;text-align: center">APELLIDO PATERNO</th>
        <th style="font-weight: bold;text-align: center">APELLIDO MATERNO</th>
        <th style="font-weight: bold;text-align: center">NOMBRE DE PILA</th>
        <th style="font-weight: bold;text-align: center">SEDE</th>
        <th style="font-weight: bold;text-align: center">ÁREA DE NÓMINA</th>
        <th style="font-weight: bold;text-align: center">RELACIÓN LABORAL</th>
        <th style="font-weight: bold;text-align: center">DIVISIÓN DE PERSONAL</th>
        <th style="font-weight: bold;text-align: center">ÁREA DE PERSONAL</th>
        <th style="font-weight: bold;text-align: center">POSICIÓN / CARGO</th>
        <th style="font-weight: bold;text-align: center">CE. COSTE</th>
        <th style="font-weight: bold;text-align: center">CENTRO DE COSTE</th>
        <th style="font-weight: bold;text-align: center">UNIDAD ORGANIZATIVA</th>
        <th style="font-weight: bold;text-align: center">DESDE</th>
        <th style="font-weight: bold;text-align: center">CLAVE DE SEXO</th>
        <th style="font-weight: bold;text-align: center">FECHA NAC.</th>
        <th style="font-weight: bold;text-align: center">NÚMERO ID</th>
        <th style="font-weight: bold;text-align: center">NOMBRE DEL SUPERVISOR (GO)</th>
        <th style="font-weight: bold;text-align: center">NEGOCIO</th>
        <th style="font-weight: bold;text-align: center">SUBVENCIÓN</th>
        <th style="font-weight: bold;text-align: center">DESAYUNO</th>
        <th style="font-weight: bold;text-align: center">ALMUERZO</th>
        <th style="font-weight: bold;text-align: center">CENA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($workers as $w)
        @php
        $arraySurnames = explode(" ",$w->surnames);
        $fatherLastName = $arraySurnames[0] ?? "";
        $motherLastName = $arraySurnames[1] ?? "";
        @endphp
        <tr>
            <td style="text-align: center">{{ $w->personal_code.'' }}</td>
            <td style="text-align: center">{{ $w->fullName }}</td>
            <td style="text-align: center">{{ $fatherLastName }}</td>
            <td style="text-align: center">{{ $motherLastName }}</td>
            <td style="text-align: center">{{ $w->names }}</td>
            <td style="text-align: center">{{ $w->campus->name }}</td>
            <td style="text-align: center">{{ $w->payrollArea->name }}</td>
            <td style="text-align: center">{{ $w->typeForm->name }}</td>
            <td style="text-align: center">{{ $w->staffDivision->name }}</td>
            <td style="text-align: center">{{ $w->area->name }}</td>
            <td style="text-align: center">{{ $w->charge->name }}</td>
            <td style="text-align: center">{{ $w->costCenter->code }}</td>
            <td style="text-align: center">{{ $w->costCenter->name }}</td>
            <td style="text-align: center">{{ $w->organizationalUnit->name }}</td>
            <td style="text-align: center">{{ !empty($w->admission_date) ? now()->parse($w->admission_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{ $w->gender->name }}</td>
            <td style="text-align: center">{{ !empty($w->birth_date) ? now()->parse($w->birth_date)->format("d/m/Y") : ""}}</td>
            <td style="text-align: center">{{ $w->numdoc.'' }}</td>
            <td style="text-align: center">{{ $w->superior->names }}</td>
            <td style="text-align: center">{{ $w->business->name }}</td>
            <td style="text-align: center">
                @if(!empty($w->grant))
                    <p style="color: green">SI</p>
                @else
                    <p style="color: red">NO</p>
                @endif
            </td>
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
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
