<?php

namespace App\Services\Inventory;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterial;

class PreProductionMaterialRequestService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function deliverData($id){
        $data['pre_production'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('id', $id)
            ->first();

        $data['materials'] = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('pre_production_id', $id)
            ->get();
        
        return $data;
    }
}
