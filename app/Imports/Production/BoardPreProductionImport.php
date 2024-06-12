<?php

namespace App\Imports\Production;

use App\Models\Machine;
use App\Models\Production\BoardPreProduction;
use App\Models\Production\BoardPreProductionMaterials;
use App\Models\Production\ProductionStaff;
use App\Models\Products\BoardEmbossed;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BoardPreProductionImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            // dd($collection);
            $board_category = FinishedGoodsCategory::where('type', FinishedGoodsCategory::TYPE_BOARD)
                ->where('deleted', FinishedGoodsCategory::DELETED_NO)
                ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
                ->first();

            if (empty($board_category)) {
                throw new \Exception("Category not found");
            }
            
            foreach ($collection as $item) {
                if($item[0] != '' && $item[1] !='' && $item[2] !='' && $item[3] !='' && $item[4] !='' 
                    && $item[5] !='' && $item[6] !='' && $item[7] !='' && $item[8] !='' && $item[9] !=''){
                    
                    $check_code = FinishedGoods::where('code', $item[0])
                        ->where('deleted', FinishedGoods::DELETED_NO)
                        ->first();

                    if (!empty($check_code)) {
                        throw new \Exception("Code '{$item[0]}' already exists");
                    }

                    $plate_up_id = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
                        ->where('status', BoardEmbossed::STATUS_ACTIVE)
                        ->where('name', $item[3])
                        ->first();

                    if(!$plate_up_id){
                        throw new \Exception("Plate Up '{$item[3]}' not found");
                    }

                    $plate_down_id = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
                        ->where('status', BoardEmbossed::STATUS_ACTIVE)
                        ->where('name', $item[6])
                        ->first();

                    if(!$plate_down_id){
                        throw new \Exception("Plate Down '{$item[6]}' not found");
                    } 

                    $machine_id = Machine::where('deleted', Machine::DELETED_NO)
                        ->where('status', Machine::STATUS_ACTIVE)
                        ->where('name', $item[2])
                        ->first();

                    if(!$machine_id){
                        throw new \Exception("Machine '{$item[2]}' not found");
                    }

                    $staff_id = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
                        ->where('status', ProductionStaff::STATUS_ACTIVE)
                        ->where('title', $item[9])
                        ->first();

                    if(!$staff_id){
                        throw new \Exception("Production Staff '{$item[9]}' not found");
                    }

                    $raw_board_id = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
                        ->where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('type', ProductMaterial::TYPE_BOARD)
                        ->where('name', $item[1])
                        ->first();

                    if(!$raw_board_id){
                        throw new \Exception("Raw Board '{$item[1]}' not found");
                    }

                    $paper_up_id = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
                        ->where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('type', ProductMaterial::TYPE_PAPER)
                        ->where('name', $item[4])
                        ->first();

                    if(!$paper_up_id){
                        throw new \Exception("Paper Up '{$item[4]}' not found");
                    }

                    $paper_down_id = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
                        ->where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('type', ProductMaterial::TYPE_PAPER)
                        ->where('name', $item[7])
                        ->first();

                    if(!$paper_down_id){
                        throw new \Exception("Paper Down '{$item[7]}' not found");
                    }

                    // create board
                    $board = new FinishedGoods();
                    $board->name = $item[0];
                    $board->type = FinishedGoods::TYPE_BOARD;
                    $board->image = null;
                    $board->finished_goods_category_id = $board_category->id;
                    $board->code = $item[0];
                    $board->description = null;
                    $board->embossed_up = $plate_up_id->id;
                    $board->color_up = null;
                    $board->embossed_down = $plate_down_id->id;
                    $board->color_down = null;
                    $board->created_by = auth()->id();
                    $board->created_at = Carbon::now();
                    $board->updated_by = auth()->id();
                    $board->updated_at = Carbon::now();
                    $board->save();

                    // create pre production
                    $pre_production = new BoardPreProduction();
                    $pre_production->pre_production_no = '';
                    $pre_production->finished_goods_id = $board->id;
                    $pre_production->estimated_quantity = 1;
                    $pre_production->machine_id = $machine_id->id;
                    $pre_production->staff_id = $staff_id->id;
                    $pre_production->note = '';
                    $pre_production->created_by = auth()->user()->id;
                    $pre_production->created_at = Carbon::now();
                    $pre_production->updated_by = auth()->user()->id;
                    $pre_production->updated_at = Carbon::now();
                    $pre_production->save();
                    $pre_production->pre_production_no = 1000 + $pre_production->id;
                    $pre_production->save();

                    // create raw board
                    $wood_category = ProductMaterial::find($raw_board_id->id);
                    $wood = new BoardPreProductionMaterials();
                    $wood->type = BoardPreProductionMaterials::TYPE_RAW_BOARD;
                    $wood->board_pre_production_id = $pre_production->id;
                    $wood->product_material_category_id =$wood_category->product_material_category_id;
                    $wood->product_material_id = $raw_board_id->id;
                    $wood->quantity = 1;
                    $wood->created_by = auth()->user()->id;
                    $wood->created_at = now();
                    $wood->updated_by = auth()->user()->id;
                    $wood->updated_at = now();
                    $wood->save();

                    // create paper up
                    $paper_up_category = ProductMaterial::find($paper_up_id->id);
                    $paper_up = new BoardPreProductionMaterials();
                    $paper_up->type = BoardPreProductionMaterials::TYPE_PAPER_UP;
                    $paper_up->board_pre_production_id = $pre_production->id;
                    $paper_up->product_material_category_id =$paper_up_category->product_material_category_id;
                    $paper_up->product_material_id = $paper_up_id->id;
                    $paper_up->quantity = $item[5];
                    $paper_up->created_by = auth()->user()->id;
                    $paper_up->created_at = now();
                    $paper_up->updated_by = auth()->user()->id;
                    $paper_up->updated_at = now();
                    $paper_up->save();

                    // create paper down
                    $paper_down_category = ProductMaterial::find($paper_down_id->id);
                    $paper_down = new BoardPreProductionMaterials();
                    $paper_down->type = BoardPreProductionMaterials::TYPE_PAPER_DOWN;
                    $paper_down->board_pre_production_id = $pre_production->id;
                    $paper_down->product_material_category_id =$paper_down_category->product_material_category_id;
                    $paper_down->product_material_id = $paper_down_id->id;
                    $paper_down->quantity = $item[8];
                    $paper_down->created_by = auth()->user()->id;
                    $paper_down->created_at = now();
                    $paper_down->updated_by = auth()->user()->id;
                    $paper_down->updated_at = now();
                    $paper_down->save();
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
