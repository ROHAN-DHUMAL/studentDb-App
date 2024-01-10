<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', "");

        if ($search !== "") {
            $students = Student::where('name', 'like', '%' . $search . '%')->orWhere('address', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);
        } else {
            $students = Student::orderBy('id', 'asc')->paginate(10);
        }

        return view('students.index', compact('students'))->with('i', (request()->input('page', 1) - 1) * 5)->with('search', $search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        student::create($input);

        return redirect()->route('students.index')->with('success','Student has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(student $student)
    {
        return view('students.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        return view('students.edit',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $student->update($input);

        return redirect()->route('students.index')->with('success','Student Has Been updated successfully.');
    }

    public function trash()
    {
        // var_dump("step");
        // $student = Student::onlyTrashed()->paginate(5);
        // return view('students.trash');

        // $students = Student::onlyTrashed()->all();
        // dd("hi");
        // return view('students.trash', compact('students'));
        // return view('students.trash');
        // var_dump("atsai");

        $students = Student::onlyTrashed()->paginate(5);
        // dd($students); // Use dd() for debugging

        return view('students.trash', compact('students'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success','Student has been deleted successfully.');
    }

    public function restore($id)
    {
        $restoredStudent = Student::withTrashed()->findOrFail($id);

        if ($restoredStudent->trashed()) {
            $restoredStudent->restore();
            return redirect()->route('students.index')->with('success', 'Student has been restored successfully.');
        }

        return redirect()->route('students.index')->with('error', 'Student not found or not soft-deleted.');
    }

    public function permanentDelete($id)
    {
        try {
            $student = Student::withTrashed()->findOrFail($id);
            $student->forceDelete();
            return redirect()->route('students.index')->with('success', 'Student has been permanently deleted.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the record is not found
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }
    }

    public function dwPdf()
    {
        $students = Student::orderBy('id', 'asc')->paginate(10);
        $data = ['students' => $students];

        // Remove or comment out the debugging statements
        // dd($students);  // Check if students are retrieved
        // dd(view('students.studentpdf', $data)->render());  // Check the rendered HTML

        $pdf = PDF::loadView('students.studentpdf', $data);
        return $pdf->stream('students.pdf');

        var_dump("hi");
    }

    public function dwExcel()
    {
        // return Excel::download(studentExport::class);
        return Excel::download(new StudentExport(), 'students.xlsx');
    }

    public function dwCsv()
    {
        // return Excel::download(studentExport::class);
        return Excel::download(new StudentExport(), 'students.csv');
    }
}
