<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Inventory;

class SaleTransaction extends Component
{
    public $items = [];
    public $cart = [];
    public $subtotal = 0;
    public $total = 0;
    public $discount = 0;
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

        sleep(2);
        $item = Inventory::with('item')
            ->when($this->barcode, function ($query) {
                $query->whereHas('item', function ($q) {
                    $q->where('barcode', $this->barcode);
                });
            })->first();

        $this->oldBarcode = $this->barcode;

        if (!$item) {
            session()->flash('error', 'Item not found.');
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
        $item->qtyonhand--;
        $item->save();

        $this->calculateTotals();
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


    public function selectItemToCartFuck($itemId)
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
        $this->subtotal = array_sum(array_column($this->cart, 'subtotal'));
        $this->total = $this->subtotal - $this->discount;
        $this->change = $this->amountTendered - $this->total;
    }

    public function applyDiscount($discount)
    {
        $this->discount = $discount;
        $this->calculateTotals();
    }

    public function updateAmountTendered($amount)
    {
        $this->amountTendered = $amount;
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.cashier.sale-transaction');
    }
}
