<?php

namespace App\Services\Showroom;

use App\Models\Showroom\Showroom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShowroomService
{
    public $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // index data
    public function indexData()
    {
        $data = [];
        return $data;
    }
    // index filtered data
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['items'] = Showroom::where('deleted', Showroom::DELETED_NO)
            ->where('status', Showroom::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%')
                        ->orWhere('address', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);
        return $data;
    }
    
    //store showroom data
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $duplicate_check = Showroom::where('name', $request->name)
                ->where('deleted', Showroom::DELETED_NO)
                ->first();
            if (!empty($duplicate_check)) {
                throw new \Exception("Showroom already exists");
            }

            //store data into showrooms table
            $showroom = new Showroom();
            $showroom->name = $request->name;
            $showroom->address = $request->address ?? null;
            $showroom->status = Showroom::STATUS_ACTIVE;
            $showroom->created_by = auth()->id();
            $showroom->created_at = Carbon::now();
            $showroom->updated_by = auth()->id();
            $showroom->updated_at = Carbon::now();
            $showroom->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    //retrieve showroom data for edit
    public function editData($id)
    {
        $data['item'] = Showroom::where('id',$id)
            ->where('deleted',Showroom::DELETED_NO)
            ->where('status',Showroom::STATUS_ACTIVE)
            ->first();
        if (!$data['item']){
            throw new \Exception('Invalid Showroom!');
        }
        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $duplicate_check = Showroom::where('name', $request->name)
                ->where('deleted', Showroom::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();

            if (!empty($duplicate_check)) {
                throw new \Exception("Showroom already exists");
            }

            $showroom = Showroom::where('deleted', Showroom::DELETED_NO)
                ->where('id', $id)
                ->first();

            if(!$showroom){
                throw new \Exception("Showroom not found");
            }
            //UPDATE DATA INTO SHOWROOM TABLE
            $showroom->name = $request->name;
            $showroom->address = $request->address ?? null;
            $showroom->updated_by = auth()->id();
            $showroom->updated_at = Carbon::now();
            $showroom->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    //DELETE SHOWROOM DATA
    public function delete($id)
    {
        $showroom = Showroom::where('id', $id)
            ->where('deleted', Showroom::DELETED_NO)
            ->where('status',Showroom::STATUS_ACTIVE)
            ->first();
        if (!$showroom) {
            throw new \Exception('Invalid Showroom!');
        }
        $showroom->deleted = Showroom::DELETED_YES;
        $showroom->deleted_by = auth()->id();
        $showroom->deleted_at = now();
        $showroom->save();
    }
}
