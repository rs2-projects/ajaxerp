<?php

namespace App\Services\Inventory;

use App\Models\Products\BoardColor;
use App\Models\Products\BoardEmbossed;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BoardsService
{
    public function __construct()
    {
         $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        //finished goods category
        /*$data['finished_good_categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status',FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('name','asc')
            ->get();*/

        $data['board_colors'] = BoardColor::where('deleted', BoardColor::DELETED_NO)
            ->where('status', BoardColor::STATUS_ACTIVE)
            ->orderBy('name','asc')
            ->get();

        $data['board_embosseds'] = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
            ->where('status', BoardEmbossed::STATUS_ACTIVE)
            ->orderBy('name','asc')
            ->get();

        return $data;
    }
    //finished good filtered data
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_filtered = $request->category_filtered;

        $data['boards'] = FinishedGoods::with('finishedGoodsCategory', 'embossed_ups', 'embossed_downs', 'color_ups', 'color_downs')
            ->where('deleted', FinishedGoods::DELETED_NO)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                    $q->orWhere('code', 'like', '%'.$keyword_filtered.'%');

                }
            })
            ->where(function ($q) use ($category_filtered){
                if ($category_filtered !=''){
                    $q->where('finished_goods_category_id', $category_filtered);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);
        return $data;
    }

    public function storeData($request)
    {
        try {

            $check_code = FinishedGoods::where('code', $request->code)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();

            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'inventory/finished-goods');
                $image_path = $image_path['path'];
            }

            $finished_good = new FinishedGoods();
            $finished_good->name = $request->name;
            $finished_good->type = FinishedGoods::TYPE_BOARD;
            $finished_good->image = $image_path??null;
            $finished_good->finished_goods_category_id = $request->finished_good_category_id;
            $finished_good->code = $request->code;
            $finished_good->description = $request->description;
            $finished_good->embossed_up = $request->embossed_up;
            $finished_good->color_up = $request->color_up;
            $finished_good->embossed_down = $request->embossed_down;
            $finished_good->color_down = $request->color_down;
            $finished_good->created_by = auth()->id();
            $finished_good->created_at = Carbon::now();
            $finished_good->updated_by = auth()->id();
            $finished_good->updated_at = Carbon::now();
            $finished_good->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function editData($id)
    {
        try {
            $data['finished_good'] = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$data['finished_good']) {
                throw new \Exception('Boards not found');
            }

            $data['finished_good_categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status',FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('name','asc')
            ->get();

            $data['board_colors'] = BoardColor::where('deleted', BoardColor::DELETED_NO)
                ->where('status', BoardColor::STATUS_ACTIVE)
                ->orderBy('name','asc')
                ->get();

            $data['board_embosseds'] = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
                ->where('status', BoardEmbossed::STATUS_ACTIVE)
                ->orderBy('name','asc')
                ->get();

            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateData($request, $id)
    {
        try {

            $finished_good = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$finished_good) {
                throw new \Exception('Boards not found');
            }

            $check_code = FinishedGoods::where('code', $request->code)
                ->where('id', '!=', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = $finished_good->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'inventory/finished-good', $finished_good->image);
                $image_path = $image_path['path'];
            }

            $finished_good->name = $request->name;
            $finished_good->type = FinishedGoods::TYPE_BOARD;
            $finished_good->image = $image_path??$finished_good->image;
            $finished_good->finished_goods_category_id = $request->finished_good_category_id;
            $finished_good->warehouse_id = $request->warehouse_id;
            $finished_good->code = $request->code;
            $finished_good->description = $request->description;
            $finished_good->embossed_up = $request->embossed_up;
            $finished_good->color_up = $request->color_up;
            $finished_good->embossed_down = $request->embossed_down;
            $finished_good->color_down = $request->color_down;
            $finished_good->updated_by = auth()->id();
            $finished_good->updated_at = Carbon::now();
            $finished_good->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        // return $finished_good;
    }

    public function deleteData($id)
    {
        try {
            $finished_good = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$finished_good) {
                throw new \Exception('Boards not found');
            }
            $finished_good->deleted = FinishedGoods::DELETED_YES;
            $finished_good->deleted_by = auth()->id();
            $finished_good->deleted_at = now();
            $finished_good->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
