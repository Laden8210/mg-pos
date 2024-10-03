<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseItem;
use App\Models\StockCard;
use App\Models\Supplier;

class InventoryManagement extends Component
{
    use WithPagination;

    public $search;
    public $selectedInventory;
    public $selectedItem = "";
    public $stockCardInventories;
    public $showStockCardModal = false;
    public $selectedItemAdjustment;
    public $quantity;
    public $remarks;
    public $adjustInventory = false;

    public function mount()
    {
        $this->search = '';
        $this->selectedInventory = null;
    }

    public function updatedSelectedItem($value)
    {
        // This method will be called whenever selectedItem changes
        $this->stockCardInventories = StockCard::where('inventoryId', $value)->with('item')->get();


    }

    public function render()
    {
        $supplies = PurchaseOrder::all();
        $supplier = Supplier::all();

        // Load related models with `with()`, aggregate fields with `selectRaw()`
        $inventories = Inventory::with(['item', 'purchaseItems', 'purchaseOrders', 'supplierItem', 'supplier']) // Load relationships
            ->selectRaw('inventoryId, batch, itemID, qtyonhand as total_qtyonhand, original_quantity as total_original_quantity, SupplierId') // Aggregate inventory fields
            ->when($this->search, function ($query) {
                $query->whereHas('purchaseOrders', function ($query) {
                    $query->where('SupplierName', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        foreach ($inventories as $inventory) {
            $this->checkReorderPoint($inventory); // Process reorder point check
        }

        return view('livewire.inventory-management', [
            'inventories' => $inventories, // Pass inventory data
            'supplies' => $supplies, // Pass supplier data
            'supplier' => $supplier, // Pass supplier data
            'stockCardInventories' => $this->stockCardInventories, // Pass stock card inventories
        ]);
    }



    public function updated($propertyName)
    {
        if (in_array($propertyName, ['barcode'])) {
            $this->scanProduct();
        }
    }


    public function checkReorderPoint($inventory)
    {

        $totalQuantity = $inventory->original_quantity;
        $currentQtyOnHand = $inventory->total_qtyonhand;
        $reorderThreshold = $totalQuantity * 0.3;

        if ($currentQtyOnHand <= $reorderThreshold) {
            session()->flash('reorderNotification', 'Low Stock: Item ' . $inventory->item->itemName . ' has reached its reorder point. Only ' . $currentQtyOnHand . ' left.');
            $inventory->status = 'Not Yet';
        } else {
            $inventory->status = ''; // Adjust this value as needed
        }
        $inventory->save();
    }

    public function confirmReorder($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);

        if ($inventory) {
            $purchaseOrder = PurchaseOrder::where('SupplierId', $inventory->itemID)->first();

            if ($purchaseOrder) {
                $this->updatePurchaseOrder($purchaseOrder, $inventory);
            } else {
                $this->createPurchaseOrder($inventory);
            }

            $inventory->status = 'Re-ordered';
            $inventory->save();
            session()->flash('message-status', 'Re-order has been confirmed successfully for Item: ' . $inventory->item->itemName);
        } else {
            session()->flash('message-status', 'Inventory item not found');
        }
    }

    protected function updatePurchaseOrder($inventory)
    {
        if ($inventory->qtyonhand > 0) {
            $purchaseOrder = PurchaseOrder::create([
                'SupplierId' => $inventory->itemID,
                'order_date' => now(),
                'delivery_date' => now()->addDays(7),
                'status' => 'Pending'
            ]);

            PurchaseItem::create([
                'purchase_order_id' => $purchaseOrder->purchase_order_id,
                'itemID' => $inventory->itemID,
                'quantity' => $inventory->qtyonhand,
                'unit_price' => $inventory->item->unitPrice,
                'total_price' => $inventory->qtyonhand * $inventory->item->unitPrice
            ]);

            // Log to StockCard (Quantity In)
            StockCard::create([
                'inventoryId' => $inventory->inventoryId,
                'DateReceived' => now(),
                'QuantityIn' => $inventory->qtyonhand,
                'QuantityOut' => 0,
                'Type' => 'Order',
                'ValueIn' => $inventory->qtyonhand * $inventory->item->unitPrice,
                'Remarks' => 'Received'
            ]);
        }
    }

    protected function createPurchaseOrder($inventory)
    {
        if ($inventory->qtyonhand > 0) {
            $purchaseOrder = PurchaseOrder::create([
                'SupplierId' => $inventory->itemID,
                'order_date' => now(),
                'delivery_date' => now()->addDays(7),
                'status' => 'Pending',
            ]);

            PurchaseItem::create([
                'purchase_order_id' => $purchaseOrder->purchase_order_id,
                'itemID' => $inventory->itemID,
                'quantity' => $inventory->qtyonhand,
                'unit_price' => $inventory->item->unitPrice,
                'total_price' => $inventory->qtyonhand * $inventory->item->unitPrice,
            ]);
        }
    }

    public function cancelReorder($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);
        if ($inventory) {
            // Logic to cancel reorder if needed
            $inventory->status = null; // Adjust as necessary
            $inventory->save();
        }
    }

    public function editInventory($inventoryId)
    {
        $this->selectedInventory = Inventory::find($inventoryId);
    }
    // public function updatedSelectedItems($value) {}
    // public function viewStockCard() {}

    public function logSaleTransaction($inventoryId, $soldQuantity)
    {
        $inventory = Inventory::find($inventoryId);

        if ($inventory) {
            // Update quantity on hand
            $inventory->qtyonhand -= $soldQuantity;
            $inventory->save();

            // Log to StockCard (Quantity Out)
            StockCard::create([
                'inventoryId' => $inventory->inventoryId,
                'DateReceived' => now(),
                'QuantityIn' => 0,
                'QuantityOut' => $soldQuantity,
                'Type' => 'Sales',
                'ValueOut' => $soldQuantity * $inventory->item->unitPrice,
                'Remarks' => 'Send'
            ]);
        }
    }

    public function closeStockModal()
    {
        $this->showStockCardModal = false;
        $this->adjustInventory = false;
    }

    public function viewStockCard()
    {
        $this->showStockCardModal = true;
    }

    public function viewAdjustItem()
    {
        $this->adjustInventory = true;
    }

    public function saveUpdate()
    {
        $this->validate([
            'quantity' => 'required|numeric|min:1',
            'remarks' => 'required'
        ]);
        $inventory = Inventory::where('itemId', $this->selectedItemAdjustment)

            ->where('qtyonhand', '>=', 0)
            ->first();


        if (!$inventory) {
            session()->flash('message-status', 'Inventory item not found');
            return;
        }

        if ($this->remarks == "Send") {
            StockCard::create([
                'inventoryId' => $inventory->inventoryId,
                'DateReceived' => now(),
                'Quantity' => $this->quantity,
                'Type' => 'Sales',
                'ValueOut' => $this->quantity * $inventory->item->unitPrice,
                'Remarks' => $this->remarks,
                'Value' => $this->quantity * $inventory->item->unitPrice,
                'supplierItemID' => $inventory->supplierItem->supplierItemID,
            ]);
            $inventory->qtyonhand =  $inventory->qtyonhand - $this->quantity;
        } else {
            StockCard::create([
                'inventoryId' => $inventory->inventoryId,
                'DateReceived' => now(),
                'Quantity' => $this->quantity,
                'Type' => 'Order',
                'ValueIn' => $this->quantity * $inventory->item->unitPrice,
                'Remarks' => $this->remarks,
                'Value' => $this->quantity * $inventory->item->unitPrice,
                'supplierItemID' => $inventory->supplierItem->supplierItemID,

            ]);
            $inventory->qtyonhand = +$inventory->qtyonhand + $this->quantity;
        }

        $inventory->save();

        $this->showStockCardModal = false;

        session()->flash('message-status', 'Stock Card has been updated successfully');
    }
}
