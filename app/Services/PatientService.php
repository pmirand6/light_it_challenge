<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 21:59
 */

namespace App\Services;

use App\Events\PatientCreated;
use App\Exceptions\PatientDocumentServiceException;
use App\Exceptions\PatientServiceException;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Repositories\Contracts\PatientRepositoryContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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
            $patientResult = $this->storePatient($patientData, $file);
            PatientCreated::dispatch($patientResult);
            return $patientResult;
        } catch (\Exception $e) {
            Log::error('Error Saving Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            throw new PatientServiceException($e->getMessage());
        }

    }

    /**
     * @param array $patientData
     * @param array|UploadedFile|null $file
     * @return Patient
     * @throws PatientServiceException
     */
    protected function storePatient(array $patientData, array|UploadedFile|null $file): Patient
    {
        DB::beginTransaction();
        try {
            // Creates the patient record
            $patientResult = $this->patientRepository->store($patientData);

            // Creates the related patient's documentation
            $this->patientDocumentService->savePatientDocument([
                'file' => $file,
                'patientId' => $patientResult->id,
                'documentType' => 'identification_photo'
            ]);
            DB::commit();
            return $patientResult;
        } catch (PatientDocumentServiceException $e) {
            Log::error('Error Saving Document Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            DB::rollBack();
            throw new PatientServiceException($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error Saving Patient', [
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]);
            DB::rollBack();
            throw new PatientServiceException('Fatal Error Saving Patient');
        }

    }
}
