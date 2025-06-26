<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $managerProfile = Auth::user()->employee;

        if ($managerProfile) {
            $teamMembers = Employee::where('department_id', $managerProfile->department_id)
                                    ->where('id', '!=', $managerProfile->id)
                                    ->with(['user', 'position'])
                                    ->paginate(10);
            
            return view('team.index', compact('teamMembers', 'managerProfile'));
        }

        // Jika manajer tidak punya profil, arahkan ke dashboard biasa
        return redirect()->route('dashboard');
    }
}