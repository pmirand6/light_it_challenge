<?php

namespace App\Http\Controllers;

use App\Exceptions\PatientServiceException;
use App\Http\Requests\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Repositories\Contracts\PatientRepositoryContract;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService,
        private readonly PatientRepositoryContract $patientRepositoryContract
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PatientResource::collection($this->patientRepositoryContract->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request): JsonResponse
    {
        try {
            $result = $this->patientService->createPatient($request);
            return response()->json(new PatientResource($result), 201);
        } catch (PatientServiceException $exception) {
            return response()->json($exception->getMessage(), 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return response()->json(new PatientResource($patient));
    }
}
