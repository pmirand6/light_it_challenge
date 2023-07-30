<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 12:46
 */

namespace App\Services;

use App\Exceptions\PatientDocumentServiceException;
use App\Repositories\Contracts\PatientDocumentRepositoryContract;
use Illuminate\Support\Facades\Log;

class PatientDocumentService
{
    public function __construct(private readonly PatientDocumentRepositoryContract $patientDocumentRepository)
    {
    }

    /**
     * Saves a patient's document
     * @throws PatientDocumentServiceException
     */
    public function savePatientDocument(array $params)
    {
        Log::info('Saving Patient Document...', [
            'params' => $params,
        ]);
        try {
            //return $this->patientDocumentRepository->save($patientId, $params);
            return true;
        } catch (\Exception $e) {
            Log::error('Error Saving Patient Document', [
                'params' => $params,
                'error' => $e->getMessage(),
            ]);
            throw new PatientDocumentServiceException('Error Saving Patient Document');
        }
    }

}
