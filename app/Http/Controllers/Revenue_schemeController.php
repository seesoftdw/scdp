<?php

namespace App\Http\Controllers;
use App\Models\Soe_budget_allocation;
use App\Models\Soe_budget_distribution;
use App\Models\Sector;
use App\Models\Subsector;
use App\Models\Department;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\District;
use App\Models\Finyear;
use Session;
use Illuminate\Http\Request;

class Revenue_schemeController extends Controller
{
    public function index()
    {


        $revenueData = Soe_budget_allocation::select("soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "revenue")->where("soe_budget_allocation.fin_year_id","=",Session::get('finyear'))
                ->get();//paginate(15);

        if(count($revenueData) > 0){
            return view('revenue-scheme.view-revenue-scheme', compact('revenueData'));
        }
        else {
            return view('revenue-scheme.view-revenue-scheme');
        }
    }

    public function all_revenue_list()
    {
        $sectorlist = Sector::all();
        $departmentlist = Department::all();
        $schememasterlist = Scheme_master::all();
        $soemasterlist = Soe_master::all();
        $finyearlist = Finyear::all();

        return response()->json(['sectorlist' => $sectorlist, 
                                'departmentlist' => $departmentlist, 
                                'schememasterlist' => $schememasterlist, 
                                'soemasterlist' => $soemasterlist,
                                'finyearlist' => $finyearlist]);
    }

    public function get_revenue_sub_sector(Request $request)
    {
        $subsectorhtml='';
        if (!$request->sector_id) {
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';
        }
        else {
            $html = '';
            $subsectorlist = Subsector::where('sector_id', $request->sector_id)->get();
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';
            foreach ($subsectorlist as $subsector) {
                $subsectorhtml .= '<option value="'.$subsector->id.'">'.$subsector->subsectors_name.'</option>';
            }
        }
        return response()->json(['subsectorhtml' => $subsectorhtml ]);
    }

    public function search(Request $request)
    {
        $revenueschemelist = Soe_budget_allocation::all();
        if ($request->sector_id) {
            $revenueschemelist = $revenueschemelist->where('sector_id', $request->sector_id);
        }
        if ($request->subsector_id) {
            $revenueschemelist = $revenueschemelist->where('subsector_id', $request->subsector_id);
        }
        if ($request->department_id) {
            $revenueschemelist = $revenueschemelist->where('department_id', $request->department_id);
        }
        if ($request->fin_year_id) {
            $revenueschemelist = $revenueschemelist->where('fin_year_id', $request->fin_year_id);
        }
        if ($request->scheme_id) {
            $revenueschemelist = $revenueschemelist->where('scheme_id', $request->scheme_id);
        }
        if ($request->soe_id) {
            $revenueschemelist = $revenueschemelist->where('soe_id', $request->soe_id);
        }
        
        if (count($revenueschemelist) > 0) {
            for ($i=0; $i <= $revenueschemelist->keys()->last() ; $i++) {
                $sum = 0;
                if(isset($revenueschemelist[$i])){
                    $list = Soe_budget_distribution::where('sector_id', $revenueschemelist[$i]['sector_id'])
                    ->where('subsector_id', $revenueschemelist[$i]['subsector_id'])
                    ->where('department_id', $revenueschemelist[$i]['department_id'])
                    ->where('scheme_id', $revenueschemelist[$i]['scheme_id'])
                    ->where('soe_id', $revenueschemelist[$i]['soe_id'])
                    ->where('fin_year_id', $revenueschemelist[$i]['fin_year_id'])
                    // TODO: group by soe id and sum outlay
                    ->get();
                    
                    if(count($list)> 0){
                        for ($j=0; $j < count($list) ; $j++) {
                            $sum = $sum + (number_format($list[$j]['outlay'],2));
                        }
                        $revenueschemelist[$i]['distributed_outlay']= $sum;
                        $revenueschemelist[$i]['undistributed_outlay']= $revenueschemelist[$i]['outlay'] - $sum;
                    }else{
                        $revenueschemelist[$i]['distributed_outlay']= 0.00;
                        $revenueschemelist[$i]['undistributed_outlay']= $revenueschemelist[$i]['outlay'];                
                    }
                }
                
            }
            return view('revenue-scheme.view-revenue-scheme', compact('revenueschemelist'));
        }
        else {
            return view('revenue-scheme.view-revenue-scheme');
        }
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
