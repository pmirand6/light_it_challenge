<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 22:00
 */

namespace App\Repositories\Contracts;

use App\Models\Patient;

interface PatientRepositoryContract
{
    public function store(array $params): Patient;

    public function list();

    public function show(Patient $patient);

}
