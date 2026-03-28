<?php

namespace App\Services\Sales;

use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDesigns;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;

class InvoiceDesignService
{
    // Your code here
    public function uploadDesign($request,$id=null)
    {
        $invoiceId = $id ?? $request->invoice_id;

        //upload design file
        if ($request->hasFile('design') && $request->design!=null) {
            $fileUploadService = new FileUploadService();
            foreach ($request->file('design') as $design){
                $design_name = $design->getClientOriginalName();
                $file_path = $fileUploadService->store($design, 'inventory/invoice',$design_name);
                $file_name = $file_path['name'];
                $file_path = $file_path['path'];
                $design = new InvoiceDesigns();
                $design->invoice_id = $invoiceId;
                $design->design_name = $file_name;
                $design->design = $file_path??null;
                $design->created_by = auth()->id();
                $design->created_at = Carbon::now();
                $design->updated_by = auth()->id();
                $design->updated_at = Carbon::now();
                $design->save();
            }
        }

        if ($invoiceId != null && ($request->hasFile('delivery_receipt_img') || $request->hasFile('gatepass_img'))) {
            $invoice = Invoice::where('id', $invoiceId)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();

            if (!$invoice) {
                throw new \Exception('Invalid Invoice!');
            }

            $fileUploadService = new FileUploadService();

            if ($request->hasFile('delivery_receipt_img')) {
                $file_path = $fileUploadService->update(
                    $request->file('delivery_receipt_img'),
                    'inventory/invoice',
                    $invoice->delivery_receipt_img
                );
                $invoice->delivery_receipt_img = $file_path['path'] ?? null;
            }

            if ($request->hasFile('gatepass_img')) {
                $file_path = $fileUploadService->update(
                    $request->file('gatepass_img'),
                    'inventory/invoice',
                    $invoice->gatepass_img
                );
                $invoice->gatepass_img = $file_path['path'] ?? null;
            }

            $invoice->updated_by = auth()->id();
            $invoice->updated_at = Carbon::now();
            $invoice->save();
        }
    }
}
