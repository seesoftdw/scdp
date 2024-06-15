<?php
namespace App\Exports;

use App\Models\Soe_budget_allocation;
use App\Models\Soe_budget_distribution;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use auth;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Export_scheme_wise_ndb implements FromCollection, WithHeadings, WithMapping {

    protected $id;

    function __construct($department) {
        $this->department = $department;
    }

    public function collection()
    {
        if(auth()->user()->role_id == 1)
        {
            if($this->department == 0)
            {
                $department = Department::all();
            } else {
                $department = Department::where('id', $this->department)->get();
            }
        }
        elseif(auth()->user()->role_id == 2)
        {
            $department = Department::where('id', auth()->user()->department_id)->get();
        }
        else
        {
            $department = Department::whereNull('id')->get();
        }
        return $department;
    }


    public function headings(): array
    {
        return ["Department Name", "MAJ/SM/MIN/SMIN/BUD", "Scheme Name", "Outlay for 2022-23", "Revised Outlay (Rs. in Lakh)", "Expenditure 31-03-2023
"];
    }

    public function map($row): array
    {
        $data = [];   

        foreach(Majorhead::where('department_id',$row['id'])->get() as $key => $value)
        {
            $dep_name = $row['department_name'];

            $headname = $value->complete_head;
            $scheme = Scheme_master::where('majorhead_id',$value->id)->first();
            $schemename = $scheme->scheme_name;
            $outlay = Soe_budget_allocation::where('majorhead_id',$value->id)->pluck('outlay')->toArray();
            $total = number_format(array_sum($outlay));


            $sbd = Soe_budget_distribution::where('majorhead_id',$value->id)->get();
            $arr = [];
            $expen = [];
            foreach($sbd as $diskey => $disvalue)
            {
                if($disvalue->q_1_data)
                {
                    $decode1 = json_decode($disvalue->q_1_data);
                    $count1 = count($decode1) - 1;
                    if($decode1[$count1]->resvised_outlay)
                    {
                        array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));
                    }
                    if($decode1[$count1]->expenditure)
                    {
                        array_push($expen, array_sum(get_object_vars(($decode1[$count1]->expenditure))));
                    }
                }
                if($disvalue->q_2_data)
                {
                    $decode2 = json_decode($disvalue->q_2_data);
                    $count2 = count($decode2) - 1;
                    if($decode2[$count2]->resvised_outlay)
                    {
                        array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));
                    }
                    if($decode2[$count2]->expenditure)
                    {
                        array_push($expen, array_sum(get_object_vars(($decode2[$count2]->expenditure))));
                    }
                }
                if($disvalue->q_3_data)
                {
                    $decode3 = json_decode($disvalue->q_3_data);
                    $count3 = count($decode3) - 1;
                    if($decode3[$count2]->resvised_outlay)
                    {
                        array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));
                    }
                    if($decode3[$count2]->expenditure)
                    {
                        array_push($expen, array_sum(get_object_vars(($decode3[$count3]->expenditure))));
                    }
                }
                if($disvalue->q_4_data)
                {
                    $decode4 = json_decode($disvalue->q_4_data);
                    $count4 = count($decode4) - 1;
                    if($decode4[$count4]->resvised_outlay)
                    {
                        array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));
                    }
                    if($decode4[$count4]->expenditure)
                    {
                        array_push($expen, array_sum(get_object_vars(($decode4[$count4]->expenditure))));
                    }
                }

            }
            $arr = array_sum($arr);
            $expen = array_sum($expen);

            
            $dataname = [
                            $dep_name,
                            $headname,
                            $schemename,
                            $total,
                            $arr,
                            $expen
                        ];
            array_push($data, $dataname);

        }

        return $data;

    }

}

?>