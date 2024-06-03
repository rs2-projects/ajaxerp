<?php

namespace App\Services\Production\BoardPreProduction;

use App\Models\Production\BoardPreProduction;
use App\Models\Production\BoardPreProductionCalculatedPrice;
use App\Models\Production\BoardPreProductionMaterials;
use App\Traits\LatestCalculatedPurchaseCostTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalculateBoardPriceService
{
    use LatestCalculatedPurchaseCostTrait;

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

            $raw_board = BoardPreProductionMaterials::where('board_pre_production_id', $id)
                ->where('deleted', BoardPreProductionMaterials::DELETED_NO)
                ->where('status', BoardPreProductionMaterials::STATUS_ACTIVE)
                ->where('type', BoardPreProductionMaterials::TYPE_RAW_BOARD)
                ->first();

            $paper_up = BoardPreProductionMaterials::where('board_pre_production_id', $id)
                ->where('deleted', BoardPreProductionMaterials::DELETED_NO)
                ->where('status', BoardPreProductionMaterials::STATUS_ACTIVE)
                ->where('type', BoardPreProductionMaterials::TYPE_PAPER_UP)
                ->first();
            
            $paper_down = BoardPreProductionMaterials::where('board_pre_production_id', $id)
                ->where('deleted', BoardPreProductionMaterials::DELETED_NO)
                ->where('status', BoardPreProductionMaterials::STATUS_ACTIVE)
                ->where('type', BoardPreProductionMaterials::TYPE_PAPER_DOWN)
                ->first();


            $data['raw_board_cost'] = $this->getLatestCalculatedPurchaseCost($raw_board->product_material_id);
            $data['paper_up_cost'] = $this->getLatestCalculatedPurchaseCost($paper_up->product_material_id);
            $data['paper_down_cost'] = $this->getLatestCalculatedPurchaseCost($paper_down->product_material_id);

         
            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function storeData($request, $id){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $pre_production = BoardPreProduction::where('id', $id)
                ->where('deleted', BoardPreProduction::DELETED_NO)
                ->where('status', BoardPreProduction::STATUS_ACTIVE)
                ->first();

            if (!$pre_production) {
                throw new \Exception('Board Pre Production Not Found');
            }

            $landed_cost_excluding_vat = $request->landed_cost_excluding_vat;
            $machine_cost = $request->machine_cost;
            $paper_up_cost = $request->paper_up_cost;
            $plate_up_cost = $request->plate_up_cost;
            $paper_down_cost = $request->paper_down_cost;
            $plate_down_cost = $request->plate_down_cost;

            $vat_percent = $request->vat_percent;
            $retail_percent = $request->retail_percent;
            $discount_percent = $request->discount_percent;

            $total_production_cost_excluding_vat = $landed_cost_excluding_vat + $machine_cost + $paper_up_cost + $plate_up_cost + $paper_down_cost + $plate_down_cost;
            $retail_price = $total_production_cost_excluding_vat + ($total_production_cost_excluding_vat / 100) * $retail_percent;
            $price_ex_vat = $retail_price - ($retail_price / 100) * $vat_percent;
            $discounted_price = $retail_price - ($retail_price / 100) * $discount_percent;

            $calculated_price = BoardPreProductionCalculatedPrice::where('board_pre_production_id', $id)
                ->where('deleted', BoardPreProductionCalculatedPrice::DELETED_NO)
                ->where('status', BoardPreProductionCalculatedPrice::STATUS_ACTIVE)
                ->first();

            if (!$calculated_price) {
                $calculated_price = new BoardPreProductionCalculatedPrice();
                $calculated_price->board_pre_production_id = $id;
                $calculated_price->created_by = auth()->id();
                $calculated_price->created_at = Carbon::now();
            }
            
            $calculated_price->product_material_id = $request->product_material_id;
            $calculated_price->landed_cost_excluding_vat = $landed_cost_excluding_vat;
            $calculated_price->machine_cost = $machine_cost;
            $calculated_price->paper_up_cost = $paper_up_cost;
            $calculated_price->plate_up_cost = $plate_up_cost;
            $calculated_price->paper_down_cost = $paper_down_cost;
            $calculated_price->plate_down_cost = $plate_down_cost;

            $calculated_price->vat_percent = $vat_percent;
            $calculated_price->retail_percent = $retail_percent;
            $calculated_price->discount_percent = $discount_percent;

            $calculated_price->total_production_cost_excluding_vat = $total_production_cost_excluding_vat;
            $calculated_price->retail_price = $retail_price;
            $calculated_price->price_excluding_vat = $price_ex_vat;
            $calculated_price->vat = $retail_price - $price_ex_vat;
            $calculated_price->discount_wholesale = $discounted_price;
            $calculated_price->updated_by = auth()->id();
            $calculated_price->updated_at = Carbon::now();
            $calculated_price->save();

            $pre_production->price_calculated = BoardPreProduction::PRICE_CALCULATED_YES;
            $pre_production->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
