<?php

namespace App\Http\Controllers;
use App\Models\Constituency;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ConstituencyController extends Controller
{
    public function index()
    {
        // $constituency = Constituency::all();
        $constituency = Constituency::orderBy('id', 'DESC')->paginate(10);
        
        if(count($constituency) > 0){
            return view('constituency.view-constituency', compact('constituency'));
        }else{
            return view('constituency.view-constituency');
        }
    }

    public function create()
    {
        
    }
    public function districtList()
    {
        $districtlist = District::all();
        if(count($districtlist) > 0){
            return view('constituency.create-constituency', compact('districtlist'));
        }else{
            return view('constituency.create-constituency');
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
			'district_id' => 'required',
			'constituencys_name' => 'required|min:5|unique:constituencys',
		]);
			if($validate->fails()){
				return back()->withErrors($validate->errors())->withInput();
			}else{
				Constituency::create($request->all());
				return redirect()->route('constituency.index')
					->with('success','Constituency created successfully.');
			}
    }

    public function show($id)
    {
        $constituency = Constituency::find($id);
        return view('constituency.show-constituency')->with('constituency', $constituency);
    }

    public function edit($id)
    {
        $constituency = Constituency::find($id);
        $districtlist = District::all();
        return view('constituency.edit-constituency')->with('constituency', $constituency)->with('districtlist', $districtlist);
    }

    public function update(Request $request, $id)
    {
        $constituency = Constituency::find($id);
        $input = $request->all();
        $res = $constituency->update($input);
        return redirect('constituency')->with('update', 'Constituency Updated!'); 
    }

    public function destroy($id)
    {
        $constituency = Constituency::find($id);
        $constituency->delete();
        return redirect('constituency')->with('delete', 'Constituency Deleted!'); 
    }

    public function import(Request $request){

        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                $excelArray = Excel::toArray([],$request->file);   
                $newArray = array_values($excelArray[0]);
                $record = 0;
                for ($i=1; $i < count($newArray); $i++) { 
                    if(!($newArray[$i][0] == null && $newArray[$i][1] == null)){
                        $validate = Validator::make($newArray[$i], [
                            '0' => 'required',
                            '1' => 'required|min:5|unique:constituencys,constituencys_name',
                        ]);
                        if(!$validate->fails()){
                            $district_id =  District::where('district_name',$newArray[$i][0])->first();
                            if(!$district_id == null) {
                                $record++;
                                $arrayVariable = array(
                                    'district_id'=> $district_id->id,
                                    'constituencys_name' => $newArray[$i][1]
                                );
                                Constituency::create($arrayVariable);
                            }
                        }
                    }
                }
                if($record > 0){
                    return redirect()->route('constituency.index')
                    ->with('success',$record .' Constituency imported successfully.');
                }else{
                    return redirect()->route('constituency.index')
                ->with('success',$record .' Constituency imported.');
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type:xlsx');
            }            
        }
    }
}
