<?php

namespace App\Imports\Inventory;

use App\Models\Products\BoardEmbossed;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PlateImport implements ToCollection, WithStartRow
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
        foreach ($collection as $item) {
            if ($item[1] == '') {
                continue;
            }
            //check board embossed name unique
            $board_embossed = BoardEmbossed::where('name', $item[1])
                ->where('deleted', BoardEmbossed::DELETED_NO)
                ->where('status', BoardEmbossed::STATUS_ACTIVE)
                ->first();

            if (!empty($board_embossed)) {
                throw new \Exception("Plate '{$item[1]}' already exists");
            }

            $check_code = BoardEmbossed::where('code', $item[0])
                ->where('deleted', BoardEmbossed::DELETED_NO)
                ->where('status', BoardEmbossed::STATUS_ACTIVE)
                ->first();
            
            if (!empty($check_code)) {
                throw new \Exception("Code '{$item[0]}' already exists");
            }
            
            //store board embossed
            BoardEmbossed::create([
                'name' => $item[1],
                'production_cost' => $item[2],
                'code' => $item[0],
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
