<?php

namespace App\Imports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
class ImportService implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public function model(array $row)
    {
        return new Service([
            'service_name' => $row['service_name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'service_name' => 'unique:services|min:5',

            // Above is alias for as it always validates in batches
            '*.service_name' => 'unique:services|min:5',

        ];
    }
}