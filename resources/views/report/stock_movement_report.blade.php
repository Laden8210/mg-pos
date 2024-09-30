@extends('layout')
@section('title', 'Stock Movement  Report')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Stock Movement Report</h2>
        <div class="card mt-2">
            <div class="card-body">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-lg-1 col-md-6 col-12">
                            <a>
                                <img src="{{asset('img/MG.png')}}" alt="product">
                            </a>
                        </div>
                        <div class="col-log-11 col-md-6 col-12">
                            <h5 class="app-brand-text menu-text fw-bolder">MG MINI MART</h5>
                            <p>Brgy. Tinongcop, Tantangan, South Cot. <br>Manager: Glo-Ann Panes</p>
                        </div>
                        <div>
                            <input type="date" value="2024-10-02" class="form-control mb-2">
                            <select class="form-control">
                                <option>March - 2024</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="itemId" class="form-label">Item ID</label>
                            <input type="text" class="form-control" id="itemId" value="001502" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="itemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemName" value="Sting" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName"
                                value="Pepsi-Cola Products Philippines, Inc. (PCPPI)" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="barcode" value="025365894234" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="expirationDate" class="form-label">Expiration Date</label>
                            <input type="text" class="form-control" id="expirationDate" value="05/26/2026" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="batch" class="form-label">Batch</label>
                            <input type="text" class="form-control" id="batch" value="1" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="contactPerson" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="contactPerson" value="Mr. Leornero Dasican"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Quantity Type</th>
                                <th>Quantity</th>
                                <th>Value Type</th>
                                <th>Value</th>
                                <th>Reference</th>
                                <th>QTY on Hand</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>04/10/2024</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Opening Balance</td>
                                <td>30</td>
                                
                            </tr>
                            <tr>
                                <td>04/10/2024</td>
                                <td>Out</td>
                                <td>5</td>
                                <td>In</td>
                                <td>₱210.00</td>
                                <td>Sales Order</td>
                                <td>25</td>
                            </tr>
                            <tr>
                                <td>04/11/2024</td>
                                <td>In</td>
                                <td>25</td>
                                <td>Out</td>
                                <td>₱750.00</td>
                                <td>Purchase Order</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>04/15/2024</td>
                                <td>In</td>
                                <td>1</td>
                                <td>Out</td>
                                <td>₱42.00</td>
                                <td>Returned</td>
                                <td>52</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="btn-group col-sm-2 mt-5">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">View</button>
                    </div>
                    <div class="btn-group col-sm-2 mt-5">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop