<?php

namespace App\Services\Hr;

use App\Models\User;
use App\Models\UserLifecycle;

class UserLifecycleService
{
    public $user_id;
    public $type;
    public $date;
    public $department;
    public $designation;
    public $basic_salary;
    public $reference_description;
    public $description;

    public function setProperties(
        $user_id=null,
        $type=null,
        $date=null,
        $department=null,
        $designation=null,
        $basic_salary=null,
        $reference_description=null,
        $description=null
    )
    {
        if ($user_id !== null) {
            $this->user_id = $user_id;
        }
        if ($type !== null) {
            $this->type = $type;
        }
        if ($date !== null) {
            $this->date = $date;
        }
        if ($department !== null) {
            $this->department = $department;
        }
        if ($designation !== null) {
            $this->designation = $designation;
        }
        if ($basic_salary !== null) {
            $this->basic_salary = $basic_salary;
        }
        if ($reference_description !== null) {
            $this->reference_description = $reference_description;
        }
        if ($description !== null) {
            $this->description = $description;
        }
        return $this;
    }

    public function replaceProperties(
        $user_id=null,
        $type=null,
        $date=null,
        $department=null,
        $designation=null,
        $basic_salary=null,
        $reference_description=null,
        $description=null
    )
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->date = $date;
        $this->department = $department;
        $this->designation = $designation;
        $this->basic_salary = $basic_salary;
        $this->reference_description = $reference_description;
        $this->description = $description;
        return $this;
    }
    public function storeLifecycle()
    {
        $this->storeValidation();

        $cycle = new UserLifecycle();
        $cycle->user_id = $this->user_id;
        $cycle->type = $this->type;
        $cycle->date = $this->date;
        $cycle->department_id = $this->department;
        $cycle->designation_id = $this->designation;
        $cycle->basic_salary = $this->basic_salary;
        $cycle->reference_description = $this->reference_description;
        $cycle->description = $this->description;
        $cycle->status = 1;
        $cycle->created_at = now();
        $cycle->created_by = auth()->id();
        $cycle->updated_at = now();
        $cycle->updated_by = auth()->id();
        $cycle->save();
        return $cycle;
    }
    public function storeOrUpdateLifecycle()
    {
        $this->storeValidation();

        $cycle = UserLifecycle::where('user_id', $this->user_id)
            ->where('type', $this->type)
            ->first();
        if (empty($cycle)) {
            $cycle = new UserLifecycle();
            $cycle->user_id = $this->user_id;
            $cycle->type = $this->type;
            $cycle->status = 1;
            $cycle->created_at = now();
            $cycle->created_by = auth()->id();
        }

        $cycle->date = $this->date;
        $cycle->department_id = $this->department;
        $cycle->designation_id = $this->designation;
        $cycle->basic_salary = $this->basic_salary;
        $cycle->reference_description = $this->reference_description;
        $cycle->description = $this->description;
        $cycle->updated_at = now();
        $cycle->updated_by = auth()->id();
        $cycle->save();
        return $cycle;
    }

    public function storeValidation()
    {
        if ($this->user_id === null) {
            throw new \Exception("User Id is required!");
        }
        if ($this->type === null) {
            throw new \Exception("Type is required!");
        } elseif (!in_array($this->type, array_keys(UserLifecycle::TYPES))) {
            throw new \Exception("Invalid Type!");
        }
        if ($this->date === null) {
            throw new \Exception("Date is required!");
        }
        if (in_array($this->type,[UserLifecycle::TYPE_PROMOTION, UserLifecycle::TYPE_DEMOTION])) {
            if ($this->department === null) {
                throw new \Exception("Department is required for ".UserLifecycle::TYPES[$this->type]."!");
            }
            if ($this->designation === null) {
                throw new \Exception("Designation is required for ".UserLifecycle::TYPES[$this->type]."!");
            }
        }
    }


    public function storeJoin($user)
    {
        $this->setProperties(
            user_id: $user->id,
            type: UserLifecycle::TYPE_JOIN,
            date: $user->joining_date,
            department: $user->department_id,
            designation: $user->designation_id,
            basic_salary: 0,
            reference_description: '',
            description: ''
        );
        return $this->storeLifecycle();
    }

    public function storeUpdateSalary($user_id, $salary, $date)
    {
        $user = $this->findUser($user_id);
        $this->setProperties(
            user_id: $user->id,
            type: UserLifecycle::TYPE_SALARY_UPDATE,
            date: $date,
            department: $user->department_id,
            designation: $user->designation_id,
            basic_salary: $salary,
            reference_description: '',
            description: ''
        );
        return $this->storeLifecycle();
    }

    public function storeOrUpdateTermination($userTermination)
    {
        $user = $this->findUser($userTermination->user_id);
        $this->setProperties(
            user_id: $user->id,
            type: UserLifecycle::TYPE_TERMINATION,
            date: $userTermination->termination_date,
            department: $user->department_id,
            designation: $user->designation_id,
            basic_salary: '',
            reference_description: $userTermination->reason,
            description: ''
        );
        return $this->storeOrUpdateLifecycle();
    }

    public function storeResignationRequest($resignation)
    {
        $user = $this->findUser($resignation->user_id);
        $this->setProperties(
            user_id: $user->id,
            type: UserLifecycle::TYPE_RESIGNATION_REQUESTED,
            date: $resignation->resignation_date,
            department: $user->department_id,
            designation: $user->designation_id,
            basic_salary: 0,
            reference_description: $resignation->reason,
            description: ''
        );
        return $this->storeOrUpdateLifecycle();
    }

    public function findUser($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (empty($user)) {
            throw new \Exception("Invalid User!");
        }
        return $user;
    }
}
