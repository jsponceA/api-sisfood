<?php

namespace App\Imports;

use App\Models\CostCenter;
use App\Models\Worker;
use App\Models\WorkerType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WorkerBasicImport implements ToCollection
{
    private array $summary = [
        "created" => 0,
        "updated" => 0,
        "omitted" => 0,
        "cost_centers_created" => 0,
        "worker_types_created" => 0,
        "errors" => [],
    ];

    public function collection(Collection $rows): void
    {
        $rows->skip(1)->each(function ($row, int $index) {
            $rowNumber = $index + 1;

            if ($this->isEmptyRow($row)) {
                return;
            }

            $personalCode = $this->normalizeCode($row[0] ?? null, 6);
            $names = $this->normalizeText($row[1] ?? null);
            $numdoc = $this->normalizeCode($row[2] ?? null, 8);
            $costCenterName = $this->normalizeName($row[3] ?? null);
            $grant = $this->parseGrant($row[4] ?? null);
            $workerTypeName = $this->normalizeName($row[5] ?? null);

            if (!$names || !$numdoc) {
                $this->summary["omitted"]++;
                $this->summary["errors"][] = "Fila {$rowNumber}: falta Apellidos y Nombres o Nro. Doc. Identidad.";
                return;
            }

            $costCenter = $costCenterName ? $this->firstOrCreateCostCenter($costCenterName) : null;
            $workerType = $workerTypeName ? $this->firstOrCreateWorkerType($workerTypeName) : null;

            $worker = Worker::withTrashed()
                ->where("numdoc", $numdoc)
                ->first();

            $isNew = !$worker;

            if (!$worker) {
                $worker = new Worker([
                    "type_document_id" => 1,
                    "allowed_meals" => ["1", "2", "3"],
                    "grant_complete" => 0,
                    "terminated_worker" => 0,
                ]);
            } elseif ($worker->trashed()) {
                $worker->restore();
            }

            $worker->fill([
                "personal_code" => $personalCode,
                "names" => $names,
                "numdoc" => $numdoc,
                "cost_center_id" => $costCenter?->id,
                "worker_type_id" => $workerType?->id,
                "grant" => $grant,
            ]);

            if (empty($worker->allowed_meals)) {
                $worker->allowed_meals = ["1", "2", "3"];
            }

            if ($worker->grant_complete === null) {
                $worker->grant_complete = 0;
            }

            if ($worker->terminated_worker === null) {
                $worker->terminated_worker = 0;
            }

            if (!$worker->type_document_id) {
                $worker->type_document_id = 1;
            }

            $worker->save();

            $this->summary[$isNew ? "created" : "updated"]++;
        });
    }

    public function getSummary(): array
    {
        return $this->summary;
    }

    private function firstOrCreateCostCenter(string $name): CostCenter
    {
        $costCenter = CostCenter::withTrashed()
            ->whereRaw("UPPER(name) = ?", [$name])
            ->first();

        if ($costCenter) {
            if ($costCenter->trashed()) {
                $costCenter->restore();
            }

            return $costCenter;
        }

        $this->summary["cost_centers_created"]++;

        return CostCenter::query()->create(["name" => $name]);
    }

    private function firstOrCreateWorkerType(string $name): WorkerType
    {
        $workerType = WorkerType::withTrashed()
            ->whereRaw("UPPER(name) = ?", [$name])
            ->first();

        if ($workerType) {
            if ($workerType->trashed()) {
                $workerType->restore();
            }

            return $workerType;
        }

        $this->summary["worker_types_created"]++;

        return WorkerType::query()->create(["name" => $name]);
    }

    private function isEmptyRow(Collection $row): bool
    {
        return $row->filter(fn($value) => $this->normalizeText($value) !== "")->isEmpty();
    }

    private function normalizeText(mixed $value): string
    {
        if ($value === null) {
            return "";
        }

        return trim(preg_replace("/\s+/", " ", (string) $value));
    }

    private function normalizeName(mixed $value): string
    {
        return mb_strtoupper($this->normalizeText($value), "UTF-8");
    }

    private function normalizeCode(mixed $value, int $padLength): string
    {
        $text = $this->normalizeText($value);

        if ($text === "") {
            return "";
        }

        if (is_int($value) || is_float($value)) {
            $text = (string) (int) $text;
        }

        if (ctype_digit($text) && strlen($text) < $padLength) {
            return str_pad($text, $padLength, "0", STR_PAD_LEFT);
        }

        return $text;
    }

    private function parseGrant(mixed $value): int
    {
        $text = $this->normalizeName($value);

        return in_array($text, ["1", "SI", "SÍ", "YES", "TRUE", "VERDADERO", "X"], true)
            ? 1
            : 0;
    }
}
