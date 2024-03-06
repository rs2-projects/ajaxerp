<?php

namespace App\Services\Inventory;

use App\Models\Production\ProductionDispatch;
use Illuminate\Support\Facades\DB;

class ReceiveProductService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $receive_status = $request->status_filtered;

        switch ($receive_status){
            case 'pending':
                return $this->getPendingDispatched($request);
                break;
            case 'partial':
                return $this->getPartialDispatched($request);
                break;
            case 'received':
                return $this->getReceivedDispatched($request);
                break;
        }
    }

    public function getPendingDispatched($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['dispatches'] = ProductionDispatch::where('deleted', ProductionDispatch::DELETED_NO)
            ->where('status', ProductionDispatch::STATUS_ACTIVE)
            ->whereRaw('(dispatched_qty - received_qty) > 0')
            ->whereRaw('received_qty = 0')
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('dispatch_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        $data['view'] = view('inventory.receive-products._index_filtered', $data)->render();
        return $data;
    }

    public function getPartialDispatched($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['dispatches'] = ProductionDispatch::where('deleted', ProductionDispatch::DELETED_NO)
            ->where('status', ProductionDispatch::STATUS_ACTIVE)
            ->whereRaw('(dispatched_qty - received_qty) > 0')
            ->whereRaw('received_qty > 0')
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('dispatch_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        $data['view'] = view('inventory.receive-products._partial_filtered', $data)->render();
        return $data;
    }

    public function getReceivedDispatched($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['dispatches'] = ProductionDispatch::where('deleted', ProductionDispatch::DELETED_NO)
            ->where('status', ProductionDispatch::STATUS_ACTIVE)
            ->whereRaw('(dispatched_qty - received_qty) = 0')
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('dispatch_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        $data['view'] = view('inventory.receive-products._received_filtered', $data)->render();
        return $data;
    }

    public function receiveData($id){
        $dispatch = ProductionDispatch::where('deleted', ProductionDispatch::DELETED_NO)
            ->where('status', ProductionDispatch::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if(!$dispatch){
            throw new \Exception('Data not found');
        }
        $data['dispatch'] = $dispatch;
        return $data;
    }

    public function receiveStoreData($request, $id){
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$pre_production){
                throw new \Exception('Pre Production not found');
            }

            if($request->pre_production_no != $pre_production->pre_production_no){
                throw new \Exception('Invalid QR Code!');
            }

            if($request->dispatched_qty > ($pre_production->estimated_production_qty - $pre_production->dispatched_qty) || $request->dispatched_qty == 0){
                throw new \Exception('Invalid Quantity!');
            }

            $finished_goods_category = FinishedGoodsCategory::find($pre_production->finished_goods_id);
            $finished_good_cateagory_id = $finished_goods_category->id ??0;
            
            $pre_production->dispatched_qty += $request->dispatched_qty;
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = now();
            $pre_production->save();

            if($pre_production->estimated_production_qty - $pre_production->dispatched_qty > 0){
                $pre_production->dispatched_status = PreProduction::DISPATCH_STATUS_PARTIAL;
            }else{
                $pre_production->dispatched_status = PreProduction::DISPATCH_STATUS_DISPATCHED;
            }
            $pre_production->save();

            $dispatch = new ProductionDispatch();
            $dispatch->dispatch_no = '';
            $dispatch->pre_production_no = $pre_production->pre_production_no;
            $dispatch->pre_production_id = $pre_production->id;
            $dispatch->finished_goods_id = $pre_production->finished_goods_id;
            $dispatch->dispatched_qty = $request->dispatched_qty;
            $dispatch->dispatched_by = auth()->user()->id;
            $dispatch->dispatched_at = now();
            $dispatch->created_by = auth()->user()->id;
            $dispatch->created_at = now();
            $dispatch->updated_by = auth()->user()->id;
            $dispatch->updated_at = now();
            $dispatch->save();
            $dispatch->dispatch_no = 1000 + $dispatch->id;
            $dispatch->save();

            $finished_goods = new InventoryFinishedGoods();
            $finished_goods->finished_goods_category_id = $finished_good_cateagory_id;
            $finished_goods->finished_goods_id = $pre_production->finished_goods_id;
            $finished_goods->type = InventoryFinishedGoods::TYPE_IN;
            $finished_goods->reference_type = InventoryFinishedGoods::REFERENCE_TYPE_FROM_PRODUCTION;
            $finished_goods->reference_id = $dispatch->id;
            $finished_goods->quantity = $request->dispatched_qty;
            $finished_goods->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
