<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StudentPdf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="row text-center">
        <h2 class="mx-auto">Students Data</h2>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Student Address</th>
            <th>Student Phone</th>
        </tr>
        @php
            $i = 0; // Initialize $i
        @endphp
        @foreach ($students as $student)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->address }}</td>
                <td>{{ $student->phone }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
