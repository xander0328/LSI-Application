<?php

namespace App\Exports;

use App\Models\Batch;
use App\Models\Enrollee;
use App\Models\UnitOfCompetency;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EnrolleesGrade implements FromArray, WithHeadings, WithStyles
{
    protected $data;
    protected $lessonsWithAssignments;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->generateHeaders(); // Generate headers dynamically from the data
    }

    protected function generateHeaders()
    {
        // Initialize an empty array to store lessons with assignments
        $assignments = [];

        // Iterate through each enrollee's data
        foreach ($this->data as $row) {
            // Iterate through each lesson in the current enrollee's data
            foreach ($row['lessons'] as $lesson => $lessonAssignments) {
                foreach ($lessonAssignments as $assignmentKey => $assignmentValue) {
                    // Extract lesson name and assignment key
                    $assignments[$lesson][] = $assignmentKey;
                }
            }
        }

        // Ensure each lesson's assignments are unique
        $this->lessonsWithAssignments = array_map('array_unique', $assignments);
    }

    public function array(): array
    {
        // Prepare data for export by flattening the lessons and assignments for each enrollee
        $formattedData = [];

        foreach ($this->data as $row) {
            $formattedRow = [];
            $formattedRow[] = $row['enrollee_name'] ?? '';

            // Populate the assignments under each lesson
            foreach ($this->lessonsWithAssignments as $lesson => $assignments) {
                foreach ($assignments as $assignment) {
                    // Check if the assignment exists in the current enrollee's data
                    $formattedRow[] = $row['lessons'][$lesson][$assignment] ?? ''; // Default to empty if not present
                }
            }

            $formattedData[] = $formattedRow;
        }

        return $formattedData;
    }

    public function headings(): array
    {
        // Main header (lesson names)
        $mainHeaders = ['Name'];
        foreach ($this->lessonsWithAssignments as $lesson => $assignments) {
            $mainHeaders[] = $lesson; // Add the lesson as the main header
            $mainHeaders = array_merge($mainHeaders, array_fill(0, count($assignments) - 1, ''));
        }

        // Sub-header (assignment names)
        $subHeaders = ['Name'];
        foreach ($this->lessonsWithAssignments as $lesson => $assignments) {
            foreach ($assignments as $assignment) {
                $subHeaders[] = $assignment; // Use the assignment names as sub-headers
            }
        }

        return [$mainHeaders, $subHeaders];
    }

    public function styles(Worksheet $sheet)
    {
        $columnCount = count($this->lessonsWithAssignments) + 1; // Account for the Name column

        // Merge main headers dynamically
        $sheet->mergeCells("A1:A2"); // Merge "Name"
        $colIndex = 2; // Start at column B
        foreach ($this->lessonsWithAssignments as $lesson => $assignments) {
            $mergeRange = chr(64 + $colIndex) . "1:" . chr(64 + $colIndex + count($assignments) - 1) . "1";
            $sheet->mergeCells($mergeRange);
            $colIndex += count($assignments);
        }

        // Style main headers
        $sheet->getStyle("A1:" . chr(64 + $columnCount) . "1")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF00BFFF'], // Light Blue
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Style sub-headers
        $sheet->getStyle("A2:" . chr(64 + $columnCount) . "2")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC6EDFB'], // Red background
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Auto-size columns for better readability
        foreach (range('A', chr(64 + $columnCount)) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }


}
