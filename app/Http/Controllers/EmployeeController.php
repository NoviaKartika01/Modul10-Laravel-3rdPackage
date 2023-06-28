<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Position;

class EmployeeController extends Controller
{
    /**
     * Display List data employee
     */
    public function index()
    {
        //meyesuaikan kode program function index()
        $pageTitle = 'Employee List';

        // //RAW SQL QUERY
        // $employees = DB::select('
        // select *, employees.id as employee_id, positions.name as position_name
        // from employees
        // left join positions on employees.position_id = positions.id'
        // );

        // // SQL QUERY BUILDER
        // $employees = DB::table('employees')
        //     ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
        //     ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        //     ->get();

        //ELOQUENT
        $employees = Employee::all();

        // Menampilkan hasil pada file index yang ada di view/employee
        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);

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
        $employee->save();

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
        $employee->save();

        // Setelah berhasil di update maka akan di redirect ke halaman index
        return redirect()->route('employees.index');
    }


    /**
     * Remove atau menghapus data employee yang sudah tersimpan di database berdasarkan id
     */
    public function destroy(string $id)
    {
        // // QUERY BUILDER
        // DB::table('employees')
        // ->where('id', $id)
        // ->delete();

        // ELOQUENT
        Employee::find($id)->delete();

    return redirect()->route('employees.index');


    }
}
