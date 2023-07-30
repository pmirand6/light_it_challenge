<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 12:46
 */

namespace App\Services;

use App\Exceptions\PatientDocumentServiceException;
use App\Repositories\Contracts\PatientDocumentRepositoryContract;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PatientDocumentService
{
    const PATIENT_DOCUMENTS_FOLDER = 'patients';

    public function __construct(private readonly PatientDocumentRepositoryContract $patientDocumentRepository)
    {
    }

    /**
     * Saves a patient's document
     *
     * @throws PatientDocumentServiceException
     */
    public function savePatientDocument(array $params): bool|string
    {
        Log::info('Saving Patient Document...', [
            'params' => $params,
        ]);
        try {
            $file = $params['file'];
            $patientId = $params['patientId'];
            $documentType = $params['documentType'];
            $fileExt = $file->getClientOriginalExtension();
            $fileNameToStore = $patientId . '_' . $documentType . '_'. time() . '.' . $fileExt;
            $filePath = $this->saveFile(self::PATIENT_DOCUMENTS_FOLDER, $file, $fileNameToStore);
            return $this->patientDocumentRepository->save($patientId, [
                'document_type' => $documentType,
                'file_path' => $filePath
            ]);
        } catch (\Exception $e) {
            Log::error('Error Saving Patient Document', [
                'params' => $params,
                'error' => $e->getMessage(),
            ]);
            throw new PatientDocumentServiceException($e->getMessage());
        }
    }

    private function saveFile(string $location, UploadedFile $file, string $fileName): string
    {
        return Storage::disk('public')->putFileAs($location, new File($file), $fileName);
    }

}
