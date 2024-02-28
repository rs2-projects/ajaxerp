<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcessPreviousProcess extends Model
{
    use HasFactory;

    protected $table = 'pre_production_process_previous_processes';
    public $timestamps = false;

    protected $fillable = [
        'pre_production_id',
        'pre_production_process_id',
        'process_id'
    ];
}
