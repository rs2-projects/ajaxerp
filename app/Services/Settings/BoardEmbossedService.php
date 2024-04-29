<?php

namespace App\Services\Settings;

use App\Models\Products\BoardEmbossed;
use App\Services\Common\ImageUploadService;

class BoardEmbossedService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['board_embosseds'] = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
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
        $check_duplicate = BoardEmbossed::where('name', $request->name)
                ->where('deleted', BoardEmbossed::DELETED_NO)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Board Embossed already exists");
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'settings/board-embossed');
            $image_path = $image_path['path'];
        }

        $board_embossed = new BoardEmbossed();
        $board_embossed->name = $request->name;
        $board_embossed->code = $request->code;
        $board_embossed->image = $image_path??null;
        $board_embossed->note = $request->note;
        $board_embossed->created_by = auth()->user()->id;
        $board_embossed->created_at = now();
        $board_embossed->updated_by = auth()->user()->id;
        $board_embossed->updated_at = now();
        $board_embossed->save();
    }

    public function editData($id)
    {
        $data['item'] = BoardEmbossed::where('id', $id)
            ->where('deleted', BoardEmbossed::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Board Embossed not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $board_embossed = BoardEmbossed::where('id', $id)
            ->where('deleted', BoardEmbossed::DELETED_NO)
            ->first();
        if (!$board_embossed) {
            throw new \Exception('Board Embossed not found');
        }

        $check_duplicate = BoardEmbossed::where('name', $request->name)
                ->where('deleted', BoardEmbossed::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Board Embossed already exists");
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'settings/board-embossed');
            $image_path = $image_path['path'];
        }

        $board_embossed->name = $request->name;
        $board_embossed->code = $request->code;
        $board_embossed->image = $image_path?? $board_embossed->image;
        $board_embossed->note = $request->note;
        $board_embossed->updated_by = auth()->user()->id;
        $board_embossed->updated_at = now();
        $board_embossed->save();
    }

    public function delete($id)
    {
        $board_embossed = BoardEmbossed::where('id', $id)
            ->where('deleted', BoardEmbossed::DELETED_NO)
            ->first();
        if (!$board_embossed) {
            throw new \Exception('Board Embossed not found');
        }
        $board_embossed->deleted = BoardEmbossed::DELETED_YES;
        $board_embossed->deleted_by = auth()->user()->id;
        $board_embossed->deleted_at = now();
        $board_embossed->save();
    }
}
