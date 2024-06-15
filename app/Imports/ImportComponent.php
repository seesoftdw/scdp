<?php

namespace App\Imports;

use App\Models\Component;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImportComponent implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public function model(array $row)
    {
        return new Component([
            'component_name' => $row['component_name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'component_name' => 'unique:components|min:5',

            // Above is alias for as it always validates in batches
            '*.component_name' => 'unique:components|min:5',

        ];
    }
}
