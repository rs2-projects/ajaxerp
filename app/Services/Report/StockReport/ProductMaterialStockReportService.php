<?php

namespace App\Services\Report\StockReport;

use App\Models\Inventory\ProductMaterialStock;
use App\Models\Products\ProductMaterial;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductMaterialStockReportService
{
    private $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // public function indexFilteredData($request)
    // {
    //     $keyword = $request->keyword_filtered;
    //     $date = $request->date;

    //     $query = ProductMaterialStock::with('productMaterial')
    //         ->where('deleted', ProductMaterialStock::DELETED_NO)
    //         ->where('status', ProductMaterialStock::STATUS_ACTIVE)
    //         ->when($date, fn($q) => $q->whereDate('date', '<=', $date))
    //         ->when($keyword, function ($q) use ($keyword) {
    //             $q->whereHas('productMaterial', function ($subQ) use ($keyword) {
    //                 $subQ->where('name', 'like', "%{$keyword}%")
    //                     ->orWhere('code', 'like', "%{$keyword}%");
    //             });
    //         });

    //     $allStocks = $query->get();

    //     $groupedAndTransformed = $allStocks
    //         ->groupBy('product_material_id')
    //         ->map(function ($stocks) {
    //             $firstStock = $stocks->first();
    //             $product = $firstStock->productMaterial;

    //             $totalQty = $stocks->reduce(function ($carry, $item) {
    //                 return $carry + ($item->type === 0 ? $item->quantity : -$item->quantity);
    //             }, 0);

    //             return (object) [
    //                 'id'    => $product->id ?? '-',
    //                 'name'  => $product->name ?? '-',
    //                 'code'  => $product->code ?? '-',
    //                 'available_qty' => $totalQty,
    //                 'wholesale_price' => $product->wholesale_price ?? 0,
    //                 'retail_price' => $product->retail_price ?? 0,
    //             ];
    //         })
    //         ->sortBy('name')
    //         ->values();

    //     $page = LengthAwarePaginator::resolveCurrentPage();
    //     $perPage = $this->paginate_limit;
    //     $currentItems = $groupedAndTransformed->slice(($page - 1) * $perPage, $perPage)->values();

    //     $paginated = new LengthAwarePaginator(
    //         $currentItems,
    //         $groupedAndTransformed->count(),
    //         $perPage,
    //         $page,
    //         ['path' => request()->url(), 'query' => request()->query()]
    //     );

    //     return [
    //         'product_materials' => $paginated
    //     ];
    // }

    public function indexFilteredData($request)
    {
        $data = $this->getFilteredProductMaterialStock($request);
        return ['product_materials' => $data['paginated']];
    }

    public function exportPdf($request)
    {
        return [
            'product_materials' => $this->getFilteredProductMaterialStock($request)['all'],
            'date' => $request->date ? \Carbon\Carbon::parse($request->date)->format('d M, Y') : \Carbon\Carbon::now()->format('d M, Y')
        ];
    }

    private function getFilteredProductMaterialStock($request)
    {
        $keyword = $request->keyword_filtered;
        $date = $request->date;

        $query = ProductMaterialStock::with('productMaterial')
            ->where('deleted', ProductMaterialStock::DELETED_NO)
            ->where('status', ProductMaterialStock::STATUS_ACTIVE)
            ->when($date, fn($q) => $q->whereDate('date', '<=', $date))
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('productMaterial', function ($subQ) use ($keyword) {
                    $subQ->where('name', 'like', "%{$keyword}%")
                        ->orWhere('code', 'like', "%{$keyword}%");
                });
            });

        $allStocks = $query->get();

        $groupedAndTransformed = $allStocks
            ->groupBy('product_material_id')
            ->map(function ($stocks) {
                $firstStock = $stocks->first();
                $product = $firstStock->productMaterial;

                $totalQty = $stocks->reduce(function ($carry, $item) {
                    return $carry + ($item->type === 0 ? $item->quantity : -$item->quantity);
                }, 0);

                return (object) [
                    'id'              => $product->id ?? '-',
                    'name'            => $product->name ?? '-',
                    'code'            => $product->code ?? '-',
                    'available_qty'   => $totalQty,
                    'wholesale_price' => $product->wholesale_price ?? 0,
                    'retail_price'    => $product->retail_price ?? 0,
                ];
            })
            ->sortBy('name')
            ->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $this->paginate_limit;
        $currentItems = $groupedAndTransformed->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $currentItems,
            $groupedAndTransformed->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return [
            'paginated' => $paginated,
            'all'       => $groupedAndTransformed
        ];
    }


    public function indexFilteredDataOld($request)
    {
        $keyword = $request->keyword_filtered;
        $date = $request->date;

        $query = ProductMaterialStock::with('productMaterial')
            ->where('deleted', ProductMaterialStock::DELETED_NO)
            ->where('status', ProductMaterialStock::STATUS_ACTIVE)
            ->when($date, fn($q) => $q->whereDate('date', '<=', $date))
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('productMaterial', function ($subQ) use ($keyword) {
                    $subQ->where('name', 'like', "%{$keyword}%")
                        ->orWhere('code', 'like', "%{$keyword}%");
                });
            });

        $paginated = $query->paginate($this->paginate_limit);

        $groupedAndTransformed = $paginated->getCollection()
            ->groupBy('product_material_id')
            ->map(function ($stocks) {
                $firstStock = $stocks->first();
                $product = $firstStock->productMaterial;

                $totalQty = $stocks->reduce(function ($carry, $item) {
                    return $carry + ($item->type === 0 ? $item->quantity : -$item->quantity);
                }, 0);

                return (object) [
                    'id'    => $product->id ?? '-',
                    'name'  => $product->name ?? '-',
                    'code'  => $product->code ?? '-',
                    'available_qty' => $totalQty,
                    'wholesale_price' => $product->wholesale_price ?? 0,
                    'retail_price' => $product->retail_price ?? 0,
                ];
            })
            ->sortBy('name')
            ->values();

        $paginated->setCollection($groupedAndTransformed);

        return [
            'product_materials' => $paginated
        ];
    }


    // public function indexFilteredData($request)
    // {

    //     $keyword_filtered = $request->keyword_filtered;
    //     $stock_status = $request->stock_filter ?? '';

    //     $data['product_materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
    //         ->where(function ($q) use ($keyword_filtered){
    //             if ($keyword_filtered !=''){
    //                 $q->where('name', 'like', '%'.$keyword_filtered.'%');
    //                 $q->orWhere('code', 'like', '%'.$keyword_filtered.'%');
    //             }
    //         })
    //         ->orderBy('name', 'asc')
    //         ->paginate($this->paginate_limit);

    //     return $data;
    // }

}
