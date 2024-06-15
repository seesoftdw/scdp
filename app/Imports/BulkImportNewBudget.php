<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Soe_budget_allocation;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Sector;
use App\Models\Subsector;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BulkImportNewBudget implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $dep = Department::where('hod_code',$row['hod_code'])->Where('department_name', $row['name_of_department'])->first();
  
        if(!$dep){
            $department = new Department;
            $department->hod_code = $row['hod_code'];
            $department->hod_name = $row['hod_name'];
            $department->department_name = $row['name_of_department'];
            $department->save();
            $department_id = $department->id;
        } else {
            $department_id = $dep->id;
        }

        $mjr_head = Majorhead::Where('department_id', $department_id)->Where('complete_head', $row['complete_head'])->first();
        if(!$mjr_head){
            $major = new Majorhead;
            $major->department_id = $department_id;
            $major->mjr_head = $row['mjr_head'];
            $major->sm_head = $row['sm_head'];
            $major->min_head = $row['min_head'];
            $major->sub_head = $row['sub_head'];
            $major->bdgt_head = $row['bdgt_head'];
            $major->type = 'revenue';
            $major->complete_head = $row['complete_head'];
            $major->save();
            $head_id = $major->id;
        } else {
            $head_id = $mjr_head->id;
        }

        $scheme_name = Scheme_master::Where('department_id', $department_id)->Where('majorhead_id', $head_id)->Where('scheme_name', $row['name_of_scheme'])->first();
        if(!$scheme_name){
            $scheme = new Scheme_master;
            $scheme->department_id = $department_id;
            $scheme->majorhead_id = $head_id;
            $scheme->scheme_name = $row['name_of_scheme'];
            $scheme->save();
            $scheme_id = $scheme->id;
        } else {
            $scheme_id = $scheme_name->id;
        }

        $soe_name = Soe_master::Where('department_id', $department_id)->Where('majorhead_id', $head_id)->Where('scheme_id', $scheme_id)->Where('soe_name', $row['soecd'])->first();
        if(!$soe_name){
            $soe = new Soe_master;
            $soe->department_id = $department_id;
            $soe->majorhead_id = $head_id;
            $soe->scheme_id = $scheme_id;
            $soe->soe_name = $row['soecd'];
            $soe->save();
            $soe_id = $soe->id;
        } else {
            $soe_id = $soe_name->id;
        }

        $plan_name = Plan::Where('plan_name', $row['plan'])->first();
        // if(!$plan_name){
        //     $plan = new Plan;
        //     $plan->plan_name = $row['plan'];
        //     $plan->save();
        //     $plan_id = $plan->id;
        // } else {
            $plan_id = $plan_name->id;
        // }

        $service_name = Service::Where('service_name', $row['services'])->first();
        if(!$service_name){
            $service = new Service;
            $service->service_name = $row['services'];
            $service->save();
            $service_id = $service->id;
        } else {
            $service_id = $service_name->id;
        }

        $sector_name = Sector::Where('sector_name', $row['sector'])->first();
        if(!$sector_name){
            $sector = new Sector;
            $sector->service_id = $service_id;
            $sector->sector_name = $row['sector'];
            $sector->department_id = $department_id;
            $sector->save();
            $sector_id = $sector->id;
        } else {
            $sector_id = $sector_name->id;
        }

        $subsectors_name = Subsector::Where('subsectors_name', $row['sub_sector'])->first();
        if(!$subsectors_name){
            $subsector = new Subsector;
            $subsector->service_id = $service_id;
            $subsector->sector_id = $sector_id;
            $subsector->department_id = $department_id;
            $subsector->subsectors_name = $row['sub_sector'];
            $subsector->save();
            $subsector_id = $subsector->id;
        } else {
            $subsector_id = $subsectors_name->id;
        }


        $out_amount = $row['sanction_budget'] * 100000;
        // $outlay = Soe_budget_allocation::where("department_id", $department_id)->where("majorhead_id", $head_id)->where("scheme_id",$scheme_id)->where("soe_id", $soe_id)->where("fin_year_id", 1)->where("plan_id", $plan_id)->where("service_id", $service_id)->where("subsector_id", $subsector_id)->first();
        $outlay = Soe_budget_allocation::where("soe_id", $soe_id)->where("fin_year_id", 1)->first();
        if(!$outlay){
        // print_r("dsf");
            $budget = new Soe_budget_allocation;
            $budget->department_id = $department_id;
            $budget->majorhead_id = $head_id;
            $budget->scheme_id = $scheme_id;
            $budget->soe_id = $soe_id;
            $budget->fin_year_id = '1';
            $budget->outlay = $out_amount;
            $budget->plan_id = $plan_id;
            $budget->service_id = $service_id;
            $budget->sector_id = $sector_id;
            $budget->subsector_id = $subsector_id;
            $budget->save();
        } 
        // print_r($outlay);die;

        return ;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            //department
            'hod_code' => 'required|unique:departments,hod_code|min:1|max:3',
            // 'hod_code' => 'required|min:1|max:3',
            'hod_name' => 'required|unique:departments,hod_name',
            // 'hod_name' => 'required',
            'name_of_department' => 'required|unique:departments,department_name',
            // 'name_of_department' => 'required',

            //majorhead
            'mjr_head' => 'required|min:4|max:4',
            'sm_head' => 'required|min:2|max:2',
            'min_head' => 'required|min:3|max:3',
            'sub_head' => 'required|min:2|max:2',
            'bdgt_head' => 'required|min:4|max:4',
            'complete_head' => 'required|unique:majorhead',
            // 'complete_head' => 'required',

            //scheme
            'name_of_scheme' => 'required',

            //soe
            'soecd' => 'required',

            //plan
            'plan' => 'required',

            //service
            'service_name' => 'unique:services|min:5',

            //sector
            'sector_name' => 'unique:sectors|min:5',

            //subsector
            'subsector_name' => 'unique:subsectors|min:5',

            //budget_allocation
            'sanction_budget' => 'required',
        ];
    }
    

}
