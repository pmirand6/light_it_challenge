<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private readonly PatientService $patientService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        //Patient::all()
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
