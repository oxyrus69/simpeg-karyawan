<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $departmentId = $request->input('department_id');
        
        // Mengambil semua departemen untuk dropdown filter
        $departments = Department::all();

        $employees = Employee::with(['department', 'position', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhereHas('user', function ($q) use ($search) {
                                 $q->where('email', 'like', "%{$search}%");
                             });
            })
            // Filter berdasarkan departemen yang dipilih
            ->when($departmentId, function ($query, $departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->latest()
            ->paginate(10);

        // Menambahkan parameter pencarian ke link paginasi
        $employees->appends($request->only(['search', 'department_id']));

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        // Kode ini mengambil user yang BELUM punya profil karyawan
        $users = User::whereDoesntHave('employee')->get();
        $departments = Department::all();
        $positions = Position::all();
        
        // Pastikan variabel $users dikirim ke view
        return view('employees.create', compact('users', 'departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        // Load relasi agar bisa ditampilkan di view
        $employee->load(['user', 'department', 'position', 'performanceReviews']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $users = User::all(); // Saat edit, kita tampilkan semua user termasuk user saat ini
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'users', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        // Langkah 1: Validasi
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Langkah 2: Simpan properti satu per satu
        $employee->user_id = $request->input('user_id');
        $employee->department_id = $request->input('department_id');
        $employee->position_id = $request->input('position_id');
        $employee->nama_lengkap = $request->input('nama_lengkap');
        $employee->alamat = $request->input('alamat');
        $employee->no_telepon = $request->input('no_telepon');
        $employee->tanggal_bergabung = $request->input('tanggal_bergabung');

        // Langkah 3: Proses file foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($employee->photo) {
                // Gunakan disk 'public_uploads'
                Storage::disk('public_uploads')->delete($employee->photo);
            }

            // Simpan file baru
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('', $fileName, 'public_uploads'); // Menyimpan ke root disk
            
            // Set properti foto
            $employee->photo = $fileName;
        }

        // Langkah 4: Jalankan method save()
        $employee->save();

        // Langkah 5: Redirect dengan pesan sukses
        return redirect()->route('employees.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function export() 
    {
        $fileName = 'daftar-karyawan.csv';
        $employees = Employee::with(['user', 'department', 'position'])->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = [
            'ID Karyawan', 'Nama Lengkap', 'Email', 'No Telepon', 
            'Departemen', 'Jabatan', 'Alamat', 'Tanggal Bergabung'
        ];

        $callback = function() use($employees, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($employees as $employee) {
                $row['ID Karyawan']  = $employee->id;
                $row['Nama Lengkap'] = $employee->nama_lengkap;
                $row['Email'] = $employee->user->email ?? 'N/A';
                $row['No Telepon'] = $employee->no_telepon;
                $row['Departemen'] = $employee->department->nama_departemen ?? 'N/A';
                $row['Jabatan'] = $employee->position->nama_jabatan ?? 'N/A';
                $row['Alamat'] = $employee->alamat;
                $row['Tanggal Bergabung'] = \Carbon\Carbon::parse($employee->tanggal_bergabung)->toFormattedDateString();

                fputcsv($file, array(
                    $row['ID Karyawan'], $row['Nama Lengkap'], $row['Email'], $row['No Telepon'], 
                    $row['Departemen'], $row['Jabatan'], $row['Alamat'], $row['Tanggal Bergabung']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Employee $employee)
    {
        // Hapus foto jika ada
        if ($employee->photo) {
            Storage::disk('public_uploads')->delete($employee->photo);
        }
        $employee->delete();
        // Cek peran pengguna dan arahkan ke halaman yang sesuai
        if (Auth::user()->role == 'admin') {
            return redirect()->route('employees.index')
                             ->with('success', 'Data karyawan berhasil dihapus.');
        }
         // Jika bukan admin (berarti manajer), kembalikan ke halaman sebelumnya
         return redirect()->back()->with('success', 'Anggota tim berhasil dihapus.');
    }
}