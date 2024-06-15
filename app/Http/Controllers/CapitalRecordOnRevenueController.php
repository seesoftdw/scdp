<?php

namespace App\Http\Controllers;
use App\Models\Component;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\District;
use App\Models\Constituency;
use App\Models\Department;
use App\Models\Finyear;
use App\Models\Revenuerecord;

use App\Models\Soe_budget_allocation;
use App\Models\Majorhead;
use App\Models\DocumentsRevenue;
use PDF;
use Illuminate\Filesystem\Filesystem;
use PDFMerger;


class CapitalRecordOnRevenueController extends Controller
{
    public function index()
    {
      return view('capital-record-on-revenue.view-capital-record-on-revenue');
    }
    public function all_capital_List(){
      return view('capital-record-on-revenue.create-capital-record-on-revenue');
    }
	 public function addCapitalRecord($id){
		 
		
		 $schemeId=$id;
		 $capitalData = Soe_budget_allocation::select("Soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","Soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "capital")
                ->where("Soe_budget_allocation.id", "=", $id)
                ->first();
  // dd($capitalData);
       return view('capital-record-on-revenue.add',compact('capitalData','schemeId'));
    }
	
	public function  viewCapitalRecord ($id){
		 $schemeId=$id;
		  $capitalData = Soe_budget_allocation::select("Soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","Soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "capital")
                ->where("Soe_budget_allocation.id", "=", $id)
                ->first();
		 $revenuerecord=Revenuerecord::where('sechmeId',$id)->paginate(15);
		
		return view('capital-record-on-revenue.view',compact('revenuerecord','schemeId','capitalData'));
		
	}
	
	public function  revenuedetail ($id){
		 $schemeId=$id;
		 $revenuerecord=Revenuerecord::where('id',$id)->first();
		  $capitalData = Soe_budget_allocation::select("Soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","Soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "capital")
                ->where("Soe_budget_allocation.id", "=", $revenuerecord->sechmeId)
                ->first();
		// dd($revenuerecord);
		
		return view('capital-record-on-revenue.revenue-detail',compact('revenuerecord','schemeId','capitalData'));
		
	}
	

	public  function storerevenue(request $request){
		  $userId = auth()->user()->id;
		  $fileupload=$_FILES['uploadInvoice'];

	
	
	
	// $files = $request->file('uploadInvoice');

				// foreach($files as $file){                       
			// dd("true");
			// $_fileupload->move(public_path() . '/gallery/', $name);
			// $fileName='gallery/'.$name;
			// DocumentsRevenue::create([
			// 'revenue_id'=>$Revenuerecord->id,
			// 'user_id'=>$userId,
			// 'path'=>$fileName
			// ]);
		// }


	$allowedfileExtension=['pdf','jpg','png','docx'];
	
	
	$uploadInvoice="";
	$SucessStories="";
		if($request->hasFile('SucessStories')){
		$FileSucessStories= $request->file('SucessStories');
		// $filename = $FileSucessStories->getClientOriginalName();
		$extension = $FileSucessStories->getClientOriginalExtension();
		$check=in_array($extension,$allowedfileExtension);

		// $Filename = time().$FileSucessStories->getClientOriginalName();
		// $FileSucessStories->move(public_path() . '/revenue/', $Filename);
		
		$Filename = time() . uniqid(rand()) . '.' . $FileSucessStories->extension();
		$FileSucessStories->move(public_path() . '/revenue/', $Filename);
		
		$SucessStories='revenue/'.$Filename;


		}
		
   
		$Revenuerecord = new Revenuerecord();
		$Revenuerecord->user_id = $userId;
		$Revenuerecord->enterWorkCode = $request->enterWorkCode;
		$Revenuerecord->enterWorkName = $request->enterWorkName;
		$Revenuerecord->enterEstimateCost = $request->enterEstimateCode;
		$Revenuerecord->enterAA_ES = $request->enterAA_ES; 
		$Revenuerecord->budgetProvidedTillPreviousYear = $request->budgetProvidedTillPreviousYear;
		$Revenuerecord->budgetUtilizeTillDatepreviousYear = $request->budgetUtilizeTillDatepreviousYear;
		$Revenuerecord->fundsRequiredForCompletion = $request->fundsRequiredForCompletion;
		$Revenuerecord->SelectType = $request->SelectType;
		$Revenuerecord->SelectWork = $request->SelectWork;
		$Revenuerecord->selectOriginalScopeOfWork = $request->selectOriginalScopeOfWork;
			$Revenuerecord->workCategory = $request->workCategory;
			$Revenuerecord->dispute = $request->dispute;
			$Revenuerecord->fca = $request->fca;
			$Revenuerecord->enterDetail = $request->enterDetail;
			$Revenuerecord->priority = $request->priority;
		$Revenuerecord->pow = $request->pow;
		$Revenuerecord->category = $request->category;
		$Revenuerecord->sechmeId = $request->schemeId;
		// $Revenuerecord->uploadInvoice = $uploadInvoice;
		$Revenuerecord->SucessStories = $SucessStories;
		$Revenuerecord->save();
		if($request->hasFile('uploadInvoice')){
			$files = $request->file('uploadInvoice');
		foreach($files as $file){
	
	// $filename = $file->getClientOriginalName();
	$extension = $file->getClientOriginalExtension();
	$check=in_array($extension,$allowedfileExtension);

	// $Filename = time().$file->getClientOriginalName();
	// $file->move(public_path() . '/revenue/', $Filename);
	
		$Filename = time() . uniqid(rand()) . '.' . $file->extension();
		$file->move(public_path() . '/revenue/', $Filename);
	
	
	$uploadInvoice='revenue/'.$Filename;
	
	
	
	DocumentsRevenue::create([
			'revenue_id'=>$Revenuerecord->id,
			'user_id'=>$userId,
			'uploadInvoice'=>$uploadInvoice
			]);
	}		




		}
	
		return redirect()->route('capital-scheme')
					->with('success','Revenue added successfully.');
	}
	
	
		public function generatePDF($id){
		// dd($id);
		 $schemeId=$id;
		 $revenuerecord=Revenuerecord::where('id',$id)->first();
		 $inovices=DocumentsRevenue::where('revenue_id',$revenuerecord->id)->get();
		  $capitalData = Soe_budget_allocation::select("Soe_budget_allocation.*","majorhead.type as type")
                ->join("majorhead","majorhead.id","=","Soe_budget_allocation.majorhead_id")
                ->where("majorhead.type", "=", "capital")
                ->where("Soe_budget_allocation.id", "=", $revenuerecord->sechmeId)
                ->first();
			
		$data = [
			'title' => 'Captital record on revenue list',
			'logo' => 'http://sjay.poc.webappline.com/public/img/logo-new.png',
			'department' => $capitalData->department->department_name,
			'majorhead' => $capitalData->majorhead->complete_head,
			'schemename' => $capitalData->scheme->scheme_name,
			'revenuerecord' => $revenuerecord,
			'inovices' => $inovices
				
        ];


        $pdf = PDF::loadView('capital-record-on-revenue.revenue-pdf', $data);
		
		   return $pdf->download($capitalData->id . 'Captital record.pdf');		
	}
}