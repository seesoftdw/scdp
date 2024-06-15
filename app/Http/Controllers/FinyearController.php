<?php

namespace App\Http\Controllers;
use App\Models\Finyear;
use App\Models\Soe_budget_allocation;
use App\Models\Soe_budget_distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FinyearController extends Controller
{
    public function index()
    {
      $finyear = Finyear::orderBy('id', 'DESC')->get();//paginate(10);
      if(count($finyear) > 0){
          return view('finyear.view-finyear', compact('finyear'));
      }else{
          return view('finyear.view-finyear');
      }
    }

    public function store(Request $request)
    {
      $validate = Validator::make($request->all(), [
        'finyear' => 'required|min:5|unique:fin-years',
      ]);
        if($validate->fails()){
          return back()->withErrors($validate->errors())->withInput();
        }else{
          Finyear::create($request->all());
          return redirect()->route('finyear.index')
            ->with('success','Fin-year created successfully.');
        }
      }

    public function show($id)
    {
      {
        $finyear = Finyear::find($id);
        return view('finyear.show-finyear')->with('finyear', $finyear);
      }
    }

    public function edit($id)
    {
      {
        $finyear = Finyear::find($id);
        return view('finyear.edit-finyear')->with('finyear', $finyear);
    }

    }

    public function update(Request $request, $id)
    {
      {
        $finyear = Finyear::find($id);
        $input = $request->all();
        $res = $finyear->update($input);
        return redirect('finyear')->with('update', 'Fin-year updated!');  
    }
    }

    public function destroy($id)
    {
      $soe_budget_allocation = Soe_budget_allocation::where('fin_year_id',$id)->get();
      $Soe_budget_distribution = Soe_budget_distribution::where('fin_year_id',$id)->get();

      if(count($Soe_budget_distribution) > 0){
          return redirect('finyear')->with('alert', 'Finyear is assigned with the soe-budget-distribution, please delete soe-budget-distribution first to delete the finyear.');
      }elseif(count($soe_budget_allocation) > 0){
        return redirect('finyear')->with('alert', 'Finyear is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the finyear.');
      }else{
        $finyear = Finyear::find($id);
        $finyear->delete();
        return redirect('finyear')->with('delete', 'Fin-year deleted!'); 
      }
    }
}
