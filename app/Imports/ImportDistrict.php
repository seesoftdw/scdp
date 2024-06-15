<?php

namespace App\Imports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;


class ImportDistrict implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public function model(array $row)
    {
        return new District([
            'district_name' => $row['district_name'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'district_name' => 'unique:districts',

            // Above is alias for as it always validates in batches
            '*.district_name' => 'unique:districts',

        ];
    }
}