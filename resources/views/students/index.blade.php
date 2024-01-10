@extends('students.layout')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h1>Student's Data</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-9">
            <a class="btn btn-success" href="{{ route('students.create') }}"> Create Student</a>
            <a class="btn btn-danger" href="{{ route('students.trash') }}"> Trashbox</a>
        </div>
        <div class="col-3 text-end">
            Download Data:
            <a class="btn btn-outline-danger" href="{{ route('students.studentpdf') }}" target="_blank"> Pdf</a>
            <a class="btn btn-outline-success" href="{{ route('students.studentexcel') }}" target="_blank"> Excel</a>
            <a href="{{ route('students.studentcsv') }}" class="btn btn-outline-dark"> CSV</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <form action="" class="form-inline">
                <div class="input-group mt-2 mb-2">
                    <input type="text" class="form-control" placeholder="search" name="search"
                        value="{{ $search }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                    <div class="input-group-append">
                        <a href="{{ url('/students') }}" class="btn btn-danger">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Student image</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Student Address</th>
            <th>Student Phone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($students as $student)
            <tr>
                <td>{{ ++$i }}</td>
                <td><img src="/images/{{ $student->image }}" width="100px" height="120px" class="img-responsive"></td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->address }}</td>
                <td>{{ $student->phone }}</td>
                <td>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('students.show', $student->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('students.edit', $student->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">SoftDelete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $students->links() !!}
@endsection
