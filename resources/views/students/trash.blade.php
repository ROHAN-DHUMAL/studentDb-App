@extends('students.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>TrashBox Data</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('students.index') }}"> Back</a>
            </div>
        </div>
    </div>

    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}

    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Student image</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Student Address</th>
            <th>Student Phone</th> <!-- Add this line -->
            <th width="280px">Action</th>
        </tr>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td><img src="/images/{{ $student->image }}" width="100px" height="120px"></td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->address }}</td>
            <td>{{ $student->phone }}</td>
            <td>
                <form action="{{ route('students.restore', $student->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Restore</button>
                 </form>
                 <form action="{{ route('students.permanentDelete', $student->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Permanently Delete</button>
                 </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $students->links() !!}

@endsection
