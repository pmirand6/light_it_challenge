<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 21:59
 */

namespace App\Services;

use App\Exceptions\PatientServiceException;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Repositories\Contracts\PatientRepositoryContract;
use Illuminate\Support\Facades\Log;

class PatientService
{
    public function __construct(private readonly PatientRepositoryContract $patientRepository)
    {
    }

    /**
     * Creating a New Patient
     * @throws PatientServiceException
     */
    public function createPatient(StorePatientRequest $request): Patient
    {
        Log::info('Creating Patient...', [
            'request' => $request->toArray()
        ]);
        try {
            $file = $request->get('identification_photo');
            $patientData = $request->except('identification_photo');
            $patientResult = $this->patientRepository->store($patientData);
            return $patientResult;
        } catch (\Exception $e) {
            Log::error('Error Saving Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            throw new PatientServiceException('Error Saving Patient');
        }

    }
}
