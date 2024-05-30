<?php

namespace App\Services\Production\BoardPreProduction;

use App\Models\Production\BoardPreProduction;

class CalculateBoardPriceService
{
    public function indexData($id)
    {
        try {
            $pre_production = BoardPreProduction::where('id', $id)
                ->where('deleted', BoardPreProduction::DELETED_NO)
                ->where('status', BoardPreProduction::STATUS_ACTIVE)
                ->first();

            if (!$pre_production) {
                throw new \Exception('Board Pre Production Not Found');
            }
            $data['pre_production'] = $pre_production;
            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
