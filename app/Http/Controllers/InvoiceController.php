<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockCard;
use App\Models\Inventory;

class InvoiceController extends Controller
{
    // protected $printerService;

    // public function __construct(PrinterService $printerService)
    // {
    //     $this->printerService = $printerService;
    // }
    public function printInvoice($items_list, $subtotal, $total, $discount, $amountTendered, $change)
    {
        // Decode the JSON string into a PHP array
        $itemsList = json_decode($items_list, true);

        // Pass the decoded array, total, amount tendered, and change to the view
        $pdf = Pdf::loadView('report.sales-invoice', [
            'items' => $itemsList,
            'subtotal' => $subtotal,
            'total' => $total,
            'discount' => $discount,
            'amountTendered' => $amountTendered,
            'change' => $change
        ]);

        // Download the generated PDF
        return $pdf->download('invoice.pdf');
    }
    public function generateSalesReport()
    {

        $salesData = StockCard::where('Type', 'Sales')
            ->join('inventory', 'stockcard.inventoryId', '=', 'inventory.inventoryId')
            ->join('items', 'inventory.itemID', '=', 'items.itemID')
            ->join('suppliers', 'inventory.SupplierId', '=', 'suppliers.SupplierId')
            ->select([
                'inventory.batch as Batch',
                'items.itemName as ItemName',
                'suppliers.CompanyName as CompanyName',
                'items.description as Description',
                'items.itemCategory as Category',
                'inventory.qtyonhand as QtyOnHand',
                'inventory.expiry_date as ExpirationDate'
            ])
            ->get();

        $pdf = Pdf::loadView('report.salesReport', ['salseStockCard' => $salesData]);

        // Download the generated PDF
        return $pdf->download('sales_report.pdf');
    }
    public function generateInventoryReport()
    {

        $inventoryData = Inventory::select(
            'inventory.inventoryId',
            'inventory.batch',
            'items.itemName',
            'suppliers.CompanyName',
            'items.description',
            'items.itemCategory',
            'inventory.qtyonhand',
            'inventory.date_received',
            'inventory.original_quantity',
            'inventory.status'
        )
            ->join('items', 'inventory.itemID', '=', 'items.itemID')
            ->join('suppliers', 'inventory.SupplierId', '=', 'suppliers.SupplierId')
            ->get();

        $pdf = Pdf::loadView('report.InventoryReport', ['salseStockCard' => $inventoryData]);

        // Download the generated PDF
        return $pdf->download('inventory_report.pdf');
    }

    public function generateReorderListReport()
    {
        $reorderItems = Inventory::with(['item', 'supplier']) // Load item and supplier relationships
            ->get()
            ->filter(function ($inventory) {
                return $inventory->qtyonhand <= $inventory->reorder_point;
            });

        $pdf = Pdf::loadView('report.reorder-list-report', ['reorderItems' => $reorderItems]);

        // Download the generated PDF
        return $pdf->download('reorder_list_report.pdf');
    }
}
