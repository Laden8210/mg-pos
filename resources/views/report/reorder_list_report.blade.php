@extends('layout')
@section('title', 'Reorder List Report')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Reorder List Report</h2>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <th>BATCH</th>
                            <th>ITEM NAME</th>
                            <th>COMPANY NAME</th>
                            <th>CATEGORY</th>
                            <th>QTY ON HAND</th>
                            <th>REORDER POINT</th>
                        </thead>
                        <tbody>
                            @foreach($reorderItems as $item)
                                <tr>
                                    <td>{{ $item->batch }}</td>
                                    <td>{{ $item->item->itemName ?? 'N/A' }}</td> <!-- Access item name -->
                                    <td>{{ $item->supplier->CompanyName ?? 'N/A' }}</td> <!-- Access supplier name -->
                                    <td>{{ $item->item->itemCategory ?? 'N/A' }}</td> <!-- Access item category -->
                                    <td>{{ $item->qtyonhand }}</td>
                                    <td>{{ $item->reorder_point }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="btn-group col-sm-2 mt-5">
                        <a href="{{ route('print-reorder-list-report') }}" class="btn btn-success">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop