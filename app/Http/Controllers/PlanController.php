<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Soe_budget_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\ImportDistrict;

class PlanController extends Controller
{
    public function index()
    {
        $plan = Plan::orderBy('id', 'DESC')->get();//paginate(10);
        if(count($plan) > 0){
            return view('plan.view-plan', compact('plan'));
        }else{
            return view('plan.view-plan');
        }        
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'plan_name' => 'required|unique:plans',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }else{
            Plan::create($request->all());
            return redirect()->route('plan.index')->with('success', 'Plan created successfully.');
        }
    }

    public function show($id)
    {
        $plan = Plan::find($id);
        return view('plan.show-plan')->with('plan', $plan);
    }

    public function edit($id)
    {
        $plan = Plan::find($id);
        return view('plan.edit-plan')->with('plan', $plan);
    }

    public function update(Request $request, $id)
    {
        $plan= Plan::find($id);
        $input = $request->all();
        $res = $plan->update($input);
        return redirect('plan')->with('update', 'Plan updated.');
    }
    public function destroy($id)
    {
        $soe_budget_allocation = Soe_budget_allocation::where('plan_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
        return redirect('plan')->with('alert', 'Plan is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the plan.');
        }else{
            $plan = Plan::find($id);
            $plan->delete();
            return redirect('plan')->with('delete', 'Plan Deleted.');    
        }
    }
}
