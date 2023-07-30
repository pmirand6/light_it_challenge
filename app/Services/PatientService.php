<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 21:59
 */

namespace App\Services;

use App\Exceptions\PatientDocumentServiceException;
use App\Exceptions\PatientServiceException;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Repositories\Contracts\PatientRepositoryContract;
use Illuminate\Support\Facades\Log;

class PatientService
{
    public function __construct(
        private readonly PatientRepositoryContract $patientRepository,
        private readonly PatientDocumentService $patientDocumentService
    )
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
            $file = $request->file('identification_photo');
            $patientData = $request->except('identification_photo');
            $patientResult = $this->patientRepository->store($patientData);
            $this->patientDocumentService->savePatientDocument([
                'file' => $file,
                'patientId' => $patientResult->id,
                'documentType' => 'identification_photo'
            ]);
            return $patientResult;
        } catch (PatientDocumentServiceException $e) {
            Log::error('Error Saving Document Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            throw new PatientServiceException($e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error Saving Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            throw new PatientServiceException('Error Saving Patient');
        }

    }
}
