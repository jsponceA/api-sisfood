<?php

namespace App\Http\Traits;

use App\Models\Worker;
use Illuminate\Http\Request;

trait WorkerTrait
{

    public function queryList(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartSuspended = $request->input("dateStartSuspended");
        $dateEndSuspended = $request->input("dateEndSuspended");
        $dateStartAdmissionSuspended = $request->input("dateStartAdmissionSuspended");
        $dateEndAdmissionSuspended = $request->input("dateEndAdmissionSuspended");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $breakfast = $request->input("breakfast");
        $lunch = $request->input("lunch");
        $dinner = $request->input("dinner");

        $workers = Worker::query()
            ->with(["area", "typeForm","costCenter"])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where("names", "LIKE", "%{$search}%")
                    ->orWhere("surnames", "LIKE", "%{$search}%")
                    ->orWhere("numdoc", "LIKE", "%{$search}%");
            })
            ->when(!empty($dateStartSuspended), function ($q) use ($dateStartSuspended) {
                $q->whereDate("suspension_date", ">=", $dateStartSuspended);
            })
            ->when(!empty($dateEndSuspended), function ($q) use ($dateEndSuspended) {
                $q->whereDate("suspension_date", "<=", $dateEndSuspended);
            })
            ->when(!empty($dateStartAdmissionSuspended), function ($q) use ($dateStartAdmissionSuspended) {
                $q->whereDate("admission_date", ">=", $dateStartAdmissionSuspended);
            })
            ->when(!empty($dateEndAdmissionSuspended), function ($q) use ($dateEndAdmissionSuspended) {
                $q->whereDate("admission_date", "<=", $dateEndAdmissionSuspended);
            })
            ->when(!empty($typeFormId), function ($q) use ($typeFormId) {
                $q->where("type_form_id", $typeFormId);
            })
            ->when(!empty($areaId), function ($q) use ($areaId) {
                $q->where("area_id", $areaId);
            })
            ->when(!empty($breakfast), function ($q) use ($breakfast) {
                $q->where("breakfast", $breakfast);
            })
            ->when(!empty($lunch), function ($q) use ($lunch) {
                $q->where("lunch", $lunch);
            })
            ->when(!empty($dinner), function ($q) use ($dinner) {
                $q->where("dinner", $dinner);
            })
            ->orderByDesc("id");

        return $workers;
    }
}
