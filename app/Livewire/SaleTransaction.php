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
        if (isset($this->cart[$itemId])) {
            unset($this->cart[$itemId]);
            $this->calculateTotals();
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
