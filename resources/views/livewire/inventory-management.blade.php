<div>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h2>Inventory Management</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-top"></div>

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session()->has('reorderNotification'))
                        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <i class="fas fa-exclamation-circle me-2"
                                        style="font-size: 1.5rem; color: #d9534f;"></i>
                                    <strong class="me-auto text-danger">Low Stock Alert</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    {{ session('reorderNotification') }}
                                </div>
                            </div>
                        </div>
                        <script>
                            setTimeout(function() {
                                const toastElement = document.querySelector('.toast');
                                const bsToast = new bootstrap.Toast(toastElement);
                                bsToast.hide();
                            }, 3000); // 3000 milliseconds = 3 seconds
                        </script>
                    @endif

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>

                                <th class="text-center">Item Name</th>
                                <th class="text-center">Company Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">QTY on Hand</th>
                                <th class="text-center">Reorder Point</th>
                                <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventories as $inventory)
                                    <tr>


                                        <td class="text-center">
                                            {{ $inventory->item ? $inventory->item->itemName : 'N/A' }}
                                        </td>
                                        @php

                                            $companyName = '';
                                            foreach ($supplier as $sup) {
                                                if ($sup->SupplierId == $inventory->SupplierId) {
                                                    $companyName = $sup->CompanyName;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <td class="text-center">{{ $companyName ?? 'N/A' }}
                                        </td>

                                        <td class="text-center">
                                            {{ $inventory->item ? $inventory->item->description : 'N/A' }}</td>
                                        <td class="text-center">
                                            {{ $inventory->item ? $inventory->item->itemCategory : 'N/A' }}</td>
                                        <td class="text-center">{{ $inventory->total_qtyonhand }}</td>

                                        <td class="text-center">
                                            @php
                                                // Calculate the reorder point dynamically based on 40% of the qtyonhand
                                                $reorderPoint = $inventory->total_qtyonhand * 0.4;
                                            @endphp

                                            @if ($inventory->total_qtyonhand <= $inventory->reorder_point)
                                                <span class="badge bg-danger">Critical level</span>
                                            @else
                                                <span class="badge bg-success">Sufficient Stock</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                // Calculate the 40% threshold for showing the reorder button
                                                $threshold = $inventory->qtyonhand * 0.4;
                                            @endphp
                                            @if ($inventory->status === 'Not Yet')
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $inventory->inventoryId }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $inventory->inventoryId }}">
                                                    <li><a class="dropdown-item" href="#"
                                                            wire:click.prevent="confirmReorder({{ $inventory->inventoryId }})">Re-order</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"
                                                            wire:click.prevent="cancelReorder({{ $inventory->inventoryId }})">Cancel</a>
                                                    </li>
                                                </ul>
                                            @else
                                                {{ $inventory->status }}
                                                <span>No Action Needed</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No inventories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $inventories->links('pagination::bootstrap-4') }} <!-- Pagination links -->
                    </div>
                    <div class="button-group mt-4">

                        <button type="button" class="btn btn-primary" style="margin-right: 10px;"
                            data-bs-toggle="modal" data-bs-target="#adjustCardModal"
                            wire:click.prevent="viewAdjustItem">Adjust
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#stockCardModal" wire:click.prevent="viewStockCard">View Stock
                                Card</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($adjustInventory)


        <div class="modal fade show" id="adjustCardModal" tabindex="-1" aria-labelledby="stockCardModalLabel"
            aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-sm">
                <form wire:submit.prevent="saveUpdate">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="stockCardModalLabel">Adjust Item</h5>

                            <button type="button" class="btn-close" wire:click="closeStockModal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <select name="" id="" class="form-select "
                                    wire:model="selectedItemAdjustment">

                                    <option value="">Select Item</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->itemID }}">
                                            {{ $inventory->item->itemName }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div>
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" wire:model="quantity">
                            </div>

                            <div>
                                <label for="remarks" class="form-label">Remarks</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Received" name="remarks"
                                        id="flexCheckDefault" wire:model="remarks">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        In
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Send" name="remarks"
                                        id="flexCheckDefault" wire:model="remarks">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Out
                                    </label>
                                </div>
                            </div>



                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeStockModal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @endif

    @if ($showStockCardModal)
        <div class="modal fade show" id="stockCardModal" tabindex="-1" aria-labelledby="stockCardModalLabel"
            aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="stockCardModalLabel">Inventory Management > Stock
                            Card</h5>

                        <button type="button" class="btn-close" wire:click="closeStockModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="form-group w-25 d-flex">
                                <select name="" id="" class="form-select "
                                    wire:model.live="selectedItem">

                                    <option value="">Select Item</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->itemID }}">
                                            {{ $inventory->item->itemName }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>

                            {{--
                            @if ($stockCardInventories)
                                @foreach ($stockCardInventories as $inventory)
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label for="itemId-{{ $inventory->inventoryId }}" class="form-label">Item
                                                ID</label>
                                            <input type="text" class="form-control"
                                                id="itemId-{{ $inventory->inventoryId }}"
                                                value="{{ $inventory->itemID }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="itemName-{{ $inventory->inventoryId }}"
                                                class="form-label">Item Name</label>
                                            <input type="text" class="form-control"
                                                id="itemName-{{ $inventory->inventoryId }}"
                                                value="{{ $inventory->item->itemName ?? 'N/A' }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="CompanyName-{{ $inventory->inventoryId }}"
                                                class="form-label">Company
                                                Name</label>
                                            <input type="text" class="form-control"
                                                id="CompanyName-{{ $inventory->CompanyName }}"
                                                value="{{ $inventory->SupplierId }}" readonly>

                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="barcode-{{ $inventory->inventoryId }}"
                                                class="form-label">Barcode</label>
                                            <input type="text" class="form-control"
                                                id="barcode-{{ $inventory->inventoryId }}"
                                                value="{{ $inventory->item->barcode ?? 'N/A' }}" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="Contact Person-{{ $inventory->inventoryId }}"
                                                class="form-label">ContactPerson</label>
                                            <input type="text" class="form-control"
                                                id="ContactPerson-{{ $inventory->inventoryId }}"
                                                value="{{ $inventory->supplierItemID->ContactPerson ?? 'N/A' }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="Contact Number-{{ $inventory->inventoryId }}"
                                                class="form-label">ContactNumber</label>
                                            <input type="text" class="form-control"
                                                id="ContactNumber-{{ $inventory->inventoryId }}"
                                                value="{{ $inventory->ContactNumber ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif --}}

                            <!-- Inventory Movement Table -->
                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Batch</th>
                                            <th>Barcode</th>
                                            <th>Date</th>
                                            <th>Quantity In</th>
                                            <th>Value In</th>
                                            <th>Quantity Out</th>
                                            <th>Value Out</th>
                                            <th>Expiration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockCardInventories as $stockCard)
                                            @php
                                                // Initialize quantities
                                                $valueIn = 0;
                                                $valueOut = 0;
                                                $totalQuantityIn = 0;
                                                $totalQuantityOut = 0;

                                                // Filter stock by the current stock card's inventoryId
$filteredStock = $stock->where('inventoryId', $stockCard->inventoryId);

// Calculate total Quantity In (assuming 'Remarks' is 'In' for incoming stock)
$totalQuantityIn = $filteredStock
    ->where('Remarks', 'Received')
    ->sum('Quantity');

// Calculate total Quantity Out (assuming 'Remarks' is 'Out' for outgoing stock)
$totalQuantityOut = $filteredStock
    ->where('Remarks', 'Send')
    ->sum('Quantity');

// Calculate the corresponding values if needed (assuming Value corresponds to Quantity)
$valueIn = $filteredStock->where('Remarks', 'Received')->sum('Value'); // Adjust if Value calculation differs
$valueOut = $filteredStock->where('Remarks', 'Send')->sum('Value'); // Adjust if Value calculation differs
                                            @endphp
                                            <tr>
                                                <td>{{ $stockCard->batch }}</td>
                                                <td>{{ $stockCard->item->barcode }}</td>
                                                <td>{{ \Carbon\Carbon::parse($stockCard->date_received)->format('m/d/Y') }}
                                                </td>
                                                <td>{{ $totalQuantityIn }}</td>
                                                <td>₱ {{ $valueIn }}</td>
                                                <td>{{ $totalQuantityOut }}</td>
                                                <td>₱ {{ $valueOut }}</td>
                                                <td>{{ $stockCard->expiry_date }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeStockModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session()->has('message-status'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-info-circle me-2" style="font-size: 1.5rem;"></i>
                <strong class="me-auto">Order Status</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('message-status') }}
            </div>
        </div>
    </div>

    <script>
        // Auto-hide the toast after 2 seconds
        var toastElement = document.querySelector('.toast');
        var toast = new bootstrap.Toast(toastElement); // Initialize Bootstrap toast
        setTimeout(function() {
            toast.hide(); // Use Bootstrap method to hide the toast
        }, 2000);
    </script>
@endif


</div>
