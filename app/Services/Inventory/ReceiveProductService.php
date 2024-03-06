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
            $dispatch = ProductionDispatch::where('deleted', ProductionDispatch::DELETED_NO)
                ->where('status', ProductionDispatch::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$dispatch){
                throw new \Exception('Data not found');
            }

            if($request->pre_production_no != $dispatch->pre_production_no){
                throw new \Exception('Invalid QR Code!');
            }

            if($request->received_qty > ($dispatch->dispatched_qty - $dispatch->received_qty) || $request->received_qty == 0){
                throw new \Exception('Invalid Quantity!');
            }
            
            $dispatch->received_qty += $request->received_qty;
            $dispatch->received_by = auth()->user()->id;
            $dispatch->received_at = now();
            $dispatch->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
