<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkerImportTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            "Código",
            "Apellidos y Nombres",
            "Nro. Doc. Identidad",
            "Centro de Costo",
            "Subvención",
            "Tipo Trabajador",
        ];
    }

    public function array(): array
    {
        return [
            [
                "000001",
                "RIVEROS LUCANA, MARIA OFELIA",
                "09652945",
                "MANTENIMIENTO",
                "SI",
                "OBRERO",
            ],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ["font" => ["bold" => true]],
        ];
    }
}
