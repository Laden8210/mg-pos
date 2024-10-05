<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Inventory;

class SaleTransaction extends Component
{
    public $items = [];
    public $transactionNumber = 1;
    public $cart = [];
    public $subtotal = 0;
    public $total = 0;
    public $discount = 0;
    public $discountPercentage = 0;
    public $amountTendered = 0;
    public $change = 0;

    public $searchTerm = '';
    public $searchResults = [];
    public $selectedItems = [];

    public $inventoryDetails = [];
    public $showInventory = false;

    public $barcode;

    public $oldBarcode;

    public $selectedItem;

    public $itemQuantity = 0;

    public function mount()
    {
        $this->items = Item::all();
        $this->fetchAllInventory();
        $this->restoreInventory();
    }

    public function fetchAllInventory()
    {
        $this->inventoryDetails = Inventory::with('item')->get();
    }

    public function toggleInventory()
    {
        $this->showInventory = !$this->showInventory;
        if ($this->showInventory) {
            $this->fetchAllInventory();
        }
    }



    public function updated($propertyName)
    {
        if (in_array($propertyName, ['barcode'])) {
            $this->scanProduct();
        }
    }

    public function scanProduct()
    {

        $item = Inventory::with('item')
            ->when($this->barcode, function ($query) {
                $query->whereHas('item', function ($q) {
                    $q->where('barcode', $this->barcode);
                });
            })->first();

        $this->oldBarcode = $this->barcode;

        if (!$item) {
            session()->flash('error', 'Item not found.');
            sleep(1);
            $this->barcode = "";

            return;
        }

        if ($item->qtyonhand <= 0) {
            session()->flash('error', 'Item is out of stock.');
            $this->barcode = "";

            return;
        }

        // Check if item is already in the cart
        if (isset($this->cart[$item->itemId])) {
            if ($this->cart[$item->itemId]['quantity'] < $item->qtyonhand) {
                $this->cart[$item->itemId]['quantity']++;
                $this->cart[$item->itemId]['subtotal'] = $this->cart[$item->itemId]['quantity'] * $this->cart[$item->itemId]['price'];
            } else {
                session()->flash('error', 'Not enough stock available.');
                $this->barcode = "";

                return;
            }
        } else {
            // Add new item to cart
            $this->cart[$item->itemId] = [
                'id' => $item->itemID,
                'name' => $item->item->itemName,
                'price' => $item->item->unitPrice,
                'quantity' => 1,
                'subtotal' => $item->item->unitPrice,
            ];
        }

        // Clear the barcode input field
        $this->barcode = "";

        // Recalculate totals for the cart
        $this->calculateTotals();
    }

    public function addToCart($itemId)
    {
        $item = Inventory::with('item')->find($itemId);

        if (!$item) {
            session()->flash('error', 'Item not found.');
            return;
        }

        if ($item->qtyonhand <= 0) {
            session()->flash('error', 'Item is out of stock.');
            return;
        }

        // Check if item is already in the cart
        if (isset($this->cart[$itemId])) {
            if ($this->cart[$itemId]['quantity'] < $item->qtyonhand) {
                $this->cart[$itemId]['quantity']++;
            } else {
                session()->flash('error', 'Not enough stock available.');
                return;
            }
        } else {
            $this->cart[$itemId] = [
                'id' => $item->itemID,
                'name' => $item->item->itemName,
                'price' => $item->item->unitPrice,
                'quantity' => 1,
                'subtotal' => $item->item->unitPrice,
            ];
        }

        // Update inventory quantity

        $item->save();

        $this->calculateTotals();
        $this->updateCartSubtotal();
    }

    public function removeFromCart($itemId)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $itemId) {
                unset($this->cart[$key]);
                break;
            }
        }


        $this->cart = array_values($this->cart);

        $this->calculateTotals();
    }

    public $temporaryInventoryDepletion = [];

    public function preparePrint()
    {
        // Encode the cart items to JSON
        $cartItems = urlencode(json_encode($this->cart));

        // Deplete inventory for items in the cart
        foreach ($this->cart as $cartItem) {
            $item = Inventory::where('itemID', $cartItem['id'])->first();
            if ($item) {
                // Decrease the quantity
                $item->qtyonhand -= $cartItem['quantity'];
                $item->save();

                // Store the change for potential restoration
                $this->temporaryInventoryDepletion[$item->itemID] = $cartItem['quantity'];
            }
        }

        $this->storeTransaction();

        // Redirect to the print-receipt route with encoded parameters
        return redirect()->route('print-reciept', [
            'items' => $cartItems,  // Encoded JSON string for the items
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'discount' => $this->discount ?? 0,
            'amountTendered' => $this->amountTendered,
            'change' => $this->change,
            $this->resetTransaction()
        ]);

    }
    protected function storeTransaction()
    {
        // Save the transaction details to the database
        Transaction::create([
            'transaction_number' => $this->transactionNumber,
            'items' => json_encode($this->cart), // You can customize this as needed
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'discount' => $this->discount,
            'amount_tendered' => $this->amountTendered,
            'change' => $this->change,
        ]);

        // Increment the transaction number for the next transaction
        $this->transactionNumber++;
        $this->resetTransaction();
    }

    public function restoreInventory()
    {
        foreach ($this->temporaryInventoryDepletion as $itemId => $quantity) {
            $item = Inventory::where('itemID', $itemId)->first();
            if ($item) {
                // Restore the quantity
                $item->qtyonhand += $quantity;
                $item->save();
            }
        }

        // Clear the temporary inventory depletion tracking
        $this->temporaryInventoryDepletion = [];
    }

    public function resetTransaction()
    {
        // Clear the cart
        $this->cart = [];

        // Reset any other related variables
        $this->cart = [];
        $this->subtotal = 0;
        $this->total = 0;
        $this->discount = 0;
        $this->discountPercentage = 0;
        $this->amountTendered = 0;
        $this->change = 0;

        // Optionally reset any session messages
        session()->flash('message', 'Transaction has been reset.');
    }

    public function selectItemToCart($itemId)
    {

        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $itemId) {
                $this->selectedItem = $item;
                $this->itemQuantity = $item['quantity'];

                break;
            }
        }
    }


    public function updateQuantityItemCart()
    {
        foreach ($this->cart as $key => $cartItem) {
            if ($cartItem['id'] == $this->selectedItem['id']) {

                $inventoryItem = Inventory::with('item')
                    ->where('itemID', $this->selectedItem['id'])
                    ->first();

                if (!$inventoryItem) {
                    session()->flash('error', 'Item not found in inventory.');
                    return;
                }


                if ($this->itemQuantity <= $inventoryItem->qtyonhand) {

                    $this->cart[$key]['quantity'] = $this->itemQuantity;


                    $this->cart[$key]['subtotal'] = $this->cart[$key]['quantity'] * $this->cart[$key]['price'];


                    $this->calculateTotals();
                    $this->updateCartSubtotal();


                    session()->flash('message', 'Quantity updated successfully.');
                } else {

                    session()->flash('error', 'Not enough stock available.');
                }

                break;
            }
        }
    }






    public function updateQuantity($itemId, $quantity)
    {
        if (isset($this->cart[$itemId]) && $quantity > 0) {
            $this->cart[$itemId]['quantity'] = $quantity;
            $this->cart[$itemId]['subtotal'] = $this->cart[$itemId]['price'] * $quantity;
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {

        $this->subtotal = 0;

        // Calculate subtotal based on price and quantity for each cart item
        foreach ($this->cart as $cartItem) {
            $this->subtotal += $cartItem['price'] * $cartItem['quantity'];
        }

        $this->discountPercentage = $this->discountPercentage ?? 0;
        $this->discount = ($this->subtotal * $this->discountPercentage) / 100;


        $this->total = $this->subtotal - $this->discount;


        $this->change = $this->amountTendered - $this->total;
    }

    public function applyDiscount()
    {
        // Validate discount percentage
        if ($this->discountPercentage >= 0 && $this->discountPercentage <= 100) {
            // Recalculate the totals based on the discount
            $this->calculateTotals();
        } else {
            session()->flash('error', 'Invalid discount percentage.');
        }

    }

    public function updateAmountTendered($amount)
    {
        $this->amountTendered = $amount;
        $this->calculateTotals();
    }

    public function updateCartSubtotal()
    {
        foreach ($this->cart as $index => $item) {
            // Calculate subtotal (price * quantity) and store it in the cart array
            $this->cart[$index]['subtotal'] = $item['price'] * $item['quantity'];
        }

        // Optionally call the method to calculate the grand total or other totals
        $this->calculateTotals();
    }


    public function render()
    {
        return view('livewire.cashier.sale-transaction');
    }
}
