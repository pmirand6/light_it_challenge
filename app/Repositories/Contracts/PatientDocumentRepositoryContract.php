<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 12:47
 */

namespace App\Repositories\Contracts;

interface PatientDocumentRepositoryContract
{
    public function save(int $patientId, array $params);

}
