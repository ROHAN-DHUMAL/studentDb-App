<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentExport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    private $students;

    public function __construct() 
    {
        $this->students = Student::all();
    }

    public function view(): View
    {
        return view('students.studentExcel', [
            'students' => $this->students
        ]);
    }
}
