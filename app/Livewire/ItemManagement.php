<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use PDO;

class ItemManagement extends Component
{

    public $name;
    public $category;
    public $barcode;
    public $description;
    public $unitPrice;
    public $isVatable;
    public $search = '';
    public $selectedItem;
    public function render()
    {
        return view('livewire.item-management',
            [
                'items' => Item::search($this->search)->paginate(10),
                'vatable' => Item::where('vatApplicable', 1)->get(),
            ]
        );
    }
    public function save()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'barcode' => 'nullable|string|size:12',
            'description' => 'nullable|string|max:500',
            'unitPrice' => 'required|numeric|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'category.required' => 'The category field is required.',
            'category.string' => 'The category must be a string.',
            'category.max' => 'The category may not be greater than 255 characters.',
            'barcode.required' => 'The barcode field is required.',
            'barcode.string' => 'The barcode must be a string.',
            'barcode.size' => 'The barcode must be exactly 12 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'unitPrice.required' => 'The unit price field is required.',
            'unitPrice.numeric' => 'The unit price must be a number.',
            'unitPrice.min' => 'The unit price must be at least 0.',
        ]);


        $this->validate([
            'name' => 'required',
            'category' => 'required',
            'barcode' => 'required',
            'description' => 'required',
            'unitPrice' => 'required',
        ]);

        Item::create([
            'itemName' => $this->name,
            'itemCategory' => $this->category,
            'barcode' => $this->barcode,
            'description' => $this->description,
            'unitPrice' => $this->unitPrice,
            'sellingPrice' => $this->unitPrice * 1.2, // calculate selling price as 20% more than unit price
            'status' => 'Active',
            'isVatable' => $this->isVatable,
        ]);


        $this->name = '';
        $this->category = '';
        $this->barcode = '';
        $this->description = '';
        $this->unitPrice = '';
        session()->flash('message', 'Item successfully added.');
    }

    public function selectItem($id)
    {
        $item = Item::find($id);
        $this->selectedItem = $item;
        $this->name = $item->itemName;
        $this->category = $item->itemCategory;
        $this->barcode = $item->barcode;
        $this->description = $item->description;
        $this->unitPrice = $item->unitPrice;
    }

    public function update(){
        $this->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'barcode' => 'required|string|size:12',
            'description' => 'nullable|string|max:500',
            'unitPrice' => 'required|numeric|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'category.required' => 'The category field is required.',
            'category.string' => 'The category must be a string.',
            'category.max' => 'The category may not be greater than 255 characters.',
            'barcode.required' => 'The barcode field is required.',
            'barcode.string' => 'The barcode must be a string.',
            'barcode.size' => 'The barcode must be exactly 12 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'unitPrice.required' => 'The unit price field is required.',
            'unitPrice.numeric' => 'The unit price must be a number.',
            'unitPrice.min' => 'The unit price must be at least 0.',
        ]);


        $this->validate([
            'name' => 'required',
            'category' => 'required',
            'barcode' => 'required',
            'description' => 'required',
            'unitPrice' => 'required',
        ]);

        $item = Item::find($this->selectedItem->itemID);
    $item->update([
        'itemName' => $this->name,
        'itemCategory' => $this->category,
        'barcode' => $this->barcode,
        'description' => $this->description,
        'unitPrice' => $this->unitPrice,
        'sellingPrice' => $this->unitPrice * 1.2, // calculate selling price as 20% more than unit price
        'status' => 'Active',
        'isVatable' => $this->isVatable == null,
    ]);
        session()->flash('message', 'Item successfully update.');
    }

    public function delete(){
        $item = Item::find($this->selectedItem->itemID);
        $item->delete();
        session()->flash('message', 'Item successfully deleted.');

    }
}
