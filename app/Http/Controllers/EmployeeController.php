<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// untuk sweet alert
use RealRashid\SweetAlert\Facades\Alert;
// untuk export file excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
// untuk export file pdf
use PDF;


class EmployeeController extends Controller
{
    /**
     * Display List data employee
     */
    public function index()
    {
        //meyesuaikan kode program function index()
        $pageTitle = 'Employee List';

        confirmDelete();

        return view('employee.index', compact('pageTitle'));
    }

    /**
     * Show form untuk membuat data karwawan baru
     */

    public function create()
    {
        //menyesuaikan kode function create()
        $pageTitle = 'Create Employee';

        // //RAW SQL QUERY
        // $positions = DB::select('select * from positions');

        // return view('employee.create', compact('pageTitle', 'positions'));

        // // SQL QUERY BUILDER
        // $positions = DB::table('positions')->get();


        // ELOQUENT
        $positions = Position::all();

        // menampilkan form create pada file create, yang ada di view/employee, dengan memawa nilai pageTitle dan position
        return view('employee.create', compact('pageTitle', 'positions'));
    }

    /**
     * Menyimpan data dalam database
     */
    public function store(Request $request)
    {
        // Mendefinisikan pesan yang ditampilkan saat terjadi kesalahan inputan pada form create employee
        $messages = [
            'required' => ':attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar.',
            'numeric' => 'Isi :attribute dengan angka.'
        ];

        // Validasi dari inputan menggunakan validator
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);
        // Jika validasi terjadi kesalahan maka pesan kesalahan akan muncul
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            // Get File
        $file = $request->file('cv');

        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            // Store File
            $file->store('public/files');
        }

        // // INSERT QUERY Builder
        // DB::table('employees')->insert([
        //     'firstname' => $request->firstName,
        //     'lastname' => $request->lastName,
        //     'email' => $request->email,
        //     'age' => $request->age,
        //     'position_id' => $request->position,
        // ]);

        // ELOQUENT
        $employee = New Employee;
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;

        if ($file != null) {
            $employee->original_filename = $originalFilename;
            $employee->encrypted_filename = $encryptedFilename;
        }

        $employee->save();

        // untuk sweet alert
        Alert::success('Added Successfully', 'Employee Data Added Successfully.');

        return redirect()->route('employees.index');
    }

    /**
     * Display detail karyawan
     */
    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

        // //RAW SQL QUERY
        // $employee = collect(DB::select('
        // select *, employees.id as employee_id, positions.name as position_name
        // from employees
        // left join positions on employees.position_id = positions.id
        // where employees.id = ?',
        // [$id]))->first();

        // return view('employee.show', compact('pageTitle', 'employee'));

        // $pageTitle = 'Employee Detail';

        // // SQL QUERY BUILDER
        // $employee = DB::table('employees')
        //     ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
        //     ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        //     ->where('employees.id', '=', $id)
        //     ->first();

        // ELOQUENT
        $employee = Employee::find($id);

        // Menampilkan halaman detail karyawan berdasarkan id dengan memebawa nilai pageTitle dan employee
        return view('employee.show', compact('pageTitle', 'employee'));

    }

    /**
     * Menampilkan form untuk mengedit data karyawan
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';

        // // Query Builder
        // $employee = DB::table('employees')
        //     ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
        //     ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        //     ->where('employees.id', '=', $id)
        //     ->first();

        // $positions = DB::table('positions')->get();

        // ELOQUENT
        $positions = Position::all();
        $employee = Employee::find($id);

        // menampilkan view pada file edit berdasarkan id employee dengan memebawa nilai pageTitle, employee, position
        return view('employee.edit', compact('pageTitle', 'employee', 'positions'));
    }

    /**
     * Update data karyawan pada storage atau penyimpanan database
     */
    public function update(Request $request, $id)
    {
        // Mendefinisikan pesan yang ditampilkan saat terjadi kesalahan inputan pada form create employee
        $messages = [
            'required' => ':attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar.',
            'numeric' => 'Isi :attribute dengan angka.'
        ];

        //  Validasi dari inputan menggunakan validator
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        // Jika validasi terjadi kesalahan maka pesan kesalahan akan muncul
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get File
        $file = $request->file('cv');

        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            // Store File
            $file->store('public/files');

            // Hapus file terkait employee jika ada
            $employee = Employee::find($id);
            if ($employee->encrypted_filename) {
                Storage::delete('public/files/'.$employee->encrypted_filename);
            }
        }

        // // UPDATE QUERY
        // DB::table('employees')
        //     ->where('id', $id)
        //     ->update([
        //         'firstname' => $request->firstName,
        //         'lastname' => $request->lastName,
        //         'email' => $request->email,
        //         'age' => $request->age,
        //         'position_id' => $request->position,
        //     ]);

        // ELOQUENT
        $employee = Employee::find($id);
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;

        if ($file != null) {
            $employee->original_filename = $originalFilename;
            $employee->encrypted_filename = $encryptedFilename;
        }

        $employee->save();

        // untuk sweet alert
        Alert::success('Changed Successfully', 'Employee Data Changed Successfully.');

        // Setelah berhasil di update maka akan di redirect ke halaman index
        return redirect()->route('employees.index');
    }


    // /**
    //  * Remove atau menghapus data employee yang sudah tersimpan di database berdasarkan id
    //  */
    public function destroy(string $id)
    {
        // ELOQUENT
        $employee = Employee::find($id);

        // hapus file yang terhubung dengan employee jika ada
        if ($employee->encrypted_filename) {
            Storage::delete('public/files/'.$employee->encrypted_filename);
        }

        $employee->delete();

        // untuk sweet alert
        Alert::success('Deleted Successfully', 'Employee Data Deleted Successfully.');

        return redirect()->route('employees.index');
    }


    // untuk download file (CV) employee
    public function downloadFile($employeeId)
    {
        $employee = Employee::find($employeeId);
        $encryptedFilename = 'public/files/'.$employee->encrypted_filename;
        $downloadFilename = Str::lower($employee->firstname.'_'.$employee->lastname.'_cv.pdf');

        if(Storage::exists($encryptedFilename)) {
            return Storage::download($encryptedFilename, $downloadFilename);
        }
    }

    // server-side processing Data Tables
    public function getData(Request $request)
    {
        $employees = Employee::with('position');

        if ($request->ajax()) {
            return datatables()->of($employees)
                ->addIndexColumn()
                ->addColumn('actions', function($employee) {
                    return view('employee.actions', compact('employee'));
                })
                ->toJson();
        }
    }

    // Untuk export file eexcel
    public function exportExcel()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }

    // untuk export file pdf
    public function exportPdf()
    {
        $employees = Employee::all();

        $pdf = PDF::loadView('employee.export_pdf', compact('employees'));

        return $pdf->download('employees.pdf');
    }
}
