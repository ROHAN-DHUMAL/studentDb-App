<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;


class trashboxController extends Controller
{
    public function trashBox(student $student)
    {
        // $student = Student::onlyTrashed()->paginate(5);
        // return view('students.trash');

        $students = Student::onlyTrashed()->paginate(5);
        return view('students.trashBox', compact('student'));
    }
}
