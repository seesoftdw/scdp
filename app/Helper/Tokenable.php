<?php 
namespace App\Helper;
use App\Models\District;
use Illuminate\Support\Str;

Trait Tokenable 
{
    public function generateAndSaveApiAuthToken()
    {
        $token = Str::random(60);

        $this->remember_token = $token;
        $this->save();

        return $this;
    }

    static function get_distt($id)
   {
      $District = District::where('id', '=', $id)->first();
      $name = @$District->district_name;
      return $name;
   }


    
}
?>