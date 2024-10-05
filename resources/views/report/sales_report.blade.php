@extends('layout')

@section('title', 'Sales Report')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Sales Report</h2>
        <div class="card mt-2">
            <div class="card-body">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-lg-1 col-md-6 col-12">
                            <a>
                                <img src="{{ asset('img/MG.png') }}" alt="product">
                            </a>
                        </div>
                        <div class="col-lg-11 col-md-6 col-12">
                            <h5 class="app-brand-text menu-text fw-bolder">MG MINI MART</h5>
                            <p>Brgy. Tinongcop, Tantangan, South Cot. <br>Manager: Glo-Ann Panes</p>
                        </div>
                        <div>
                            <input type="date" value="{{ now()->toDateString() }}" class="form-control mb-2">
                            <select class="form-control">
                                <option>March - 2024</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Batch</th>
                                <th>Item Name</th>
                                <th>Company Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Qty On Hand</th>
                                <th>Expiration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesStockCard as $sales)
                                <tr>
                                    <td>{{ $sales->batch }}</td>
                                    <td>{{ $sales->item->itemName }}</td>
                                    <td>{{ $sales->supplier->companyName }}</td>
                                    <td>{{ $sales->item->description }}</td>
                                    <td>{{ $sales->item->category }}</td>
                                    <td>{{ $sales->qtyOnHand }}</td>
                                    <td>{{ $sales->expirationDate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="btn-group col-sm-2 mt-5">
                        <a href="{{ route('print-sales-report') }}" class="btn btn-success">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
