<?php

namespace App\Exports;

use App\Models\Employer\AccountInformationModel as Employer;
use App\Models\Applicant\RegisterModel as Applicant ;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection , WithHeadings , WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function collection()
    {
        // Get applicants
        $applicants = Applicant::with('personal_info')->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'name' => $a->personal_info?->first_name . ' ' . $a->personal_info?->last_name,
                'email' => $a->email,
                'type' => 'applicant',
                'created_at' => $a->created_at->format('M d, Y'),
            ];
        });

        // Get employers
        $employers = Employer::with('personal_info', 'addressCompany')->get()->map(function ($e) {
            return [
                'id' => $e->id,
                'name' => $e->addressCompany?->company_name ?? 'Unknown Company',
                'email' => $e->email,
                'type' => 'employer', 
                'created_at' => $e->created_at->format('M d, Y'),
            ];
        });

        // Merge both collections
        return $applicants->merge($employers);
    }

    public function headings(): array
    {
        return ['ID', 'Name / Company', 'Email', 'Type', 'Registered At'];
    }

      public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold the first row (headings)
        ];
    }
}
