<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\ProductMaterial\StorePurchaseReqeust;
use App\Http\Requests\Procurement\ProductMaterial\UpdatePurchaseReqeust;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Services\Procurement\ProductMaterial\ProductMaterialPurchaseService;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use PDF;

class ProductMaterialPurchaseController extends BackendController
{
    private ProductMaterialPurchaseService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material Purchase');

        $this->service = new ProductMaterialPurchaseService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Purchase");
        $this->setActiveMenu('procurement.product-material-purchase.index');
        $data = $this->service->indexData();
        return  $this->view('procurement.product-material-purchase.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        try {
            $data = $this->service->indexFilteredData($request);

            return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $this->setPageTitle("Product Material Purchase Details");
            $this->setActiveMenu('procurement.product-material-purchase.index');
            $data = $this->service->detailsData($id);
            //dd($data);
            return $this->view('procurement.product-material-purchase.show')->with($data);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function create()
    {
        $this->setPageTitle("New Purchase Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');
        $data = $this->service->createData();
        return $this->view('procurement.product-material-purchase.create')->with($data);
    }

    public function store(StorePurchaseReqeust $reqeust)
    {
        /*dd($reqeust->all());*/
        try {
            $this->service->store($reqeust);

            return $this->returnAjaxSuccess([], 'Purchase Order Created Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->setPageTitle("Edit Purchase Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        $data = $this->service->editData($id);

        return $this->view('procurement.product-material-purchase.edit')->with($data);
    }


    public function getEditPurchaseData(Request $request, $id)
    {
        $data = $this->service->getEditPurchaseData($request, $id);

        return response()->json($data);
    }

    public function update(UpdatePurchaseReqeust $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return $this->returnAjaxSuccess([], 'Purchase Order Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function createRevisedOrder($id)
    {
        $this->setPageTitle("Revised Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        $data = $this->service->createRevisedOrderData($id);

        return $this->view('procurement.product-material-purchase.create_revised_order')->with($data);
    }

    public function storeRevisedOrder(UpdatePurchaseReqeust $reqeust, $id)
    {
        try {
            $this->service->storeRevisedOrderData($reqeust, $id);

            return $this->returnAjaxSuccess([], 'Revised Order Created Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function createBackOrder($id)
    {
        $this->setPageTitle("Back Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        $data = $this->service->createBackOrderData($id);

        return $this->view('procurement.product-material-purchase.create_back_order')->with($data);
    }

    public function storeBackOrder(UpdatePurchaseReqeust $reqeust, $id)
    {
        try {
            $this->service->storeBackOrderData($reqeust, $id);

            return $this->returnAjaxSuccess([], 'Back Order Created Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->service->deleteData($id);

            return $this->returnAjaxSuccess([], 'Purchase Order Deleted Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    public function statusUpdate($id, $status)
    {
        try {
            $this->service->statusUpdate($id, $status);

            return $this->returnAjaxSuccess([], 'Status Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function getAllProductMaterials(Request $request)
    {
        $data = $this->service->getAllProductMaterials($request);

        return response()->json($data);
    }

    public function getAllTaxes(Request $request)
    {
        $data = $this->service->getAllTaxes($request);

        return response()->json($data['vat_taxes']);
    }

    public function getAllSuppliers(Request $request)
    {
        $data = $this->service->getAllSuppliers($request);

        return response()->json($data['suppliers']);
    }

    public function printBarcodeData($id, $type)
    {
        try {
            $data = $this->service->printBarcodeData($id, $type);
            $view = $this->view('procurement.product-material-purchase.print-barcode._print_barcode_modal_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function printBarcode(Request $request){
        try {
            $purchaseDetailsIdsWithQty = [];
            foreach ($request->purchase_details_id as $index => $purchaseDetailId) {
                if (isset($request->qty[$index])) {
                    $purchaseDetailsIdsWithQty[$purchaseDetailId] = $request->qty[$index];
                }
            }
            $purchae_details = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                ->whereIn('id', array_keys($purchaseDetailsIdsWithQty))
                ->get()
                ->map(function ($item) use ($purchaseDetailsIdsWithQty) {
                    return (object) [
                        'id' => $item['id'],
                        'barcode' => $item['barcode'],
                        'color' => $item['color'],
                        'qty' => $purchaseDetailsIdsWithQty[$item['id']],
                        'unit_price' => $item['unit_price'],
                        'name' => $item->productMaterial->name,
                    ];
                });

                if (empty($purchae_details)) {
                    return redirect()->back()->with(['failed' => 'Invalid Products!']);
                }

            $code_generator = new BarcodeGeneratorPNG();
            if($request->type == 'printer'){
                return view('procurement.product-material-purchase.print-barcode.print-barcode-printer', compact(
                    'code_generator',
                    'purchae_details',
                ));
            }

            $pdf = PDF::loadView('procurement.product-material-purchase.print-barcode.print-barcode-pdf', compact(
                'code_generator',
                'purchae_details'
            ));
            $pdf->setPaper('a4');
            $pdf->setOrientation('portrait');
            $pdf->setOption('footer-html', "Powered By: Retinasoft | Hotline: +8801877756677 | http://www.retinasoft.com.bd");
            return $pdf->inline();

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
    }
}
