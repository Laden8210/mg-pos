<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "items";
    protected $primaryKey = "itemID";

    protected $fillable = [
        'itemName',
        'itemCategory',
        'barcode',
        'description',
        'unitPrice',
        'sellingPrice',
        'status',
        'vatApplicable',
        'isVatable'
    ];

    // Relationship to Inventory
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    // Search scope for filtering items
    public function scopeSearch($query, $value)
    {
        return $query->where('itemName', 'like', '%' . $value . '%')
            ->orWhere('itemCategory', 'like', '%' . $value . '%')
            ->orWhere('description', 'like', '%' . $value . '%')
            ->orWhere('unitPrice', 'like', '%' . $value . '%')
            ->orWhere('status', 'like', '%' . $value . '%')
            ->orWhere('barcode', 'like', '%' . $value . '%');
    }
}
