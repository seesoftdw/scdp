<?php

namespace App\Imports;

use App\Models\Sector;
use App\Models\Service;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
class ImportSector implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $sector;


    public function __construct()
    {
        $this->service = Service::all();
        $this->department = Department::all();
    }

    public function model(array $row)
    {
        $service_id =  $this->service->where('service_name',$row['service_name'])->first();
        $department_id =  $this->department->where('department_name',$row['department_name'])->first();

        return new Sector([
            'service_id' => $service_id->id,
            'department_id' => $department_id->id,
            'sector_name' => $row['sector_name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'service_name' => 'required',
            'department_name' => 'required',
            'sector_name' => 'unique:sectors|min:5',

            // Above is alias for as it always validates in batches
            '*.sector_name' => 'unique:sectors|min:5',

        ];
    }

    

}
