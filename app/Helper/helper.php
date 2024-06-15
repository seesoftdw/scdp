<?php 

use App\Models\District;

if (!function_exists('get_distt')) {
   function get_distt($id)
   {
      $District = District::where('id', '=', $id)->first();
      $name = @$District->district_name;
      return $name;
   }
}

?>