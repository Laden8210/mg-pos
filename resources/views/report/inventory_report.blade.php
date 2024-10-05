@extends('layout')

@section('title', 'Inventory Report')

@section('content')
<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <!-- Report Title -->
      <h2>Inventory Report</h2>

      <!-- Header with Logo and Business Information -->
      <div class="card mt-2">
         <div class="card-body">
            <div class="main-content">
               <div class="d-flex justify-content-between align-items-center">
                  <!-- Logo Section -->
                  <div class="col-lg-1 col-md-6 col-12">
                     <a>
                        <img src="{{ asset('img/MG.png') }}" alt="product" class="logo">
                     </a>
                  </div>
                  <!-- Business Information Section -->
                  <div class="col-lg-11 col-md-6 col-12">
                     <h5 class="app-brand-text menu-text fw-bolder">MG MINI MART</h5>
                     <p>Brgy. Tinongcop, Tantangan, South Cot. <br>Manager: Glo-Ann Panes</p>
                  </div>
                  <!-- Date Picker & Month Filter -->
                  <div>
                     <input type="date" value="{{ date('Y-m-d') }}" class="form-control mb-2">
                     <select class="form-control">
                        <option>March - 2024</option> <!-- You can dynamically load months if needed -->
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Inventory Report Table -->
      <div class="card mt-2">
         <div class="card-body">
            <div class="table-responsive">
               <table class="table datanew">
                  <thead>
                     <tr>
                        <th>Inventory ID</th>
                        <th>Batch</th>
                        <th>Item Name</th>
                        <th>Company Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Qty On Hand</th>
                        <th>Date Received</th>
                        <th>Original Qty</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($salseStockCard as $inventory)
                   <tr>
                     <td>{{ $inventory->inventoryId }}</td>
                     <td>{{ $inventory->batch }}</td>
                     <td>{{ $inventory->item->itemName ?? 'N/A' }}</td> <!-- Accessing itemName via relationship -->
                     <td>{{ $inventory->supplier->CompanyName ?? 'N/A' }}</td>
                     <!-- Accessing CompanyName via relationship -->
                     <td>{{ $inventory->item->description ?? 'N/A' }}</td>
                     <!-- Accessing description via relationship -->
                     <td>{{ $inventory->item->itemCategory ?? 'N/A' }}</td>
                     <!-- Accessing itemCategory via relationship -->
                     <td>{{ $inventory->qtyonhand }}</td>
                     <td>{{ \Carbon\Carbon::parse($inventory->date_received)->format('F j, Y') }}</td>
                     <td>{{ $inventory->original_quantity }}</td>
                     <td>{{ $inventory->status }}</td>
                   </tr>
                @endforeach
                  </tbody>

               </table>
            </div>

            <!-- Print Button Section -->
            <div class="row justify-content-end">
               <div class="btn-group col-sm-2 mt-5">
                  <a href="{{ route('print-inventory-report') }}" class="btn btn-success">Print</a>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>
@stop