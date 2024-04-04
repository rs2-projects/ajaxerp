<?php

namespace App\Traits;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Procurements\AssetProductPurchaseOrder;
use App\Models\Procurements\AssetProductPurchaseRequest;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Production\PreProduction;
use App\Models\Sales\Invoice;
use Illuminate\Support\Facades\DB;

trait DashboardDataTrait
{
    private function totalInvoiceData()
    {
        $data['total_count'] = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->count();
        $data['total_payable_amount'] = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->sum('payable_amount');

        $data['paid_count'] = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('payment_status', '!=', 0)
            ->count();
        $data['total_paid_amount'] = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('payment_status', '!=', 0)
            ->sum('paid_amount');

        return $data;
    }

    public function totalProcurementData()
    {
        $data['product_material_new_purchases'] = ProductMaterialPurchase::where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_NEW)
            ->where('purchase_create_type', ProductMaterialPurchase::PURCHASE_CREATE_TYPE_NEW)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->count();
        $data['product_material_on_process_purchases'] = ProductMaterialPurchase::where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->count();
        $data['asset_new_purchase_request'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_NEW)
            ->count();
        $data['asset_info_submitted_purchase_request'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_INFO_SUBMITTED)
            ->count();
        $data['new_purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_NEW)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->count();
        $data['on_process_purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_ON_PROCESS)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->count();

        return $data;
    }

    public function totalProductionData()
    {

        $data['queue_production'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PENDING)
            ->count();
        $data['on_process_production'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->count();
        $data['completed_production'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_COMPLETED)
            ->count();
        return $data;
    }

    public function cashAndBanks()
    {
        $subCat = AccCoaSubCategory::where('slug', 'cash-and-bank')->first();
        if (empty($subCat)) {
            return [];
        }
        $data = AccCoaAccount::where('acc_coa_sub_category_id', $subCat->id)->take(3)->get();

        return $data;
    }

    public function recentOrders()
    {
        return Invoice::with('customer')
            ->where('deleted', Invoice::DELETED_NO)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->orderBy('id', 'DESC')
            ->take(7)
            ->get();
    }
}



/*
 * SELECT
SUM(payable_amount) as total_payable_amount,
count(id) as total_count
SUM(CASE WHEN payment_status IS NOT 0 THEN 1 ELSE 0)
FROM `invoices`;
*/
