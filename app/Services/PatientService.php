<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 21:59
 */

namespace App\Services;

use App\Repositories\Contracts\PatientRepositoryContract;

class PatientService
{
    public function __construct(private readonly PatientRepositoryContract $patientRepository)
    {
    }
}
