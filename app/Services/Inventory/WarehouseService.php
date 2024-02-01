<?php

namespace App\Services\Inventory;

use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use App\Models\Inventory\WarehouseSectionRack;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WarehouseService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $data['warehouses'] = Warehouse::with('sections', 'racks')
            ->where('deleted', Warehouse::DELETED_NO)
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $warehouse = new Warehouse();
            $warehouse->name = $request->name;
            $warehouse->description = $request->description;
            $warehouse->created_at = Carbon::now();
            $warehouse->created_by = auth()->user()->id;
            $warehouse->updated_at = Carbon::now();
            $warehouse->updated_by = auth()->user()->id;
            $warehouse->save();

            $section_name = $request->section_name;
            $subsection = $request->subsection;

            foreach ($section_name as $key => $value) {
                $warehouseSection = new WarehouseSection();
                $warehouseSection->warehouse_id = $warehouse->id;
                $warehouseSection->name = $value;
                $warehouseSection->created_at = Carbon::now();
                $warehouseSection->created_by = auth()->user()->id;
                $warehouseSection->updated_at = Carbon::now();
                $warehouseSection->updated_by = auth()->user()->id;
                $warehouseSection->save();

                foreach ($subsection[$key] as $key2 => $value2) {
                    $warehouseSubsection = new WarehouseSectionRack();
                    $warehouseSubsection->warehouse_id = $warehouse->id;
                    $warehouseSubsection->warehouse_section_id = $warehouseSection->id;
                    $warehouseSubsection->name = $value2;
                    $warehouseSubsection->created_at = Carbon::now();
                    $warehouseSubsection->created_by = auth()->user()->id;
                    $warehouseSubsection->updated_at = Carbon::now();
                    $warehouseSubsection->updated_by = auth()->user()->id;
                    $warehouseSubsection->save();
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function getEditData($id)
    {
        $data['warehouse'] = Warehouse::with('sections', 'racks')
            ->where('deleted', Warehouse::DELETED_NO)
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function update($request, $id)
    {
//        dd($request->all());
        DB::beginTransaction();
        try {
            $warehouse = Warehouse::where('deleted', Warehouse::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$warehouse) {
                throw new \Exception('Warehouse not found');
            }

            $warehouse->name = $request->name;
            $warehouse->description = $request->description;
            $warehouse->updated_at = Carbon::now();
            $warehouse->updated_by = auth()->user()->id;
            $warehouse->save();

            if (is_array($request->section_name) && count($request->section_name) > 0){
                // check if not exist then delete
                $section_ids = [];
                if (isset($request->hidden_section_ids) && $request->hidden_section_ids !=''){
                    $section_ids = $request->hidden_section_ids;
                }

                $deleteSections = WarehouseSection::whereNotIn('id', $section_ids)
                    ->where('warehouse_id', $warehouse->id)
                    ->where('deleted', WarehouseSection::DELETED_NO)
                    ->get();

                if (count($deleteSections) > 0){
                    foreach ($deleteSections as $deleteSection){
                        $deleteSection->deleted = WarehouseSection::DELETED_YES;
                        $deleteSection->deleted_at = Carbon::now();
                        $deleteSection->deleted_by = auth()->user()->id;
                        $deleteSection->save();

                        if ($deleteSection->racks && count($deleteSection->racks) > 0){
                            foreach ($deleteSection->racks as $rack){
                                $rack->deleted = WarehouseSectionRack::DELETED_YES;
                                $rack->deleted_at = Carbon::now();
                                $rack->deleted_by = auth()->user()->id;
                                $rack->save();
                            }
                        }
                    }
                }

                // update or create
                foreach ($request->section_name as $key=>$section){
                    if (isset($request->hidden_section_ids[$key]) && $request->hidden_section_ids[$key] !='') {
                       /* var_dump($request->hidden_section_ids[$key]);*/
                        $warehouseSection = WarehouseSection::where('deleted', WarehouseSection::DELETED_NO)
                            ->where('id', $request->hidden_section_ids[$key])
                            ->first();
                        if ($warehouseSection) {
                            $warehouseSection->name = $section;
                            $warehouseSection->updated_at = Carbon::now();
                            $warehouseSection->updated_by = auth()->user()->id;
                            $warehouseSection->save();

                            $section_rack_ids = [];
                            if (isset($request->hidden_section_rack_ids[$key]) && $request->hidden_section_rack_ids[$key] !=''){
                                $section_rack_ids = $request->hidden_section_rack_ids[$key];
                            }
                            /*dd($section_rack_ids);*/
                            $deleteRacks = WarehouseSectionRack::where('deleted', WarehouseSectionRack::DELETED_NO)
                                ->where('warehouse_section_id', $warehouseSection->id)
                                ->where('warehouse_id', $warehouse->id)
                                ->whereNotIn('id', $section_rack_ids)
                                ->get();
                            /*dd($deleteRacks);*/
                            if (count($deleteRacks) > 0){
                                foreach ($deleteRacks as $deleteRack){
                                    $deleteRack->deleted = WarehouseSectionRack::DELETED_YES;
                                    $deleteRack->deleted_at = Carbon::now();
                                    $deleteRack->deleted_by = auth()->user()->id;
                                    $deleteRack->save();
                                }
                            }

                            if (is_array($request->subsection[$key]) && count($request->subsection[$key]) > 0){
                                foreach ($request->subsection[$key] as $key2=>$subsection){
                                    if ($request->subsection[$key][$key2] !=''){
                                        if (isset($request->hidden_section_rack_ids[$key][$key2]) && $request->hidden_section_rack_ids[$key][$key2] !='') {
                                            $warehouseSectionRack = WarehouseSectionRack::where('deleted', WarehouseSectionRack::DELETED_NO)
                                                ->where('id', $request->hidden_section_rack_ids[$key][$key2])
                                                ->first();
                                            if ($warehouseSectionRack) {
                                                $warehouseSectionRack->name = $subsection;
                                                $warehouseSectionRack->updated_at = Carbon::now();
                                                $warehouseSectionRack->updated_by = auth()->user()->id;
                                                $warehouseSectionRack->save();
                                            }
                                        }else{
                                            $warehouseSectionRack = new WarehouseSectionRack();
                                            $warehouseSectionRack->warehouse_id = $warehouse->id;
                                            $warehouseSectionRack->warehouse_section_id = $warehouseSection->id;
                                            $warehouseSectionRack->name = $subsection;
                                            $warehouseSectionRack->created_at = Carbon::now();
                                            $warehouseSectionRack->created_by = auth()->user()->id;
                                            $warehouseSectionRack->updated_at = Carbon::now();
                                            $warehouseSectionRack->updated_by = auth()->user()->id;
                                            $warehouseSectionRack->save();
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        $warehouseSection = new WarehouseSection();
                        $warehouseSection->warehouse_id = $warehouse->id;
                        $warehouseSection->name = $request->section_name[$key];
                        $warehouseSection->created_at = Carbon::now();
                        $warehouseSection->created_by = auth()->user()->id;
                        $warehouseSection->updated_at = Carbon::now();
                        $warehouseSection->updated_by = auth()->user()->id;
                        $warehouseSection->save();

                        if (is_array($request->subsection[$key]) && count($request->subsection[$key]) > 0){
                            foreach ($request->subsection[$key] as $key2=>$subsection){
                                if ($request->subsection[$key][$key2] !=''){
                                    $warehouseSectionRack = new WarehouseSectionRack();
                                    $warehouseSectionRack->warehouse_id = $warehouse->id;
                                    $warehouseSectionRack->warehouse_section_id = $warehouseSection->id;
                                    $warehouseSectionRack->name = $subsection;
                                    $warehouseSectionRack->created_at = Carbon::now();
                                    $warehouseSectionRack->created_by = auth()->user()->id;
                                    $warehouseSectionRack->updated_at = Carbon::now();
                                    $warehouseSectionRack->updated_by = auth()->user()->id;
                                    $warehouseSectionRack->save();
                                }
                            }
                        }
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function getShowData($id)
    {
        $data['warehouse'] = Warehouse::with('sections', 'racks')
            ->where('deleted', Warehouse::DELETED_NO)
            ->where('id', $id)
            ->first();

        return $data;
    }
    public function delete($id)
    {
        DB::beginTransaction();
        try {

            $whareHouse = Warehouse::where('deleted', Warehouse::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$whareHouse) {
                throw new \Exception('Warehouse not found');
            }

            $whareHouse->deleted = Warehouse::DELETED_YES;
            $whareHouse->deleted_at = Carbon::now();
            $whareHouse->deleted_by = auth()->user()->id;
            $whareHouse->save();

            $sections = WarehouseSection::where('warehouse_id', $whareHouse->id)
                ->where('deleted', WarehouseSection::DELETED_NO)
                ->get();
            if (count($sections) > 0){
                foreach ($sections as $section){
                    $section->deleted = WarehouseSection::DELETED_YES;
                    $section->deleted_at = Carbon::now();
                    $section->deleted_by = auth()->user()->id;
                    $section->save();

                    $racks = WarehouseSectionRack::where('warehouse_section_id', $section->id)
                        ->where('deleted', WarehouseSectionRack::DELETED_NO)
                        ->get();
                    if (count($racks) > 0){
                        foreach ($racks as $rack){
                            $rack->deleted = WarehouseSectionRack::DELETED_YES;
                            $rack->deleted_at = Carbon::now();
                            $rack->deleted_by = auth()->user()->id;
                            $rack->save();
                        }
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

}
