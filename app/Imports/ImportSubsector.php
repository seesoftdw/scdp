<?php

namespace App\Imports;

use App\Models\Sector;
use App\Models\Service;
use App\Models\Subsector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
class ImportSubsector implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $sector;


    public function __construct()
    {
        $this->service = Service::all();
        $this->sector = Sector::all();
    }

    public function model(array $row)
    {
        $service_id =  $this->service->where('service_name',$row['service_name'])->first();
        $sector_id =  $this->sector->where('sector_name',$row['sector_name'])->first();

        return new Subsector([
            'service_id' => $service_id->id,
            'sector_id' => $sector_id->id,
            'department_id' => $sector_id->department_id,
            'subsectors_name' => $row['subsectors_name'],
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
            'sector_name' => 'required',
            'subsector_name' => 'unique:subsectors|min:5',

            // Above is alias for as it always validates in batches
            '*.subsector_name' => 'unique:subsectors|min:5',

        ];
    }

    

}
