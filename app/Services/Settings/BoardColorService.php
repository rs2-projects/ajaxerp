<?php

namespace App\Services\Settings;

use App\Models\Products\BoardColor;

class BoardColorService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['board_colors'] = BoardColor::where('deleted', BoardColor::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        $check_duplicate = BoardColor::where('name', $request->name)
                ->where('deleted', BoardColor::DELETED_NO)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Board Color already exists");
        }

        $board_color = new BoardColor();
        $board_color->name = $request->name;
        $board_color->color_code = $request->color_code;
        $board_color->created_by = auth()->user()->id;
        $board_color->created_at = now();
        $board_color->updated_by = auth()->user()->id;
        $board_color->updated_at = now();
        $board_color->save();
    }

    public function editData($id)
    {
        $data['item'] = BoardColor::where('id', $id)
            ->where('deleted', BoardColor::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Board Color not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $board_color = BoardColor::where('id', $id)
            ->where('deleted', BoardColor::DELETED_NO)
            ->first();
        if (!$board_color) {
            throw new \Exception('Board Color not found');
        }

        $check_duplicate = BoardColor::where('name', $request->name)
                ->where('deleted', BoardColor::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Board Color already exists");
        }
        $board_color->name = $request->name;
        $board_color->color_code = $request->color_code;
        $board_color->updated_by = auth()->user()->id;
        $board_color->updated_at = now();
        $board_color->save();
    }

    public function delete($id)
    {
        $board_color = BoardColor::where('id', $id)
            ->where('deleted', BoardColor::DELETED_NO)
            ->first();
        if (!$board_color) {
            throw new \Exception('Board Color not found');
        }
        $board_color->deleted = BoardColor::DELETED_YES;
        $board_color->deleted_by = auth()->user()->id;
        $board_color->deleted_at = now();
        $board_color->save();
    }
}
