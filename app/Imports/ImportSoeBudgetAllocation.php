<?php

namespace App\Imports;

use App\Models\Soe_budget_allocation;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Finyear;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Sector;
use App\Models\Subsector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportSoeBudgetAllocation implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $department, $majorhead, $schememaster, $soemaster, $finyear,
        $plan, $service, $sector, $subsector;


    public function __construct()
    {
        $this->department = Department::all();
        $this->majorhead = Majorhead::all();
        $this->schememaster = Scheme_master::all();
        $this->soemaster = Soe_master::all();
        $this->finyear = Finyear::all();
        $this->plan = Plan::all();
        $this->service = Service::all();
        $this->sector = Sector::all();
        $this->subsector = Subsector::all();
    }

    public function model(array $row)
    {
        $department_id =  $this->department->where('department_name',$row['department_name'])->first();
        $majorhead_id =  $this->majorhead->where('complete_head',$row['complete_head'])->first();
        $schememaster_id =  $this->schememaster->where('scheme_name',$row['scheme_name'])->first();
        $soemaster_id =  $this->soemaster->where('soe_name',$row['soe_name'])->first();
        $finyear_id =  $this->finyear->where('finyear',$row['fin_year'])->first();
        $plan_id =  $this->plan->where('plan_name',$row['plan_name'])->first();
        $service_id =  $this->service->where('service_name',$row['service_name'])->first();
        $sector_id =  $this->sector->where('sector_name',$row['sector_name'])->first();
        $subsector_id =  $this->subsector->where('subsectors_name',$row['subsectors_name'])->first();

        if(array_key_exists('hod_outlay', $row))
        {
            $hod_outlay = $row['hod_outlay'] * 100000;
        } else {
            $hod_outlay = NULL;
        }

        if(array_key_exists('district_outlay', $row))
        {
            $district_outlay = $row['district_outlay'] * 100000;
        } else {
            $district_outlay = NULL;
        }
        
        return new Soe_budget_allocation([
            'department_id' => $department_id->id,
            'majorhead_id' => $majorhead_id->id,
            'scheme_id' => $schememaster_id->id,
            'soe_id' => $soemaster_id->id,
            'fin_year_id' => $finyear_id->id,
            'hod_outlay' => $hod_outlay,
            'district_outlay' => $district_outlay,
            'outlay' => $row['outlay']*100000,
            'earmarked' => $row['earmarked'],
            'plan_id' => $plan_id->id,
            'service_id' => $service_id->id,
            'sector_id' => $sector_id->id,
            'subsector_id' => $subsector_id->id,
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'department_name' => 'required',
            'complete_head' => 'required',
            'scheme_name' => 'required',
            'soe_name' => 'required',
            'fin_year' => 'required',
            'outlay' => 'required',
            'earmarked' => 'required',
            'plan_name' => 'required',
            'service_name' => 'required',
            'sector_name' => 'required',
            'subsectors_name' => 'required',

            // Above is alias for as it always validates in batches

            '*.department_name' => 'required',
            '*.complete_head' => 'required',
            '*.scheme_name' => 'required',
            '*.soe_name' => 'required',
            '*.fin_year' => 'required',
            '*.outlay' => 'required',
            '*.earmarked' => 'required',
            '*.plan_name' => 'required',
            '*.service_name' => 'required',
            '*.sector_name' => 'required',
            '*.subsectors_name' => 'required',     

        ];
    }
}