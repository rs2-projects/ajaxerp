<?php

namespace App\Models\Production;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcessMachine extends Model
{
    use HasFactory;

    protected $table = 'pre_production_process_machines';
    public $timestamps = false;

    protected $fillable = [
        'pre_production_id',
        'pre_production_process_id',
        'machine_id'
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id')
            ->where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE);
    }
}
