<?php
namespace App\Imports;

use App\Models\Department;
use App\Models\Sector;
use App\Models\Subsector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use DB;
class ImportAllinone implements ToModel
{
   /* use Importable;

    private $sector, $subsector;*/


  /*  public function __construct()
    {
        $this->sector = Sector::all();
        $this->subsector = Subsector::all();
    }
*/
    protected $date;

    function __construct($date) {
    $this->date = $date;
   }

    protected $i=1;
    public function model(array $row )
    {

    
        
        if($this->i==1){}else{



            $department = DB::table('departments')->where([
                ['hod_code','=',$row[0]],
                ['hod_name','=',$row[1]],
                ['department_name','=',$row[2]]
            ])->first();

            
            if($department){

             $department_id=$department->id;
            }else{

              $department_id=DB::table('departments')->insertGetId([
                'hod_code' => $row[0],
                'hod_name' => $row[1],
                'department_name' => $row[2]
            ]);

            }

            $major_head = DB::table('majorhead')->where([
                ['department_id','=', $department_id],
                ['complete_head','=',$row[8]],
              
            ])->first();

            if($major_head){

             $major_head_id=$major_head->id;
            }else{


                $major_head_id=DB::table('majorhead')->insertGetId([
                        'department_id' => $department_id,
                        'mjr_head' => $row[3],
                        'sm_head' => $row[4],
                        'min_head' => $row[5],
                        'sub_head' => $row[6],
                        'bdgt_head' => $row[7],
                        'complete_head' => $row[8],

                ]);
            }

            $scheme_master = DB::table('scheme_master')->where([
                ['department_id','=',$department_id],
                ['majorhead_id','=',$major_head_id],
                ['scheme_name','=',$row[9]],
              
            ])->first();

            if($scheme_master){

             $scheme_master_id=$scheme_master->id;
            }else{


                $scheme_master_id=DB::table('scheme_master')->insertGetId([
                        'department_id' => $department_id,
                        'majorhead_id' =>  $major_head_id,
                        'scheme_name' => $row[9],
                       ]);
            }

            $soe_master = DB::table('soe_master')->where([
                ['department_id','=',$department_id],
                ['majorhead_id','=',$major_head_id],
                ['scheme_id','=',$scheme_master_id],
                ['soe_name','=',$row[10]],
              
            ])->first();

            if($soe_master){

             $soe_master_id=$soe_master->id;
            }else{


                $soe_master_id=DB::table('soe_master')->insertGetId([
                        'department_id' => $department_id,
                        'majorhead_id' =>  $major_head_id,
                        'scheme_id' =>  $scheme_master_id,
                        'soe_name' => $row[10],
                       ]);
            }
            $services = DB::table('services')->where('service_name',$row[14])->first();
            

            if($services){

             $service_id=$services->id;
            }else{


                $service_id=DB::table('services')->insertGetId([
                        'service_name' => $row[14],
                       ]);
            }

            $sector = DB::table('sectors')->where([
                ['service_id','=',$service_id],
                ['sector_name','=',$row[15]],
              
            ])->first();
            
 
            if($sector){

             $sector_id=$sector->id;
            }else{


                $sector_id=DB::table('sectors')->insertGetId([
                         'service_id' => $service_id,
                        'sector_name' => $row[15],
                       ]);
            }

            $sub_sector = DB::table('subsectors')->where([
                ['service_id','=',$service_id],
                ['sector_id','=',$sector_id],
                ['subsectors_name','=',$row[16]],
              
            ])->first();
            
 
            if($sub_sector){

             $sub_sector_id=$sub_sector->id;
            }else{


                $sub_sector_id=DB::table('subsectors')->insertGetId([
                         'service_id' => $service_id,
                          'sector_id' => $sector_id,
                        'subsectors_name' => $row[16],
                       ]);
            }

             $soe_budget_allocation = DB::table('soe_budget_allocation')->where([
                ['department_id','=',$department_id],
                ['majorhead_id','=',$major_head_id],
                ['scheme_id','=',$scheme_master_id],
                ['soe_id','=',$soe_master_id],
               
                ['service_id','=',$service_id], 
                 ['sector_id','=',$sector_id], 
                 ['subsector_id','=',$sub_sector_id],
              
            ])->first();
            
 
            if($soe_budget_allocation){

             $soe_budget_allocation_id=$soe_budget_allocation->id;
            }else{
               // print_r($row);die;

                $plan=0;
                if($row[13]=='SDB'){

                     $plan=1;
                }else if($row[13]=='CDB'){
                     $plan=2;

                }else if($row[13]=='NDB'){
                     $plan=3;
                }
                $soe_budget_allocation_id=DB::table('soe_budget_allocation')->insertGetId([
                         'department_id' => $department_id,
                         'majorhead_id' => $major_head_id,
                         'scheme_id' => $scheme_master_id,
                         'soe_id' => $soe_master_id,
                         'fin_year_id'=>$this->date,
                         'outlay' => $row[11]*100000,
                         'earmarked' => $row[12],
                         'plan_id' => $plan,
                         'sector_id' => $sector_id,
                         'subsector_id' => $sub_sector_id,
                         'service_id' => $service_id,
                         
                       ]);
            }







    }
       

$this->i++;

      /*  $sector_id =  $this->sector->where('sector_name',$row['sector_name'])->first();
        $subsector_id =  $this->subsector->where('subsectors_name',$row['subsectors_name'])->first();
        
        return new Department([
            'sector_id' => $sector_id->id,
            'subsector_id' => $subsector_id->id,
            'department_name' => $row['department_name'],
        ]);*/
    }
   /* public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'department_name' => 'unique:departments|min:5',

            // Above is alias for as it always validates in batches
            '*.department_name' => 'unique:departments|min:5',

        ];
    }*/
}