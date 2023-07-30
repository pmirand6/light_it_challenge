<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/29 22:01
 */

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class PatientRepository implements Contracts\PatientRepositoryContract
{
    public function __construct(private readonly Patient $model)
    {
    }

    /**
     * @param array $params
     * @return Patient
     */
    public function store(array $params): Patient
    {
        return $this->model->create($params);
    }
}
