<?php



namespace App\Http\Controllers;



use App\Models\Soe_budget_allocation;

use App\Models\Soe_budget_distribution;

use App\Models\Department;

use App\Models\Majorhead;

use App\Models\Scheme_master;

use App\Models\Soe_master;

use App\Models\Sector;

use App\Models\Service;

use App\Models\User;

use App\Models\Plan;

use App\Models\District;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

// use Maatwebsite\Excel\Facades\Excel;

// use App\Exports\Export_scheme_wise_ndb;

use auth;

use Response;



use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ReportsController extends Controller

{



    public function get_allocation_soe(Request $request)

    {

        $soeHtml='';

        if (!$request->scheme_id) {

            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';

        }

        else {

            $html = '';

            $soeList = Soe_master::where('scheme_id', $request->scheme_id)->get();

            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';

            foreach ($soeList as $soe) {

                $soeHtml .= '<option value="'.$soe->id.'">'.$soe->soe_name.'</option>';

            }

        }

        return response()->json(['soeHtml' => $soeHtml]);

    }



    public function get_allocation_sector_by_department(Request $request)

    {

        $sectorHtml='';

        if (!$request->id) {

            $sectorHtml .= '<option value="">'."---Select Sector---".'</option>';

        }

        else {

            $html = '';

            $sectorList = Sector::where('department_id', $request->id)->get();

            $sectorHtml .= '<option value="">'."---Select Sector---".'</option>';

            foreach ($sectorList as $sector) {

                $sectorHtml .= '<option value="'.$sector->id.'">'.$sector->sector_name.'</option>';

            }

        }

        return response()->json(['sector' => $sectorHtml]);

    }



    // -------------------------------- Department Wise SDB-------------------------------------------

    public function show_department_wise_state_db()

    {

        $plan = Plan::where('plan_name', 'SDB')->first();

        $plan_id = $plan->id;

        $districtList = District::all();

        if(auth()->user()->role_id == 1)

        {

            $department = Department::all();

            return view('reports.department-wise-state-db', compact('department','plan_id','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.department-wise-state-db', compact('department','plan_id','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }



    public function get_department_wise_state_db_data(Request $request)

    {

        $id = $request->dep_id;

        $sector_id = $request->sector_id;

        $plan_id = $request->plan_id;

        

        if(!$request->dep_id) {

            $department = Department::all();

        } else {

            $department = Department::where('id', $id)->get();

        }



        $table = "";

        $grand = [];

        $outley_grand = [];

        $exp_grand = [];



        foreach($department as $key => $value)

        {            

            if(!$sector_id)

            {

                $sector = Sector::where('department_id',$value->id)->get();

            } else {

                $sector = Sector::where('department_id',$value->id)->where('id', $sector_id)->get();

            }



            $total_of_sector = [];

            $exp_total_of_sector = [];

            $total_outley_dep = [];

            if(count($sector) == 0)

            {

                $total_outley_dep = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('outlay')->toArray();

            }



            $table .= "<tr>

                <td>". $key + 1 ."</td>

                <th>". $value->department_name ."</th>

                <td></td>

                <td></td>

                <td></td>

                <td></td>

            </tr>";

            foreach($sector as $sector_key => $sector_value)

            {

                $sector_outlay_total = Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('outlay')->toArray();

                array_push($total_outley_dep, array_sum($sector_outlay_total));



                $soe_id = Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('soe_id')->toArray();

                $sector_revise_outlay_total = Soe_budget_distribution::whereIn('soe_id', $soe_id)->get();

                $arr_add = [];

                $exp_arr_add = [];

                foreach($sector_revise_outlay_total as $diskey => $disvalue)

                {

                    $arr = [];

                    $exp_arr = [];

                    if($disvalue->q_1_data)

                    {

                        $decode1 = json_decode($disvalue->q_1_data);

                        $count1 = count($decode1) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode1[$count1]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                            }

                            if($decode1[$count1]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                            }

                        } else {

                            if($decode1[$count1]->resvised_outlay)

                            {

                                foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }

                            if($decode1[$count1]->expenditure)

                            {

                                foreach ($decode1[$count1]->expenditure as $exp_key => $exp_value) {

                                    

                                    if($exp_key == $request->district_id) {

                                        array_push($exp_arr, $exp_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_2_data)

                    {

                        $decode2 = json_decode($disvalue->q_2_data);

                        $count2 = count($decode2) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode2[$count2]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                            }

                            if($decode2[$count2]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                            }

                        } else {

                            if($decode2[$count2]->resvised_outlay)

                            {

                                foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }

                            if($decode2[$count2]->expenditure)

                            {

                                foreach ($decode2[$count2]->expenditure as $exp_key => $exp_value) {

                                    

                                    if($exp_key == $request->district_id) {

                                        array_push($exp_arr, $exp_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_3_data)

                    {

                        $decode3 = json_decode($disvalue->q_3_data);

                        $count3 = count($decode3) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode3[$count3]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                            }

                            if($decode3[$count3]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                            }

                        } else {

                            if($decode3[$count3]->resvised_outlay)

                            {

                                foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }

                            if($decode3[$count3]->expenditure)

                            {

                                foreach ($decode3[$count3]->expenditure as $exp_key => $exp_value) {

                                    

                                    if($exp_key == $request->district_id) {

                                        array_push($exp_arr, $exp_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_4_data)

                    {

                        $decode4 = json_decode($disvalue->q_4_data);

                        $count4 = count($decode4) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode4[$count4]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                            }

                            if($decode4[$count4]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                            }

                        } else {

                            if($decode4[$count4]->resvised_outlay)

                            {

                                foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }

                            if($decode4[$count4]->expenditure)

                            {

                                foreach ($decode4[$count4]->expenditure as $exp_key => $exp_value) {

                                    

                                    if($exp_key == $request->district_id) {

                                        array_push($exp_arr, $exp_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }



                    array_push($arr_add, array_sum($arr));

                    array_push($exp_arr_add, array_sum($exp_arr));

                }

                array_push($total_of_sector, array_sum($arr_add));

                array_push($exp_total_of_sector, array_sum($exp_arr_add));





                $table .= "<tr>

                    <td></td>

                    <td>". $sector_value->sector_name ."</td>

                    <td>". number_format(array_sum($sector_outlay_total)) ."</td>

                    <td>". array_sum($arr_add) ."</td>

                    <td>". array_sum($exp_arr_add) ."</td>

                    <td>";

                    if(array_sum($arr_add) > 0) { 

                        $table .= number_format(array_sum($exp_arr_add) / array_sum($arr_add) * 100 , 2, '.', '');

                    } 

                    $table .= "</td>

                </tr>";

            }

            array_push($outley_grand, array_sum($total_outley_dep));

            array_push($grand, array_sum($total_of_sector));

            array_push($exp_grand, array_sum($exp_total_of_sector));

            $table .= "<tr>

                <th></th>

                <th>Total : ".$value->department_name."</th>

                <th>". number_format(array_sum($total_outley_dep)) ."</th>

                <th>". number_format(array_sum($total_of_sector), 2, '.', '') ."</th>

                <th>". number_format(array_sum($exp_total_of_sector), 2, '.', '') ."</th>

                <th>";

                if(array_sum($total_of_sector) > 0) {

                    $table .= number_format(array_sum($exp_total_of_sector) / array_sum($total_of_sector) * 100 , 2, '.', '');

                }

                $table .= "</th>

            </tr>";

        }

        $table .= "<tr>

                <th></th>

                <th>GRAND TOTAL</th>

                <th>". number_format(array_sum($outley_grand)) ."</th>

                <th>". number_format(array_sum($grand), 2, '.', '') ."</th>

                <th>". number_format(array_sum($exp_grand), 2, '.', '') ."</th>

                <th>";

                if(array_sum($grand) > 0) {

                    $table .= number_format(array_sum($exp_grand) / array_sum($grand) * 100 , 2, '.', '');

                }

                $table .= "</th>

            </tr>";



        echo $table;

    }



    public function export_department_wise_state_db(Request $request)

    {

        $plan_id = $request->plan_id;

        $dep_id = $request->department;

        $sector_id = $request->sector;



        if(auth()->user()->role_id == 1)

        {

            if(!$dep_id)

            {

                $department = Department::all();

            } else {

                $department = Department::where('id', $request->department)->get();

            }

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

        }

        else

        {

            return redirect('dashboard');

        }



        $spreadsheet = new Spreadsheet();

        $activeWorksheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->mergeCells("A1:F1");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        $spreadsheet->getActiveSheet()->getStyle('A1:F999')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(35);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );

        if($plan_id == 1)

        {

            $activeWorksheet->setCellValue('A1', 'Department wise State Development Budget & Expenditure under Scheduled Caste Development Programme of the year 2022-23 (Rs. In Lakhs)');

        }

        if($plan_id == 2)

        {

            $activeWorksheet->setCellValue('A1', 'Department wise Central Development Budget & Expenditure under Scheduled Caste Development Programme of the year 2022-23 (Rs. In Lakhs)');

        }

        $spreadsheet->getActiveSheet()->freezePane('A1');

        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A2', 'Sr.No.');

        $activeWorksheet->setCellValue('B2', 'Name of Department');

        $activeWorksheet->setCellValue('C2', 'Outlay for 2022-23');

        $activeWorksheet->setCellValue('D2', 'Revised Outlay (Rs. in Lakh)');

        $activeWorksheet->setCellValue('E2', 'Expenditure 31-03-2023');  

        $activeWorksheet->setCellValue('F2', '% age from ReviseBudget');



        $grand = [];

        $outley_grand = [];

        $exp_grand = [];

        $i = 2;



        foreach($department as $key => $value)

        {

            $i++;



            if(!$sector_id)

            {

                $sector = Sector::where('department_id',$value->id)->get();

            } else {

                $sector = Sector::where('department_id',$value->id)->where('id', $request->sector)->get();

            }



            $total_of_sector = [];

            $exp_total_of_sector = [];

            $total_outley_dep = [];

            if(count($sector) == 0)

            {

                $total_outley_dep = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('outlay')->toArray();

            }



            $activeWorksheet->setCellValue('A'.$i+1, $key+1);

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

            $activeWorksheet->setCellValue('B'.$i+1, $value->department_name);

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

        



            foreach($sector as $sector_key => $sector_value)

            {

                $i++;

                $sector_outlay_total = Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('outlay')->toArray();

                array_push($total_outley_dep, array_sum($sector_outlay_total));



                $soe_id = Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('soe_id')->toArray();

                $sector_revise_outlay_total = Soe_budget_distribution::whereIn('soe_id', $soe_id)->get();

                $arr_add = [];

                $exp_arr_add = [];

                foreach($sector_revise_outlay_total as $diskey => $disvalue)

                {

                    $arr = [];

                    $exp_arr = [];

                    if($disvalue->q_1_data)

                    {



                        $decode1 = json_decode($disvalue->q_1_data);

                        $count1 = count($decode1) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode1[$count1]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                            }

                            if($decode1[$count1]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                            }

                        } else {



                            if($decode1[$count1]->resvised_outlay)

                            {

                                foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }



                            if($decode1[$count1]->expenditure)

                            {

                                foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($exp_arr, $dis_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_2_data)

                    {

                        $decode2 = json_decode($disvalue->q_2_data);

                        $count2 = count($decode2) - 1;

                        if(empty($rqeuest->district_id)) 

                        {

                            if($decode2[$count2]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                            }

                            if($decode2[$count2]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                            }

                        } else {

                            if($decode2[$count2]->resvised_outlay)

                            {

                                foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }



                            if($decode2[$count2]->expenditure)

                            {

                                foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($exp_arr, $dis_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_3_data)

                    {

                        $decode3 = json_decode($disvalue->q_3_data);

                        $count3 = count($decode3) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode3[$count3]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                            }

                            if($decode3[$count3]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                            }

                        } else {

                            if($decode3[$count3]->resvised_outlay)

                            {

                                foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }



                            if($decode3[$count3]->expenditure)

                            {

                                foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($exp_arr, $dis_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }

                    if($disvalue->q_4_data)

                    {

                        $decode4 = json_decode($disvalue->q_4_data);

                        $count4 = count($decode4) - 1;

                        if(empty($request->district_id))

                        {

                            if($decode4[$count4]->resvised_outlay)

                            {

                                array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                            }

                            if($decode4[$count4]->expenditure)

                            {

                                array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                            }

                        } else {



                            if($decode4[$count4]->resvised_outlay)

                            {

                                foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($arr, $dis_value);

                                    } else {

                                        array_push($arr, 0);

                                    }

                                }

                            }



                            if($decode4[$count4]->expenditure)

                            {

                                foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                    

                                    if($dis_key == $request->district_id) {

                                        array_push($exp_arr, $dis_value);

                                    } else {

                                        array_push($exp_arr, 0);

                                    }

                                }

                            }

                        }

                    }



                    array_push($arr_add, array_sum($arr));

                    array_push($exp_arr_add, array_sum($exp_arr));

                }

                array_push($total_of_sector, array_sum($arr_add));

                array_push($exp_total_of_sector, array_sum($exp_arr_add));



                $activeWorksheet->setCellValue('B'.$i+1, $sector_value->sector_name);

                $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($sector_outlay_total)));

                $activeWorksheet->setCellValue('D'.$i+1, array_sum($arr_add));

                $activeWorksheet->setCellValue('E'.$i+1, array_sum($exp_arr_add));

                if(array_sum($arr_add) > 0) { 

                    $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_arr_add) / array_sum($arr_add) * 100 , 2, '.', ''));

                }

            }

            array_push($outley_grand, array_sum($total_outley_dep));

            array_push($grand, array_sum($total_of_sector));

            array_push($exp_grand, array_sum($exp_total_of_sector));

            $i++;

            $activeWorksheet->setCellValue('B'.$i+1, "Total : ".$value->department_name);

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

            $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($total_outley_dep)));

            $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

            $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($total_of_sector), 2, '.', ''));

            $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

            $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_total_of_sector), 2, '.', ''));

            $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

            if(array_sum($total_of_sector) > 0) { 

                $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_total_of_sector) / array_sum($total_of_sector) * 100 , 2, '.', ''));

                $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

            }



        }



        $i++;

        if(!$dep_id)

        {

            $activeWorksheet->setCellValue('B'.$i+1, "GRAND TOTAL");

        } else {

            $activeWorksheet->setCellValue('B'.$i+1, "TOTAL");

        }

        $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

        $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($outley_grand)));

        $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

        $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($grand), 2, '.', ''));

        $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

        $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_grand), 2, '.', ''));

        $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

        if(array_sum($grand) > 0) { 

            $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_grand) / array_sum($grand) * 100 , 2, '.', ''));

            $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

        }



        $writer = new Xlsx($spreadsheet);

        if($plan_id == 1)

        {

            $filename = 'Department_wise_SDB(State_Development_Budget)_'.time().'.xlsx';

        } 

        if($plan_id == 2)

        {

            $filename = 'Department_wise_CDB(Central_Development_Budget)_'.time().'.xlsx';

        } 

        // $writer->save(public_path('Exports/'.$filename));

        // $filepath = public_path('Exports/'.$filename);

        // return Response::download($filepath);



        // $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        return $writer->save('php://output');

    }





    // -------------------------------- Scheme Wise SDB-------------------------------------------

    public function scheme_wise_state_db()

    {

        $plan = Plan::where('plan_name', 'SDB')->first();

        $plan_id = $plan->id;

        $service = Service::all();

        $districtList = District::all();

        if(auth()->user()->role_id == 1)

        {

            $department = Department::all();

            return view('reports.scheme-wise-state-db', compact('department','plan_id','service','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.scheme-wise-state-db', compact('department','plan_id','service','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }



    public function get_scheme_wise_state_db_data(Request $request)

    {

        $dep_id = $request->dep_id;

        $marjor_id = $request->marjor_id;

        $scheme_id = $request->scheme_id;

        $soe_id = $request->soe_id;

        $service_id = $request->service_id;

        $sector_id = $request->sector_id;

        $subsector_id = $request->subsector_id;

        $plan_id = $request->plan_id;



        $grand = [];

        $outley_grand = [];

        $exp_grand = [];



        $alphabet = range('A', 'Z');

        function integerToRoman($integer)

        {

            $integer = intval($integer);

            $result = '';

            $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);



            foreach($lookup as $roman => $value) {

                $matches = intval($integer/$value);

                $result .= str_repeat($roman,$matches);

                $integer = $integer % $value;

            }

            return $result;

        }



        $table = "";

        $grand_outley = [];

        $grand_revised_outley = [];

        $grand_exp_revised_outley = [];



        if(!$service_id) {

            $service = Service::all();

        } else { 

            $service = Service::where('id', $service_id)->get();

        }



        foreach($service as $key => $value)

        {

            $service_outley = [];

            $service_revised_outley = [];

            $service_exp_revised_outley = [];

            $table .= "<tr>

                <th>".$alphabet[$key]."</th>

                <th>".$value->service_name."</th>

                <th></th>

                <th></th>

                <th></th>

                <th></th>

            </tr>";



            if(!$sector_id) {

                $sector = Sector::where('service_id', $value->id)->get();

            } else { 

                $sector = Sector::where('service_id', $value->id)->where('id', $sector_id)->get();

            }

            foreach($sector as $sector_key => $sector_value)

            {

                $sector_outley = [];

                $sector_revised_outley = [];

                $sector_exp_revised_outley = [];

                $table .= "<tr>

                    <th>".integerToRoman($sector_key+1)."</th>

                    <th>".$sector_value->sector_name."</th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                </tr>";



                if(!$dep_id) {

                    $department = Department::where('id', $sector_value->department_id)->get();

                } else { 

                    $department = Department::where('id', $sector_value->department_id)->where('id', $dep_id)->get();

                }

                foreach($department as $department_key => $department_value)

                {

                    $table .= "<tr>

                        <th></th>

                        <th>".$department_key+1 .". ".$department_value->department_name."</th>

                        <th></th>

                        <th></th>

                        <th></th>

                        <th></th>

                    </tr>";

                    $dep_outley = [];

                    $revised_outley = [];

                    $exp_revised_outley = [];



                    if(!$marjor_id) {

                        $marjor = Majorhead::where('department_id',$department_value->id)->get();

                    } else { 

                        $marjor = Majorhead::where('department_id',$department_value->id)->where('id', $marjor_id)->get();

                    }



                    foreach($marjor as $headkey => $headvalue)

                    {

                        if(!$scheme_id) {

                            $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->get();

                        } else { 

                            $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->where('id', $scheme_id)->get();

                        }

                        foreach($scheme as $schemekey => $schemevalue)

                        {

                            $outley_soe = [];

                            $revised_outley_soe = [];

                            $exp_revised_outley_soe = [];



                            $table .= "<tr>

                                <td>".$headvalue->complete_head."</td>

                                <td>".$schemevalue->scheme_name."</td>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td></td>

                            </tr>";



                            if(!$soe_id) {

                                $soe = Soe_master::where('scheme_id',$schemevalue->id)->get();

                            } else { 

                                $soe = Soe_master::where('scheme_id',$schemevalue->id)->where('id', $soe_id)->get();

                            }

                            foreach($soe as $soekey => $soevalue)

                            {

                                $table .= "<tr>

                                    <td></td>

                                    <td>".$soevalue->soe_name."</td>";

                                    

                                    $soe_outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('soe_id',$soevalue->id)->pluck('outlay')->toArray();

                                    $soe_revised_outlay = Soe_budget_distribution::where('soe_id',$soevalue->id)->get();

                                    $arr = [];

                                    $exp_arr = [];

                                    foreach($soe_revised_outlay as $soe_revised_outlay_key => $soe_revised_outlay_value)

                                    {

                                        if($soe_revised_outlay_value->q_1_data)

                                        {



                                            $decode1 = json_decode($soe_revised_outlay_value->q_1_data);

                                            $count1 = count($decode1) - 1;

                                            if(empty($request->district_id))

                                            {

                                                if($decode1[$count1]->resvised_outlay)

                                                {

                                                    array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                                                }

                                                if($decode1[$count1]->expenditure)

                                                {

                                                    array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                                                }

                                            } else {



                                                if($decode1[$count1]->resvised_outlay)

                                                {

                                                    foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($arr, $dis_value);

                                                        } else {

                                                            array_push($arr, 0);

                                                        }

                                                    }

                                                }



                                                if($decode1[$count1]->expenditure)

                                                {

                                                    foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($exp_arr, $dis_value);

                                                        } else {

                                                            array_push($exp_arr, 0);

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                        if($soe_revised_outlay_value->q_2_data)

                                        {

                                            $decode2 = json_decode($soe_revised_outlay_value->q_2_data);

                                            $count2 = count($decode2) - 1;

                                            if(empty($rqeuest->district_id)) 

                                            {

                                                if($decode2[$count2]->resvised_outlay)

                                                {

                                                    array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                                                }

                                                if($decode2[$count2]->expenditure)

                                                {

                                                    array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                                                }

                                            } else {

                                                if($decode2[$count2]->resvised_outlay)

                                                {

                                                    foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($arr, $dis_value);

                                                        } else {

                                                            array_push($arr, 0);

                                                        }

                                                    }

                                                }



                                                if($decode2[$count2]->expenditure)

                                                {

                                                    foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($exp_arr, $dis_value);

                                                        } else {

                                                            array_push($exp_arr, 0);

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                        if($soe_revised_outlay_value->q_3_data)

                                        {

                                            $decode3 = json_decode($soe_revised_outlay_value->q_3_data);

                                            $count3 = count($decode3) - 1;

                                            if(empty($request->district_id))

                                            {

                                                if($decode3[$count3]->resvised_outlay)

                                                {

                                                    array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                                                }

                                                if($decode3[$count3]->expenditure)

                                                {

                                                    array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                                                }

                                            } else {

                                                if($decode3[$count3]->resvised_outlay)

                                                {

                                                    foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($arr, $dis_value);

                                                        } else {

                                                            array_push($arr, 0);

                                                        }

                                                    }

                                                }



                                                if($decode3[$count3]->expenditure)

                                                {

                                                    foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($exp_arr, $dis_value);

                                                        } else {

                                                            array_push($exp_arr, 0);

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                        if($soe_revised_outlay_value->q_4_data)

                                        {

                                            $decode4 = json_decode($soe_revised_outlay_value->q_4_data);

                                            $count4 = count($decode4) - 1;

                                            if(empty($request->district_id))

                                            {

                                                if($decode4[$count4]->resvised_outlay)

                                                {

                                                    array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                                                }

                                                if($decode4[$count4]->expenditure)

                                                {

                                                    array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                                                }

                                            } else {



                                                if($decode4[$count4]->resvised_outlay)

                                                {

                                                    foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($arr, $dis_value);

                                                        } else {

                                                            array_push($arr, 0);

                                                        }

                                                    }

                                                }



                                                if($decode4[$count4]->expenditure)

                                                {

                                                    foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                                        

                                                        if($dis_key == $request->district_id) {

                                                            array_push($exp_arr, $dis_value);

                                                        } else {

                                                            array_push($exp_arr, 0);

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                    }

                                    array_push($outley_soe , array_sum($soe_outlay));

                                    array_push($revised_outley_soe , array_sum($arr));

                                    array_push($exp_revised_outley_soe , array_sum($exp_arr));



                                    $table .= "<td>".number_format(array_sum($soe_outlay))."</td>

                                    <td>".number_format(array_sum($arr))."</td>

                                    <td>".number_format(array_sum($exp_arr))."</td>

                                    <td>";

                                    if(array_sum($soe_outlay) > 0) {

                                        $table .= number_format(array_sum($exp_arr) / array_sum($soe_outlay) * 100 , 2, '.', '');

                                    }

                                    $table .= "</td>

                                </tr>";

                            }

                            array_push($dep_outley , array_sum($outley_soe));

                            array_push($revised_outley , array_sum($revised_outley_soe));

                            array_push($exp_revised_outley , array_sum($exp_revised_outley_soe));

                            $table .= "<tr>

                                <td></td>

                                <th> Scheme Total: ".$schemevalue->scheme_name."</th>

                                <th>".number_format(array_sum($outley_soe))."</th>

                                <th>".number_format(array_sum($revised_outley_soe))."</th>

                                <th>".number_format(array_sum($exp_revised_outley_soe))."</th>

                                <th>";

                                if(array_sum($outley_soe) > 0) {

                                    $table .= number_format(array_sum($exp_revised_outley_soe) / array_sum($outley_soe) * 100 , 2, '.', '');

                                }

                                $table .= "</th>

                            </tr>";

                        }

                    }

                    array_push($sector_outley , array_sum($dep_outley));

                    array_push($sector_revised_outley , array_sum($revised_outley));

                    array_push($sector_exp_revised_outley , array_sum($exp_revised_outley));

                    $table .= "<tr>

                        <td></td>

                        <th> Department Total: ".$department_value->department_name."</th>

                        <th>".number_format(array_sum($dep_outley))."</th>

                        <th>".number_format(array_sum($revised_outley))."</th>

                        <th>".number_format(array_sum($exp_revised_outley))."</th>

                        <th>";

                        if(array_sum($dep_outley) > 0) {

                            $table .= number_format(array_sum($exp_revised_outley) / array_sum($dep_outley) * 100 , 2, '.', '');

                        }

                        $table .= "</th>

                    </tr>";

                }

                array_push($service_outley , array_sum($sector_outley));

                array_push($service_revised_outley , array_sum($sector_revised_outley));

                array_push($service_exp_revised_outley , array_sum($sector_exp_revised_outley));

                $table .= "<tr>

                    <td></td>

                    <th> Sector Total: ".$sector_value->sector_name."</th>

                    <th>".number_format(array_sum($sector_outley))."</th>

                    <th>".number_format(array_sum($sector_revised_outley))."</th>

                    <th>".number_format(array_sum($sector_exp_revised_outley))."</th>

                    <th>";

                    if(array_sum($sector_outley) > 0) {

                        $table .= number_format(array_sum($sector_exp_revised_outley) / array_sum($sector_outley) * 100 , 2, '.', '');

                    }

                    $table .= "</th>

                </tr>";

            }

            array_push($grand_outley , array_sum($service_outley));

            array_push($grand_revised_outley , array_sum($service_revised_outley));

            array_push($grand_exp_revised_outley , array_sum($service_exp_revised_outley));

            $table .= "<tr>

                <td></td>

                <th> Service Total: ".$value->service_name."</th>

                <th>".number_format(array_sum($service_outley))."</th>

                <th>".number_format(array_sum($service_revised_outley))."</th>

                <th>".number_format(array_sum($service_exp_revised_outley))."</th>

                <th>";

                if(array_sum($service_outley) > 0) {

                    $table .= number_format(array_sum($service_exp_revised_outley) / array_sum($service_outley) * 100 , 2, '.', '');

                }

                $table .= "</th>

            </tr>";

        }

        $table .= "<tr>

            <td></td>

            <th> GRAND TOTAL: </th>

            <th>".number_format(array_sum($grand_outley))."</th>

            <th>".number_format(array_sum($grand_revised_outley))."</th>

            <th>".number_format(array_sum($grand_exp_revised_outley))."</th>

            <th>";

            if(array_sum($grand_outley) > 0) {

                $table .= number_format(array_sum($grand_exp_revised_outley) / array_sum($grand_outley) * 100 , 2, '.', '');

            }

            $table .= "</th>

        </tr>";



        echo $table;

    }



    public function export_scheme_wise_state_db(Request $request)

    {

        $dep_id = $request->dep_id;

        $marjor_id = $request->marjor_id;

        $scheme_id = $request->scheme_id;

        $soe_id = $request->soe_id;

        $service_id = $request->service_id;

        $sector_id = $request->sector_id;

        $plan_id = $request->plan_id;



        $spreadsheet = new Spreadsheet();

        $activeWorksheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->mergeCells("A1:F1");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);

        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        $spreadsheet->getActiveSheet()->getStyle('A1:F999')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(35);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );

        

        if($plan_id == 1)

        {

            $activeWorksheet->setCellValue('A1', 'Department/Scheme wise Budget & Expenditure under Scheduled Castes Development Programme of the year 2022-23 (Rs. In Lakhs)');

        }

        if($plan_id == 2)

        {

            $activeWorksheet->setCellValue('A1', 'Department/Scheme wise Central Development Budget & Expenditure under Scheduled Castes Development Programme of the year 2022-23 (Rs. In Lakhs)');

        }

        $spreadsheet->getActiveSheet()->freezePane('A1');

        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A2', 'MAJ/SM/MIN/SMIN/BUD');

        $activeWorksheet->setCellValue('B2', 'Sector/ Department/ Scheme/SOE');

        $activeWorksheet->setCellValue('C2', 'Outlay for 2022-23 (Rs. in Lakh)');

        if($plan_id == 1)

        {

            $activeWorksheet->setCellValue('D2', 'Revised Outlay');

            $activeWorksheet->setCellValue('E2', 'Exp. 31-03-2023');

        }

        if($plan_id == 2)

        {

            $activeWorksheet->setCellValue('D2', 'Revised Outlay for 2022-23 (Rs. in Lakh)');

            $activeWorksheet->setCellValue('E2', 'Exp upto 31.03.2023');

        }

        $activeWorksheet->setCellValue('F2', '% age');



        $alphabet = range('A', 'Z');

        function integerToRoman($integer)

        {

            $integer = intval($integer);

            $result = '';

            $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);



            foreach($lookup as $roman => $value) {

                $matches = intval($integer/$value);

                $result .= str_repeat($roman,$matches);

                $integer = $integer % $value;

            }

            return $result;

        }



        $grand_outley = [];

        $grand_revised_outley = [];

        $grand_exp_revised_outley = [];

        $i = 2;



        

        if(!$service_id) {

            $service = Service::all();

        } else { 

            $service = Service::where('id', $service_id)->get();

        }



        foreach($service as $key => $value)

        {

            $i++;

            $service_outley = [];

            $service_revised_outley = [];

            $service_exp_revised_outley = [];



            $activeWorksheet->setCellValue('A'.$i+1, $alphabet[$key]);

            $spreadsheet->getActiveSheet()->getStyle('A'.$i+1)->getFont()->setBold( true );

            $activeWorksheet->setCellValue('B'.$i+1, $value->service_name);

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );



            if(!$sector_id) {

                $sector = Sector::where('service_id', $value->id)->get();

            } else { 

                $sector = Sector::where('service_id', $value->id)->where('id', $sector_id)->get();

            }

            foreach($sector as $sector_key => $sector_value)

            {

                $i++;

                $sector_outley = [];

                $sector_revised_outley = [];

                $sector_exp_revised_outley = [];

                $activeWorksheet->setCellValue('A'.$i+1, integerToRoman($sector_key+1));

                $spreadsheet->getActiveSheet()->getStyle('A'.$i+1)->getFont()->setBold( true );

                $activeWorksheet->setCellValue('B'.$i+1, $sector_value->sector_name);

                $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

            

                if(!$dep_id) {

                    $department = Department::where('id', $sector_value->department_id)->get();

                } else { 

                    $department = Department::where('id', $sector_value->department_id)->where('id', $dep_id)->get();

                }

                foreach($department as $department_key => $department_value)

                {

                    $i++;

                    $department_name = $department_key+1 . '. ' . $department_value->department_name;

                    $activeWorksheet->setCellValue('B'.$i+1, $department_name);

                    $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                

                    $dep_outley = [];

                    $revised_outley = [];

                    $exp_revised_outley = [];

                    if(!$marjor_id) {

                        $marjor = Majorhead::where('department_id',$department_value->id)->get();

                    } else { 

                        $marjor = Majorhead::where('department_id',$department_value->id)->where('id', $marjor_id)->get();

                    }



                    foreach($marjor as $headkey => $headvalue)

                    {

                        if(!$scheme_id) {

                            $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->get();

                        } else { 

                            $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->where('id', $scheme_id)->get();

                        }

                        foreach($scheme as $schemekey => $schemevalue)

                        {

                            $outley_soe = [];

                            $revised_outley_soe = [];

                            $exp_revised_outley_soe = [];



                            $i++;

                            $activeWorksheet->setCellValue('A'.$i+1, $headvalue->complete_head);

                            $activeWorksheet->setCellValue('B'.$i+1, $schemevalue->scheme_name);

                        

                            if(!$soe_id) {

                                $soe = Soe_master::where('scheme_id',$schemevalue->id)->get();

                            } else { 

                                $soe = Soe_master::where('scheme_id',$schemevalue->id)->where('id', $soe_id)->get();

                            }

                            foreach($soe as $soekey => $soevalue)

                            {

                                $i++;

                                

                                $soe_outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('soe_id',$soevalue->id)->pluck('outlay')->toArray();

                                $soe_revised_outlay = Soe_budget_distribution::where('soe_id',$soevalue->id)->get();

                                $arr = [];

                                $exp_arr = [];

                                foreach($soe_revised_outlay as $soe_revised_outlay_key => $soe_revised_outlay_value)

                                {

                                    if($soe_revised_outlay_value->q_1_data)

                                    {

                                        $decode1 = json_decode($soe_revised_outlay_value->q_1_data);

                                        $count1 = count($decode1) - 1;

                                        if(empty($request->district_id))

                                        {

                                            if($decode1[$count1]->resvised_outlay)

                                            {

                                                array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                                            }

                                            if($decode1[$count1]->expenditure)

                                            {

                                                array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                                            }

                                        } else {



                                            if($decode1[$count1]->resvised_outlay)

                                            {

                                                foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($arr, $dis_value);

                                                    } else {

                                                        array_push($arr, 0);

                                                    }

                                                }

                                            }



                                            if($decode1[$count1]->expenditure)

                                            {

                                                foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($exp_arr, $dis_value);

                                                    } else {

                                                        array_push($exp_arr, 0);

                                                    }

                                                }

                                            }

                                        }

                                    }

                                    if($soe_revised_outlay_value->q_2_data)

                                    {

                                        $decode2 = json_decode($soe_revised_outlay_value->q_2_data);

                                        $count2 = count($decode2) - 1;

                                        if(empty($rqeuest->district_id)) 

                                        {

                                            if($decode2[$count2]->resvised_outlay)

                                            {

                                                array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                                            }

                                            if($decode2[$count2]->expenditure)

                                            {

                                                array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                                            }

                                        } else {

                                            if($decode2[$count2]->resvised_outlay)

                                            {

                                                foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($arr, $dis_value);

                                                    } else {

                                                        array_push($arr, 0);

                                                    }

                                                }

                                            }



                                            if($decode2[$count2]->expenditure)

                                            {

                                                foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($exp_arr, $dis_value);

                                                    } else {

                                                        array_push($exp_arr, 0);

                                                    }

                                                }

                                            }

                                        }

                                    }

                                    if($soe_revised_outlay_value->q_3_data)

                                    {

                                        $decode3 = json_decode($soe_revised_outlay_value->q_3_data);

                                        $count3 = count($decode3) - 1;

                                        if(empty($request->district_id))

                                        {

                                            if($decode3[$count3]->resvised_outlay)

                                            {

                                                array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                                            }

                                            if($decode3[$count3]->expenditure)

                                            {

                                                array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                                            }

                                        } else {

                                            if($decode3[$count3]->resvised_outlay)

                                            {

                                                foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($arr, $dis_value);

                                                    } else {

                                                        array_push($arr, 0);

                                                    }

                                                }

                                            }



                                            if($decode3[$count3]->expenditure)

                                            {

                                                foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($exp_arr, $dis_value);

                                                    } else {

                                                        array_push($exp_arr, 0);

                                                    }

                                                }

                                            }

                                        }

                                    }

                                    if($soe_revised_outlay_value->q_4_data)

                                    {

                                        $decode4 = json_decode($soe_revised_outlay_value->q_4_data);

                                        $count4 = count($decode4) - 1;

                                        if(empty($request->district_id))

                                        {

                                            if($decode4[$count4]->resvised_outlay)

                                            {

                                                array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                                            }

                                            if($decode4[$count4]->expenditure)

                                            {

                                                array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                                            }

                                        } else {



                                            if($decode4[$count4]->resvised_outlay)

                                            {

                                                foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($arr, $dis_value);

                                                    } else {

                                                        array_push($arr, 0);

                                                    }

                                                }

                                            }



                                            if($decode4[$count4]->expenditure)

                                            {

                                                foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                                    

                                                    if($dis_key == $request->district_id) {

                                                        array_push($exp_arr, $dis_value);

                                                    } else {

                                                        array_push($exp_arr, 0);

                                                    }

                                                }

                                            }

                                        }

                                    }

                                }

                                array_push($outley_soe , array_sum($soe_outlay));

                                array_push($revised_outley_soe , array_sum($arr));

                                array_push($exp_revised_outley_soe , array_sum($exp_arr));



                                $activeWorksheet->setCellValue('B'.$i+1, $soevalue->soe_name);

                                $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($soe_outlay)));

                                $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($arr)));

                                $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_arr)));

                            }

                            array_push($dep_outley , array_sum($outley_soe));

                            array_push($revised_outley , array_sum($revised_outley_soe));

                            array_push($exp_revised_outley , array_sum($exp_revised_outley_soe));



                            $i++;

                            $activeWorksheet->setCellValue('B'.$i+1, 'Scheme Total: '.$schemevalue->scheme_name);

                            $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($outley_soe)));

                            $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($revised_outley_soe)));

                            $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_revised_outley_soe)));

                            if(array_sum($outley_soe) > 0)

                            {

                                if($plan_id == 1)

                                {

                                    $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_revised_outley_soe) / array_sum($outley_soe) * 100 ));

                                }

                            }

                            if(array_sum($revised_outley_soe) > 0)

                            {

                                if($plan_id == 2)

                                {

                                    $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_revised_outley_soe) / array_sum($revised_outley_soe) * 100 ));

                                }

                            }

                            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                            $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

                            $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

                            $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

                            $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

                        }

                    }

                    array_push($sector_outley , array_sum($dep_outley));

                    array_push($sector_revised_outley , array_sum($revised_outley));

                    array_push($sector_exp_revised_outley , array_sum($exp_revised_outley));

                    

                    $i++;

                    $activeWorksheet->setCellValue('B'.$i+1, 'Department Total: '.$department_value->department_name);

                    $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($dep_outley)));

                    $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($revised_outley)));

                    $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_revised_outley)));

                    if(array_sum($dep_outley) > 0)

                    {

                        if($plan_id == 1)

                        {

                            $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_revised_outley) / array_sum($dep_outley) * 100 ));

                        }

                    }

                    if(array_sum($revised_outley) > 0)

                    {

                        if($plan_id == 2)

                        {

                            $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_revised_outley) / array_sum($revised_outley) * 100 ));

                        }

                    }

                    $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

                }

                array_push($service_outley , array_sum($sector_outley));

                array_push($service_revised_outley , array_sum($sector_revised_outley));

                array_push($service_exp_revised_outley , array_sum($sector_exp_revised_outley));

                    

                $i++;

                $activeWorksheet->setCellValue('B'.$i+1, 'Sector Total: '.$sector_value->sector_name);

                $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($sector_outley)));

                $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($sector_revised_outley)));

                $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($sector_exp_revised_outley)));

                if(array_sum($sector_outley) > 0)

                {

                    if($plan_id == 1)

                    {

                        $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($sector_exp_revised_outley) / array_sum($sector_outley) * 100 ));

                    }

                }

                if(array_sum($sector_revised_outley) > 0)

                {

                    if($plan_id == 2)

                    {

                        $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($sector_exp_revised_outley) / array_sum($sector_revised_outley) * 100 ));

                    }

                }

                $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

                $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

                $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

                $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

            }

            array_push($grand_outley , array_sum($service_outley));

            array_push($grand_revised_outley , array_sum($service_revised_outley));

            array_push($grand_exp_revised_outley , array_sum($service_exp_revised_outley));

            $i++;

            $activeWorksheet->setCellValue('B'.$i+1, 'Service Total: '.$value->service_name);

            $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($service_outley)));

            $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($service_revised_outley)));

            $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($service_exp_revised_outley)));

            if(array_sum($service_outley) > 0)

            {

                if($plan_id == 1)

                {

                    $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($service_exp_revised_outley) / array_sum($service_outley) * 100 ));

                }

            }

            if(array_sum($service_revised_outley) > 0)

            {

                if($plan_id == 2)

                {

                    $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($service_exp_revised_outley) / array_sum($service_revised_outley) * 100 ));

                }

            }

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );

        }

        $i++;

        $activeWorksheet->setCellValue('B'.$i+1, 'GRAND TOTAL: '.$value->service_name);

        $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($grand_outley)));

        $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($grand_revised_outley)));

        $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($grand_exp_revised_outley)));

        if(array_sum($grand_outley) > 0)

        {

            if($plan_id == 1)

            {

                $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($grand_exp_revised_outley) / array_sum($grand_outley) * 100 ));

            }

        }

        if(array_sum($grand_revised_outley) > 0)

        {

            if($plan_id == 2)

            {

                $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($grand_exp_revised_outley) / array_sum($grand_revised_outley) * 100 ));

            }

        }

        $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );



        $writer = new Xlsx($spreadsheet);

        if($plan_id == 1)

        {

            $filename = 'Scheme_wise_SDB(State_Development_Budget)_'.time().'.xlsx';

        }

        if($plan_id == 2)

        {

            $filename = 'Scheme_wise_CDB(Central_Development_Budget)_'.time().'.xlsx';

        }

        

        // $writer->save(public_path('Exports/'.$filename));

        // $filepath = public_path('Exports/'.$filename);

        // return Response::download($filepath);



        // $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        return $writer->save('php://output');

    }

    



    // -------------------------------- Department Wise CDB-------------------------------------------

    public function department_wise_central_db()

    {

        $plan = Plan::where('plan_name', 'CDB')->first();

        $plan_id = $plan->id;

        $districtList = District::all();

        

        if(auth()->user()->role_id == 1)

        {

            $department = Department::all();

            return view('reports.department-wise-central-db', compact('department','plan_id','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.department-wise-central-db', compact('department','plan_id','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }

    



    // -------------------------------- Scheme Wise CDB-------------------------------------------

    public function scheme_wise_central_db()

    {

        $plan = Plan::where('plan_name', 'CDB')->first();

        $plan_id = $plan->id;

        $service = Service::all();

        $districtList = District::all();



        if(auth()->user()->role_id == 1)

        {

            $department = Department::all();

            return view('reports.scheme-wise-central-db', compact('department','plan_id','service','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.scheme-wise-central-db', compact('department','plan_id','service','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }

    



    // -------------------------------- Department Wise NDB-------------------------------------------

    public function department_wise_non_db()

    {

        $plan = Plan::where('plan_name', 'NDB')->first();

        $plan_id = $plan->id;

        $districtList = District::all();



        if(auth()->user()->role_id == 1)

        {

            $department = Department::all();

            return view('reports.department-wise-non-db', compact('department','plan_id','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.department-wise-non-db', compact('department','plan_id','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }



    public function get_department_wise_non_db_data(Request $request)

    {

        $id = $request->dep_id;

        $plan_id = $request->plan_id;

        

        if($request->dep_id == '0') {

            $department = Department::all();

        } else {

            $department = Department::where('id', $id)->get();

        }



        $table = "";

        $grand = [];

        $outley_grand = [];

        $exp_outley_grand = [];

        $revised_grand = [];

        foreach($department as $key => $value)

        {

            

            $total_outley_dep = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('outlay')->toArray();



            $outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('soe_id')->toArray();



            $revise_outlay_total = Soe_budget_distribution::whereIn('soe_id',$outlay)->get();

            $arr_add = [];

            $exp_arr_add = [];

            foreach($revise_outlay_total as $diskey => $disvalue)

            {

                $arr = [];

                $exp_arr = [];

                if($disvalue->q_1_data)

                {



                    $decode1 = json_decode($disvalue->q_1_data);

                    $count1 = count($decode1) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode1[$count1]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                        }

                        if($decode1[$count1]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                        }

                    } else {



                        if($decode1[$count1]->resvised_outlay)

                        {

                            foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode1[$count1]->expenditure)

                        {

                            foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_2_data)

                {

                    $decode2 = json_decode($disvalue->q_2_data);

                    $count2 = count($decode2) - 1;

                    if(empty($rqeuest->district_id)) 

                    {

                        if($decode2[$count2]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                        }

                        if($decode2[$count2]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                        }

                    } else {

                        if($decode2[$count2]->resvised_outlay)

                        {

                            foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode2[$count2]->expenditure)

                        {

                            foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_3_data)

                {

                    $decode3 = json_decode($disvalue->q_3_data);

                    $count3 = count($decode3) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode3[$count3]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                        }

                        if($decode3[$count3]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                        }

                    } else {

                        if($decode3[$count3]->resvised_outlay)

                        {

                            foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode3[$count3]->expenditure)

                        {

                            foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_4_data)

                {

                    $decode4 = json_decode($disvalue->q_4_data);

                    $count4 = count($decode4) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode4[$count4]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                        }

                        if($decode4[$count4]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                        }

                    } else {



                        if($decode4[$count4]->resvised_outlay)

                        {

                            foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode4[$count4]->expenditure)

                        {

                            foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }



                array_push($arr_add, array_sum($arr));

                array_push($exp_arr_add, array_sum($exp_arr));

            }

            array_push($outley_grand, array_sum($total_outley_dep)); 

            array_push($revised_grand, array_sum($arr_add)); 

            array_push($exp_outley_grand, array_sum($exp_arr_add));

            $table .= "<tr>

                <td>".$key + 1 ."</td>

                <th>".$value->department_name ."</th>

                <td>".number_format(array_sum($total_outley_dep))."</td>

                <td>".number_format(array_sum($arr_add))."</td>

                <td>".number_format(array_sum($exp_arr_add))."</td>

                <td>";

                if(array_sum($total_outley_dep) > 0) {

                    $table .= number_format(array_sum($exp_arr_add) / array_sum($total_outley_dep) * 100 , 2, '.', '');

                }

                $table .= "</td>

            </tr>";

        }

        $table .= "<tr>

            <th></th>

            <th>GRAND TOTAL</th>

            <th>".number_format(array_sum($outley_grand))."</th>

            <th>".number_format(array_sum($revised_grand))."</th>

            <th>".number_format(array_sum($exp_outley_grand))."</th>

            <th>";

            if(array_sum($outley_grand) > 0) {

                $table .= number_format(array_sum($exp_outley_grand) / array_sum($outley_grand) * 100 , 2, '.', '');

            }

            $table .= "</th>

        </tr>";



        echo $table; 

    }



    public function export_department_wise_non_db(Request $request)

    {



        // print_r($request->all()); die();

        // return Excel::download(new Export_scheme_wise_ndb($request->department), 'Scheme wise NDB(Non Development Budget).xlsx');



        $spreadsheet = new Spreadsheet();

        $activeWorksheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->mergeCells("A1:F1");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        $spreadsheet->getActiveSheet()->getStyle('A1:F999')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(35);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A1', 'Department wise Non Development Budget & Expenditure under Scheduled Caste Development Programme of the year 2022-23');

        $spreadsheet->getActiveSheet()->freezePane('A1');

        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A2', 'Sr.No.');

        $activeWorksheet->setCellValue('B2', 'Name of Department');

        $activeWorksheet->setCellValue('C2', 'Outlay for 2022-23');

        $activeWorksheet->setCellValue('D2', 'Revised Budget');

        $activeWorksheet->setCellValue('E2', 'Exp. Upto 31-03-2023');

        $activeWorksheet->setCellValue('F2', '% age');



        if(auth()->user()->role_id == 1)

        {

            if(!$request->department)

            {

                $department = Department::all();

            } else {

                $department = Department::where('id', $request->department)->latest()->get();

            }

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', $request->department)->latest()->get();

        }

        else

        {

            return redirect('dashboard');

        }

        

        $plan = Plan::where('plan_name', 'NDB')->first();

        $plan_id = $plan->id;

        

        $i = 2;

        $grand = [];

        $outley_grand = [];

        $exp_outley_grand = [];

        $revised_grand = [];



        foreach($department as $key => $value)

        {

            $i++;

            $total_outley_dep = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('outlay')->toArray();



            $outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('soe_id')->toArray();



            $revise_outlay_total = Soe_budget_distribution::whereIn('soe_id',$outlay)->get();

            $arr_add = [];

            $exp_arr_add = [];

            foreach($revise_outlay_total as $diskey => $disvalue)

            {

                $arr = [];

                $exp_arr = [];

                if($disvalue->q_1_data)

                {



                    $decode1 = json_decode($disvalue->q_1_data);

                    $count1 = count($decode1) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode1[$count1]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                        }

                        if($decode1[$count1]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                        }

                    } else {



                        if($decode1[$count1]->resvised_outlay)

                        {

                            foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode1[$count1]->expenditure)

                        {

                            foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_2_data)

                {

                    $decode2 = json_decode($disvalue->q_2_data);

                    $count2 = count($decode2) - 1;

                    if(empty($rqeuest->district_id)) 

                    {

                        if($decode2[$count2]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                        }

                        if($decode2[$count2]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                        }

                    } else {

                        if($decode2[$count2]->resvised_outlay)

                        {

                            foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode2[$count2]->expenditure)

                        {

                            foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_3_data)

                {

                    $decode3 = json_decode($disvalue->q_3_data);

                    $count3 = count($decode3) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode3[$count3]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                        }

                        if($decode3[$count3]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                        }

                    } else {

                        if($decode3[$count3]->resvised_outlay)

                        {

                            foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode3[$count3]->expenditure)

                        {

                            foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }

                if($disvalue->q_4_data)

                {

                    $decode4 = json_decode($disvalue->q_4_data);

                    $count4 = count($decode4) - 1;

                    if(empty($request->district_id))

                    {

                        if($decode4[$count4]->resvised_outlay)

                        {

                            array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                        }

                        if($decode4[$count4]->expenditure)

                        {

                            array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                        }

                    } else {



                        if($decode4[$count4]->resvised_outlay)

                        {

                            foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($arr, $dis_value);

                                } else {

                                    array_push($arr, 0);

                                }

                            }

                        }



                        if($decode4[$count4]->expenditure)

                        {

                            foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                

                                if($dis_key == $request->district_id) {

                                    array_push($exp_arr, $dis_value);

                                } else {

                                    array_push($exp_arr, 0);

                                }

                            }

                        }

                    }

                }



                array_push($arr_add, array_sum($arr));

                array_push($exp_arr_add, array_sum($exp_arr));

            }

            array_push($outley_grand, array_sum($total_outley_dep)); 

            array_push($revised_grand, array_sum($arr_add)); 

            array_push($exp_outley_grand, array_sum($exp_arr_add));



            $activeWorksheet->setCellValue('A'.$i+1, $key + 1);

            $activeWorksheet->setCellValue('B'.$i+1, $value->department_name);

            $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($total_outley_dep)));

            $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($arr_add)));

            $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_arr_add)));

            $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_arr_add)));

            if(array_sum($total_outley_dep) > 0) {

                $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_arr_add) / array_sum($total_outley_dep) * 100 , 2, '.', ''));

            }

        }

        $i++;

        $activeWorksheet->setCellValue('B'.$i+1, "GRAND TOTAL");

        $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($outley_grand)));

        $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($revised_grand)));

        $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_outley_grand)));

        if(array_sum($outley_grand) > 0) {

            $activeWorksheet->setCellValue('F'.$i+1, number_format(array_sum($exp_outley_grand) / array_sum($outley_grand) * 100 , 2, '.', ''));

        }

        $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('F'.$i+1)->getFont()->setBold( true );



        $writer = new Xlsx($spreadsheet);

        $filename = 'Department_wise_NDB(Non_Development_Budget)_'.time().'.xlsx';

        // $writer->save(public_path('Exports/'.$filename));

        // $filepath = public_path('Exports/'.$filename);

        // return Response::download($filepath);



        // $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        return $writer->save('php://output');

    }





    // -------------------------------- Scheme Wise NDB-------------------------------------------

    public function scheme_wise_non_db()

    {

        $plan = Plan::where('plan_name', 'NDB')->first();

        $plan_id = $plan->id;

        $districtList = District::all();



        if(auth()->user()->role_id == 1)

        {

            // $department_id = Soe_budget_allocation::where('plan_id',$plan_id)->pluck('department_id')->toArray();

            // $department = Department::whereIn('id',$department_id)->latest()->get();

            $department = Department::all();

            return view('reports.scheme-wise-non-db', compact('department','plan_id','districtList'));

        }

        elseif(auth()->user()->role_id == 2)

        {

            // $department_id = Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id', auth()->user()->department_id)->pluck('department_id')->toArray();

            // $department = Department::whereIn('id', $department_id)->latest()->get();

            $department = Department::where('id', auth()->user()->department_id)->get();

            return view('reports.scheme-wise-non-db', compact('department','plan_id','districtList'));

        }

        else

        {

            return redirect('dashboard');

        }

    }



    public function get_scheme_wise_non_db_data(Request $request)

    {

        $dep_id = $request->dep_id;

        $marjor_id = $request->marjor_id;

        $scheme_id = $request->scheme_id;

        $soe_id = $request->soe_id;

        $service_id = $request->service_id;

        $sector_id = $request->sector_id;

        $plan_id = $request->plan_id;



        if($request->qut_id == '1')

        {

            $start = date('Y-04-01 00:00:00');

            $end = date('Y-06-30 23:59:59');   

        } elseif ($request->qut_id == '2') {

            $start = date('Y-07-01 00:00:00');

            $end = date('Y-09-30 23:59:59');

        } elseif ($request->qut_id == '3') {

            $start = date('Y-10-01 00:00:00');

            $end = date('Y-12-31 23:59:59');

        } elseif ($request->qut_id == '4') {

            $start = date('Y-01-01 00:00:00');

            $end = date('Y-03-31 23:59:59');

        } else {

            $start = date('1970-01-01 00:00:00');

            $end = date('2070-12-31 23:59:59');

        }

        

        if(!$dep_id) 

        {

            // $department_id = Soe_budget_allocation::where('plan_id',$plan_id)->orderBy('department_id')->pluck('department_id')->toArray();

            // $department = Department::whereIn('id',$department_id)->latest()->get();

            $department = Department::all();

        } else {

            $department = Department::where('id', $dep_id)->latest()->get();

        }



        $table = "";

        $grand_dep_outley = [];

        $grand_revised_outley = [];

        $grand_exp_revised_outley = [];

        foreach($department as $key => $value)

        {

            $dep_outley = [];

            $revised_outley = [];

            $exp_revised_outley = [];

            $table .= "<tr>

                <td></td>

                <th>". $key + 1 .". " .$value->department_name ."</th>

                <td></td>

                <td></td>

                <td></td>

            </tr>";



            if(!$marjor_id) {

                $marjor = Majorhead::where('department_id',$value->id)->get();

            } else { 

                $marjor = Majorhead::where('department_id',$value->id)->where('id', $marjor_id)->get();

            }



            foreach($marjor as $headkey => $headvalue)

            {

                if(!$scheme_id) {

                    $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->get();

                } else { 

                    $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->where('id', $scheme_id)->get();

                }



                foreach($scheme as $schemekey => $schemevalue)

                {

                    $outley_soe = [];

                    $revised_outley_soe = [];

                    $exp_revised_outley_soe = [];

                    $table .= "<tr>

                        <td>".$headvalue->complete_head."</td>

                        <td>".$schemevalue->scheme_name."</td>

                        <td></td>

                        <td></td>

                        <td></td>

                    </tr>";



                    if(!$soe_id) {

                        $soe = Soe_master::where('scheme_id',$schemevalue->id)->get();

                    } else { 

                        $soe = Soe_master::where('scheme_id',$schemevalue->id)->where('id', $soe_id)->get();

                    }



                    foreach($soe as $soekey => $soevalue)

                    {

                        $soe_outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('soe_id',$soevalue->id)->pluck('outlay')->toArray();

                        $soe_revised_outlay = Soe_budget_distribution::where('soe_id',$soevalue->id)->get();

                        $arr = [];

                        $exp_arr = [];

                        foreach($soe_revised_outlay as $soe_revised_outlay_key => $soe_revised_outlay_value)

                        {



                            if($soe_revised_outlay_value->q_1_data)

                            {



                                $decode1 = json_decode($soe_revised_outlay_value->q_1_data);

                                $count1 = count($decode1) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode1[$count1]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                                    }

                                    if($decode1[$count1]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                                    }

                                } else {



                                    if($decode1[$count1]->resvised_outlay)

                                    {

                                        foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode1[$count1]->expenditure)

                                    {

                                        foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_2_data)

                            {

                                $decode2 = json_decode($soe_revised_outlay_value->q_2_data);

                                $count2 = count($decode2) - 1;

                                if(empty($rqeuest->district_id)) 

                                {

                                    if($decode2[$count2]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                                    }

                                    if($decode2[$count2]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                                    }

                                } else {

                                    if($decode2[$count2]->resvised_outlay)

                                    {

                                        foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode2[$count2]->expenditure)

                                    {

                                        foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_3_data)

                            {

                                $decode3 = json_decode($soe_revised_outlay_value->q_3_data);

                                $count3 = count($decode3) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode3[$count3]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                                    }

                                    if($decode3[$count3]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                                    }

                                } else {

                                    if($decode3[$count3]->resvised_outlay)

                                    {

                                        foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode3[$count3]->expenditure)

                                    {

                                        foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_4_data)

                            {

                                $decode4 = json_decode($soe_revised_outlay_value->q_4_data);

                                $count4 = count($decode4) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode4[$count4]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                                    }

                                    if($decode4[$count4]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                                    }

                                } else {



                                    if($decode4[$count4]->resvised_outlay)

                                    {

                                        foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode4[$count4]->expenditure)

                                    {

                                        foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                        }

                        array_push($outley_soe , array_sum($soe_outlay));

                        array_push($revised_outley_soe , array_sum($arr));

                        array_push($exp_revised_outley_soe , array_sum($exp_arr));

                        $table .= "<tr>

                            <td></td>

                            <td>".$soevalue->soe_name."</td>

                            <td>".number_format(array_sum($soe_outlay))."</td>

                            <td>".number_format(array_sum($arr))."</td>

                            <td>".number_format(array_sum($exp_arr))."</td>

                        </tr>";

                    }

                    array_push($dep_outley , array_sum($outley_soe));

                    array_push($revised_outley , array_sum($revised_outley_soe));

                    array_push($exp_revised_outley , array_sum($exp_revised_outley_soe));

                    $table .= "<tr>

                        <td></td>

                        <th> Total: ". $schemevalue->scheme_name ."</th>

                        <th>".number_format(array_sum($outley_soe)) ."</th>

                        <th>".number_format(array_sum($revised_outley_soe))."</th>

                        <th>".number_format(array_sum($exp_revised_outley_soe))."</th>

                    </tr>";

                }

            }

            array_push($grand_dep_outley , array_sum($dep_outley));

            array_push($grand_revised_outley , array_sum($revised_outley));

            array_push($grand_exp_revised_outley , array_sum($exp_revised_outley));

            $table .= "<tr>

                <th></th>

                <th> <b>".$value->department_name." TOTAL: </b> </th>

                <th> <b>".number_format(array_sum($dep_outley))."</b> </th>

                <th> <b>".number_format(array_sum($revised_outley))."</b> </th>

                <th> <b>".number_format(array_sum($exp_revised_outley))."</b> </th>

            </tr>";

        }

        $table .= "<tr>

            <th></th>

            <th>GRAND TOTAL</th>

            <th> <b>".number_format(array_sum($grand_dep_outley))."</b> </th>

            <th> <b>".number_format(array_sum($grand_revised_outley))."</b> </th>

            <th> <b>".number_format(array_sum($grand_exp_revised_outley))."</b> </th>

        </tr>";



        echo $table;

    }



    public function export_scheme_wise_non_db(Request $request)

    {

        // print_r($request->all()); die();

        // return Excel::download(new Export_scheme_wise_ndb($request->department), 'Scheme wise NDB(Non Development Budget).xlsx');



        $dep_id = $request->department;

        $marjor_id = $request->majorhead_id;

        $scheme_id = $request->scheme_id;

        $soe_id = $request->soe_id;

        $plan_id = $request->plan_id;



        $spreadsheet = new Spreadsheet();

        $activeWorksheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->mergeCells("A1:E1");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);

        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        $spreadsheet->getActiveSheet()->getStyle('A1:E999')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(35);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A1', 'Department/Scheme wise  Non Development Budget & Expenditure  under Scheduled Castes Development Programme of the year 2022-23 (Rs. In Lakhs)');

        $spreadsheet->getActiveSheet()->freezePane('A1');

        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold( true );

        $activeWorksheet->setCellValue('A2', 'MAJ/SM/MIN/SMIN/BUD');

        $activeWorksheet->setCellValue('B2', 'Sector/ Department/ Scheme/SOE');

        $activeWorksheet->setCellValue('C2', 'Outlay for 2022-23');

        $activeWorksheet->setCellValue('D2', 'Revised Outlay (Rs. in Lakh)');

        $activeWorksheet->setCellValue('E2', 'Expenditure 31-03-2023');     



        if(auth()->user()->role_id == 1)

        {

            if(!$dep_id)

            {

                $department = Department::all();

            } else {

                $department = Department::where('id', $dep_id)->latest()->get();

            }

        }

        elseif(auth()->user()->role_id == 2)

        {

            $department = Department::where('id', $dep_id)->latest()->get();

        }

        else

        {

            return redirect('dashboard');

        }



        $i = 2;

        $grand_dep_outley = [];

        $grand_revised_outley = [];

        $grand_exp_revised_outley = [];



        foreach($department as $key => $value)

        {

            $i++;

            $dep_outley = [];

            $revised_outley = [];

            $exp_revised_outley = [];

            $dep_name = "" . $key+1 . ". " . $value->department_name;

            $activeWorksheet->setCellValue('B'.$i+1, $dep_name);

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );



            if(!$marjor_id) {

                $marjor = Majorhead::where('department_id',$value->id)->get();

            } else { 

                $marjor = Majorhead::where('department_id',$value->id)->where('id', $marjor_id)->get();

            }



            foreach($marjor as $headkey => $headvalue)

            {

                if(!$scheme_id) {

                    $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->get();

                } else { 

                    $scheme = Scheme_master::where('majorhead_id',$headvalue->id)->where('id', $scheme_id)->get();

                }

                foreach($scheme as $schemekey => $schemevalue)

                {

                    $i++;

                    $outley_soe = [];

                    $revised_outley_soe = [];

                    $exp_revised_outley_soe = [];

                    $activeWorksheet->setCellValue('A'.$i+1, $headvalue->complete_head);

                    $activeWorksheet->setCellValue('B'.$i+1, $schemevalue->scheme_name);

                    

                    if(!$soe_id) {

                        $soe = Soe_master::where('scheme_id',$schemevalue->id)->get();

                    } else { 

                        $soe = Soe_master::where('scheme_id',$schemevalue->id)->where('id', $soe_id)->get();

                    }

                    foreach($soe as $soekey => $soevalue)

                    {

                        $i++;

                        $soe_outlay = Soe_budget_allocation::where('plan_id',$plan_id)->where('soe_id',$soevalue->id)->pluck('outlay')->toArray();

                        $soe_revised_outlay = Soe_budget_distribution::where('soe_id',$soevalue->id)->get();

                        $arr = [];

                        $exp_arr = [];

                        foreach($soe_revised_outlay as $soe_revised_outlay_key => $soe_revised_outlay_value)

                        {

                            if($soe_revised_outlay_value->q_1_data)

                            {



                                $decode1 = json_decode($soe_revised_outlay_value->q_1_data);

                                $count1 = count($decode1) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode1[$count1]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));

                                    }

                                    if($decode1[$count1]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));

                                    }

                                } else {



                                    if($decode1[$count1]->resvised_outlay)

                                    {

                                        foreach ($decode1[$count1]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode1[$count1]->expenditure)

                                    {

                                        foreach ($decode1[$count1]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_2_data)

                            {

                                $decode2 = json_decode($soe_revised_outlay_value->q_2_data);

                                $count2 = count($decode2) - 1;

                                if(empty($rqeuest->district_id)) 

                                {

                                    if($decode2[$count2]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));

                                    }

                                    if($decode2[$count2]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));

                                    }

                                } else {

                                    if($decode2[$count2]->resvised_outlay)

                                    {

                                        foreach ($decode2[$count2]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode2[$count2]->expenditure)

                                    {

                                        foreach ($decode2[$count2]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_3_data)

                            {

                                $decode3 = json_decode($soe_revised_outlay_value->q_3_data);

                                $count3 = count($decode3) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode3[$count3]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));

                                    }

                                    if($decode3[$count3]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));

                                    }

                                } else {

                                    if($decode3[$count3]->resvised_outlay)

                                    {

                                        foreach ($decode3[$count3]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode3[$count3]->expenditure)

                                    {

                                        foreach ($decode3[$count3]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                            if($soe_revised_outlay_value->q_4_data)

                            {

                                $decode4 = json_decode($soe_revised_outlay_value->q_4_data);

                                $count4 = count($decode4) - 1;

                                if(empty($request->district_id))

                                {

                                    if($decode4[$count4]->resvised_outlay)

                                    {

                                        array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));

                                    }

                                    if($decode4[$count4]->expenditure)

                                    {

                                        array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));

                                    }

                                } else {



                                    if($decode4[$count4]->resvised_outlay)

                                    {

                                        foreach ($decode4[$count4]->resvised_outlay as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($arr, $dis_value);

                                            } else {

                                                array_push($arr, 0);

                                            }

                                        }

                                    }



                                    if($decode4[$count4]->expenditure)

                                    {

                                        foreach ($decode4[$count4]->expenditure as $dis_key => $dis_value) {

                                            

                                            if($dis_key == $request->district_id) {

                                                array_push($exp_arr, $dis_value);

                                            } else {

                                                array_push($exp_arr, 0);

                                            }

                                        }

                                    }

                                }

                            }

                        }

                        array_push($outley_soe , array_sum($soe_outlay));

                        array_push($revised_outley_soe , array_sum($arr));

                        array_push($exp_revised_outley_soe , array_sum($exp_arr));



                        $activeWorksheet->setCellValue('B'.$i+1, $soevalue->soe_name);

                        $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($soe_outlay)));

                        $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($arr)));

                        $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_arr)));

                    }

                    array_push($dep_outley , array_sum($outley_soe));

                    array_push($revised_outley , array_sum($revised_outley_soe));

                    array_push($exp_revised_outley , array_sum($exp_revised_outley_soe));



                    $i++;

                    $activeWorksheet->setCellValue('B'.$i+1, "Total: ". $schemevalue->scheme_name);

                    $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($outley_soe)));

                    $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($revised_outley_soe)));

                    $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_revised_outley_soe)));

                    $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

                    $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

                }

            }

            array_push($grand_dep_outley , array_sum($dep_outley));

            array_push($grand_revised_outley , array_sum($revised_outley));

            array_push($grand_exp_revised_outley , array_sum($exp_revised_outley));



            $i++;

            $activeWorksheet->setCellValue('B'.$i+1, $value->department_name." TOTAL:");

            $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($dep_outley)));

            $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($revised_outley)));

            $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($exp_revised_outley)));

            $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

            $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );

        }

        $i++;

        $activeWorksheet->setCellValue('B'.$i+1, "GRAND TOTAL");

        $activeWorksheet->setCellValue('C'.$i+1, number_format(array_sum($grand_dep_outley)));

        $activeWorksheet->setCellValue('D'.$i+1, number_format(array_sum($grand_revised_outley)));

        $activeWorksheet->setCellValue('E'.$i+1, number_format(array_sum($grand_exp_revised_outley)));

        $spreadsheet->getActiveSheet()->getStyle('B'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('C'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('D'.$i+1)->getFont()->setBold( true );

        $spreadsheet->getActiveSheet()->getStyle('E'.$i+1)->getFont()->setBold( true );



        $writer = new Xlsx($spreadsheet);

        $filename = 'Scheme_wise_NDB(Non_Development_Budget)_'.time().'.xlsx';

        // $writer->save(public_path('Exports/'.$filename));

        // $filepath = public_path('Exports/'.$filename);

        // return Response::download($filepath);



        // $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        return $writer->save('php://output');



    }



}