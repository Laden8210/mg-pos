<div>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h2>Inventory Management</h2>
            <div class="card">
                <div class="card-body">
                    <h3>Cart</h3>
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $cartItem)
                                    <tr>
                                        <td>{{ $cartItem['name'] }}</td>
                                        <td>P {{ number_format($cartItem['price'], 2) }}</td>
                                        <td>
                                            <input type="number" wire:model.defer="cart.{{ $cartItem['id'] }}.quantity"
                                                wire:change="updateQuantity({{ $cartItem['id'] }}, $event.target.value)"
                                                class="form-control" style="width: 80px;" min="1" value="{{ $cartItem['quantity'] }}">
                                        </td>
                                        <td>P {{ number_format($cartItem['subtotal'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button wire:click="toggleInventory" class="btn btn-primary">
                            {{ $showInventory ? 'Hide Inventory' : 'View Inventory' }}
                        </button>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>SubTotal</label>
                                            <input type="text" class="form-control" value="P {{ number_format($subtotal, 2) }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Total</label>
                                            <input type="text" class="form-control" value="P {{ number_format($total, 2) }}" readonly>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <label>Discount</label>
                                            <input type="number" wire:model="discount"
                                                wire:change="applyDiscount($event.target.value)" class="form-control"
                                                placeholder="Enter Discount" min="0" step="0.01">
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <label>Amount Tendered</label>
                                            <input type="number" wire:model="amountTendered"
                                                wire:change="updateAmountTendered($event.target.value)" class="form-control"
                                                placeholder="Enter Amount Tendered" min="0" step="0.01">
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <label>Change</label>
                                            <input type="text" class="form-control" value="P {{ number_format($change, 2) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-danger btn-lg w-100 mb-2">Void</button>
                                    <button class="btn btn-success btn-lg w-100">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($showInventory)
                        <div class="mt-3">
                            <h4>Inventory</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Quantity Available</th>
                                            <th>Add to Cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inventoryDetails as $item)
                                            <tr>
                                                <td>{{ $item->itemID }}</td>
                                                <td>{{ $item->item->itemName }}</td>
                                                <td>P {{ number_format($item->item->unitPrice, 2) }}</td>
                                                <td>{{ $item->qtyonhand }}</td>
                                                <td>
                                                    <button wire:click="addToCart({{ $item->inventoryId }})" class="btn btn-success btn-sm">Add to Cart</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

