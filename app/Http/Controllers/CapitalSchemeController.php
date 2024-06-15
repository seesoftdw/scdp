<?php

namespace App\Http\Controllers;
use App\Models\District;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\Finyear;
use App\Models\Soe_budget_allocation;
use App\Models\Majorhead;
use Session;
use Illuminate\Http\Request;

class CapitalSchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $capitalData = Soe_budget_allocation::select("soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "capital")->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))
                ->get();//paginate(15);

        if(count($capitalData) > 0){
            return view('capital-scheme.view-capital-scheme', compact('capitalData'));
        }
        else {
            return view('capital-scheme.view-capital-scheme');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function all_capital_list()
    {
        $departmentlist = Department::all();
        $finyearlist = Finyear::all();

        return response()->json(['departmentlist' => $departmentlist, 'finyearlist' => $finyearlist]);
    }


    public function search(Request $request)
    {
        $capitalSchemeList = Soe_budget_allocation::all();
        if ($request->department_id) {
            $capitalSchemeList = $capitalSchemeList->where('department_id', $request->department_id);
        }
        if ($request->fin_year_id) {
            $capitalSchemeList = $capitalSchemeList->where('fin_year_id', $request->fin_year_id);
        }
        
        if (count($capitalSchemeList) > 0) {
            
            for ($i=$capitalSchemeList->keys()->first(); $i < $capitalSchemeList->keys()->last(); $i++) {
                if(isset($capitalSchemeList[$i])){
                    $list = Soe_budget_allocation::where('department_id', $capitalSchemeList[$i]['department_id'])
                    ->where('fin_year_id', $capitalSchemeList[$i]['fin_year_id'])
                    ->groupBy('scheme_id')
                    ->selectRaw('sum(outlay) as total_outlay, scheme_id')
                    ->get();
                    if(count($list) > 1){
                        for ($j=0; $j < count($list) ; $j++) {
                            if($capitalSchemeList[$i]['scheme_id']==$list[$j]['scheme_id']) {
                                $capitalSchemeList[$i]['total_outlay']= $list[$j]['total_outlay'];
                            }
                        }
                    }else{
                        $capitalSchemeList[$i]['total_outlay']= $list[0]['total_outlay'];
                    }
                }
            }
            return view('capital-scheme.view-capital-scheme-master', compact('capitalSchemeList'));
        }
        else {
            return view('capital-scheme.view-capital-scheme-master');
        }
        
    }
}
