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

    public function list()
    {
        return $this->model->paginate(10);
    }

    public function show(Patient $patient)
    {
        return $this->model->find($patient);
    }
}
