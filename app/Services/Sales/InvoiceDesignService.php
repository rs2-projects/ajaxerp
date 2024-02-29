<?php

namespace App\Services\Sales;

use App\Models\Sales\InvoiceDesigns;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;

class InvoiceDesignService
{
    // Your code here
    public function uploadDesign($request,$id=null)
    {
        //upload design file
        $image_path = null;
        if ($request->hasFile('design') && $request->design!=null) {
            $fileUploadService = new FileUploadService();
            foreach ($request->file('design') as $design){
                $design_name = $design->getClientOriginalName();
                $file_path = $fileUploadService->store($design, 'inventory/invoice',$design_name);
                $file_name = $file_path['name'];
                $file_path = $file_path['path'];
                $design = new InvoiceDesigns();
                if ($id!=null){
                    $design->invoice_id = $id;
                }else{
                    $design->invoice_id = $request->invoice_id;
                }
                $design->design_name = $file_name;
                $design->design = $file_path??null;
                $design->created_by = auth()->id();
                $design->created_at = Carbon::now();
                $design->updated_by = auth()->id();
                $design->updated_at = Carbon::now();
                $design->save();
            }
        }
    }
}
