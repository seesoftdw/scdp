<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Sector;
use App\Models\Subsector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportDepartment implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public function model(array $row)
    {
        
        return new Department([
            'hod_code' => $row['hod_code'],
            'hod_name' => $row['hod_name'],
            'department_name' => $row['department_name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'hod_code' => 'required|unique:departments,hod_code|min:1|max:3',
            'hod_name' => 'required|unique:departments,hod_name',
            'department_name' => 'required|unique:departments,department_name',

            // Above is alias for as it always validates in batches

            '*.hod_code' => 'required|unique:departments,hod_code|min:1|max:3',
            '*.hod_name' => 'required|unique:departments,hod_name',
            '*.department_name' => 'required|unique:departments,department_name'
            

        ];
    }
}