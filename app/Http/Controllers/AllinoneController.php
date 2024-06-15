<?php

namespace App\Http\Controllers;

use App\Models\Finyear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportAllinone;

class AllinoneController extends Controller
{
    public function index()
    {
            $Finyear = Finyear::orderBy('id', 'DESC')->paginate(10);

            return view('allinone.index', compact('Finyear'));
        
    }

  
    
    public function import(Request $request){

        $validate = Validator::make($request->all(), [
            'finyear_id' => 'required',
           
        ]);

      //  print_r($request->input('finyear_id'));die;
        if ($validate->fails()) {
             return back()->withErrors($validate->errors())->withInput();
        }
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportAllinone($request->input('finyear_id')), $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Department imported successfully.');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    return redirect()->back()->with('import_errors', $failures);
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type:xlsx');
            }            
        }
    }
}