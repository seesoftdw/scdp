<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Captital record on revenue list</title>
<link rel="stylesheet" type="text/css" media="print">
<style>
body {
    -webkit-print-color-adjust: exact;
    /*font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;*/
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 11px;
    background-repeat: repeat;
}
.hide-class-view {
    display: none;
}

@media print {
body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 11px;
    background: #fff;
    -webkit-print-color-adjust: exact;
    -moz-print-color-adjust: exact;
}
@page {
    size: A4 portrait;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
    margin: 10px;
    -webkit-print-color-adjust: exact;
    page-break-after: always;
}
.hide-class-view {
    display: block;
}
}
@page {
    size: A4 portrait;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
    margin: 10px;
    -webkit-print-color-adjust: exact;
    page-break-after: always;
}
table {
    border-collapse: collapse;
}
table p {
    margin-top: 0;
    line-height: 1.2;
}
table th {
    text-align: left;
}
</style>
</head>
<body>
<?php

?>
<table border="0" cellspacing="0" cellpadding="0" width="98%" style="margin:0 auto;  background: #fffef9;">
  <tbody>  

  <tr>
    <td width="100%"><img src="{{ public_path('img/header-bg.jpg') }}" width="100%" style="display: block; border: solid 2px #000; margin-bottom:5px;" alt=""></td>
  </tr>
  <tr>
    <td width="100%"><h2 style=" font-size:14px; margin-bottom:8px; color:#FFFFFF; text-align:center; background:#2959A3; padding:5px; border-radius:0px; ">Captital record on revenue list</h2></td>
  </tr>
  <tr>
    <td ><h3 style="font-size:13px;font-weight:bold; margin:8px 0px; border-bottom: solid 2px; display: inline-block">Capital Scheme information</h3></td>
  </tr>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="0" >
        <tbody>
          <tr>
            <td valign="top" width="78%"><table width="100%" border="1" cellspacing="0" cellpadding="2" style="margin:0 auto;">
                 <tbody>
                  <tr>
                    <td>Department: </td>
                    <td><b><span style="border-bottom:solid 1px #000;">{{$department}}</span></b></td>
                    <td>Major head:</td>
                    <td><b><span style="border-bottom:solid 1px #000;">{{$majorhead}}</span></b></td>
					  <td>Scheme:</td>
                    <td><b><span style="border-bottom:solid 1px #000;">{{$schemename}}</span></b></td>
                  </tr>
                   
                </tbody>
              </table></td>
          
          </tr>
        </tbody>
      </table></td>
  </tr>

 <tr>
    <td><br>
      <br></td>
  </tr>
  
   <tr>
    <td ><h3 style="font-size:13px;font-weight:bold; margin:8px 0px; border-bottom: solid 2px; display: inline-block">Capital record on revenue information</h3></td>
  </tr>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="0" >
        <tbody>
          <tr>
            <td valign="top" width="78%"><table width="100%" border="1" cellspacing="0" cellpadding="2" style="margin:0 auto;">
                   <tbody>
                  <tr>
                    <td>Work Code: </td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->enterWorkCode ? :  ' '  }}</span></p></td>
                    <td>Work Name:</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->enterWorkName ? :  ' '  }}</span></p></td>
                  </tr>
                  <tr>
                    <td>EstimateCost:</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->enterEstimateCost ? :  ' '  }}</span></p></td>
					 <td>AA/ES (In Lakhs) : </td>
                    <td><p><span style="border-bottom:solid 1px #000; ">{{ $revenuerecord->enterAA_ES ? :  ' '  }}</span></p></td>
                  </tr> 
				   <tr>	
                    <td>Budget Previous Year</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->budgetProvidedTillPreviousYear ? :  ' '  }}</span></p></td>
                    <td>Budget Utilize Previous Year</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->budgetUtilizeTillDatepreviousYear ? :  ' '  }}</span></p></td>
                  </tr>
				  <tr> 
            <td>Funds Required: </td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->fundsRequiredForCompletion ? :  ' '  }}</span></p></td>
            <td>Type</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->SelectType ? :  ' '  }}</span></p></td>
				  </tr>
				  <tr>
          <td>Work</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->SelectWork ? :  ' '  }}</span></p></td>
           <td>Original Scope Of Work:</td>
                    <td><p><span style="border-bottom:solid 1px #000; ">{{ $revenuerecord->selectOriginalScopeOfWork ? :  ' '  }}</span></p></td>         
          </tr>
          <tr>
          <td>Work Category:</td>
                    <td><p> <span style="border-bottom:solid 1px #000;">{{ $revenuerecord->workCategory ? :  ' '  }}</span></p></td>
          <td>Dispute:</td>
                    <td><p> <span style="border-bottom:solid 1px #000; ">{ $revenuerecord->dispute ? :  ' '  }}</span></p></td>
          </tr>
          <tr>
            <td>FCA:</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->fca ? :  ' '  }}</span></p></td>
					 <td>Detail: </td>
                 <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->enterDetail ? :  ' '  }}</span></p></td>
          </tr>
		   <td>pow:</td>
                    <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->pow ? :  ' '  }}</span></p></td>
					 <td>Category: </td>
                 <td><p><span style="border-bottom:solid 1px #000;">{{ $revenuerecord->category ? :  ' '  }}</span></p></td>
          </tr>
                 
                </tbody>
              </table></td>
          
          </tr>
		  
		    <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto"> 
        <tbody>
          <tr>
            <td colspan="3"><h3 style="font-size:13px;font-weight:bold; margin:8px 0px; border-bottom: solid 2px; display: inline-block">Invoices attached </h3></td>
          </tr>
        @if(!empty($inovices))
        <tr> @foreach($inovices as $_inovices)
          <td><img src="{{ asset($_inovices->uploadInvoice)}}" style="display: block; width: 200px; height: 200px; min-height: 200px;max-height: 200px; border: solid 1px #ccc; padding: 10px" alt=""></td>
          @endforeach </tr>
        @else
        <tr>
          <td colspan="3" style="display: block; width: 200px; height: 200px; padding: 10px"><p>Not found yet!!</p></td>
        </tr>
        @endif
       
       
        
        </tbody>
         
      </table></td> 
  </tr>
		  
        </tbody>
      </table></td>
  </tr>
  
  <tr>
    <td><br>
      <br></td>
  </tr>

  <tr>

  </tr>


  
  </tbody>

</table>

<?php //die; ?>
</body>
</html>