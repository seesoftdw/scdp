<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportSchemeMaster implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $department,$majorhead;


    public function __construct()
    {
        $this->department = Department::all();
        $this->majorhead = Majorhead::all();
    }

    public function model(array $row)
    {
        $department_id =  $this->department->where('department_name',$row['department_name'])->first();
        $majorhead_id =  $this->majorhead->where('complete_head',$row['complete_head'])->first();
        
        return new Scheme_master([
            'department_id' => $department_id->id,
            'majorhead_id' => $majorhead_id->id,
            'scheme_name' => $row['scheme_name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'department_name' => 'required',
            'complete_head' => 'required',
            'scheme_name' => 'required',

            // Above is alias for as it always validates in batches

            '*.department_name' => 'required',
            '*.complete_head' => 'required',
            '*.scheme_name' => 'required',      

        ];
    }
}