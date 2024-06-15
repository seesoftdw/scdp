<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Majorhead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportMajorhead implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $department;


    public function __construct()
    {
        $this->department = Department::all();
    }

    public function model(array $row)
    {
        $department_id =  $this->department->where('department_name',$row['department_name'])->first();
        return new Majorhead([
            'department_id' => $department_id->id,
            'mjr_head' => $row['mjr_head'],
            'sm_head' => $row['sm_head'],
            'min_head' => $row['min_head'],
            'sub_head' => $row['sub_head'],
            'bdgt_head' => $row['bdgt_head'],
            'complete_head' => $row['complete_head'],
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
            'mjr_head' => 'required|min:4|max:4',
            'sm_head' => 'required|min:2|max:2',
            'min_head' => 'required|min:3|max:3',
            'sub_head' => 'required|min:2|max:2',
            'bdgt_head' => 'required|min:4|max:4',
            'complete_head' => 'required|unique:majorhead',

            // Above is alias for as it always validates in batches

            '*.department_name' => 'required',
            '*.mjr_head' => 'required|min:4|max:4',
            '*.sm_head' => 'required|min:2|max:2',
            '*.min_head' => 'required|min:3|max:3',
            '*.sub_head' => 'required|min:2|max:2',
            '*.bdgt_head' => 'required|min:4|max:4',
            '*.complete_head' => 'required|unique:majorhead',            

        ];
    }
}