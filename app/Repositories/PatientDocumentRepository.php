<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 12:48
 */

namespace App\Repositories;

use App\Models\PatientDocument;
use Illuminate\Database\Eloquent\Model;

class PatientDocumentRepository implements Contracts\PatientDocumentRepositoryContract
{

    public function __construct(private readonly PatientDocument $model)
    {
    }

    public function save(int $patientId, array $params): PatientDocument
    {
        return $this->model->create([
            'patient_id' => $patientId,
            'document_type' => $params['document_type'],
            'file_path' => $params['file_path'],
        ]);
    }
}
