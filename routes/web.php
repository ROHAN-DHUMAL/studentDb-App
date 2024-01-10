<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\trashboxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Route::resource('students', StudentController::class);

    // Route::get('/students/trashBox', [StudentController::class, 'trash'])->name('students.trashBin');
    // Route::get('/students/trash', 'trashboxController@trashBox');
    // Route::get('students/trashBox', 'trashboxController@trashBox')->name('students.trashBox');

    Route::get('/students/trash', [StudentController::class, 'trash'])->name('students.trash');
    
    //Route for index
    // Route::get('/students',[StudentController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    
    // Create
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    //Route::get('/students/create', [StudentController::class, create]);

    // Store
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    //Route::post('/students',[StudentsController::class, 'store']);

    // Show
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

    // Edit
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

    // Update
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

    // Destroy (Soft Delete)
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    
    // Trash
    Route::get('/students/trash', [StudentController::class, 'trash'])->name('students.trash');

    // Permanently Delete
    Route::delete('/students/permanentDelete/{student}', [StudentController::class, 'permanentDelete'])->name('students.permanentDelete');

    //Restore
    Route::post('/students/restore/{id}', [StudentController::class, 'restore'])->name('students.restore');

    //Download Pdf
    Route::get('/studentpdf', [StudentController::class, 'dwPdf'])->name('students.studentpdf');

    //Download Excel
    Route::get('/studentexcel',[StudentController::class, 'dwExcel'])->name('students.studentexcel');

    //Download Csv
    Route::get('/studentcsv',[StudentController::class, 'dwCsv'])->name('students.studentcsv');

    // Route::get('/students/trashBox', 'StudentController@trash')->name('students.trashBox');
    // Route::get('/students/restore/{id}', 'StudentController@restore')->name('students.restore');
    // Route::delete('/students/perma-delete/{student}', 'StudentController@permaDelete')->name('students.permaDelete');
    // Route::get('/students/temp',[StudentController::class, 'temp'])->name('students.temp');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
