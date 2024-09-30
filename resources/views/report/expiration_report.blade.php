@extends('layout')
@section('title', 'Expiration Report')
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Expiration Report</h2>
        <div class="card mt-2">
            <div class="card-body">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-lg-1 col-md-6 col-12">
                            <a>
                                <img src="{{asset('img/MG.png')}}" alt="product">
                            </a>
                        </div>
                        <div class="col-l0g-11 col-md-6 col-12">
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
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>Item No</th>
                                <th>SKU</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>QTY Sold</th>
                                <th>Total Sales Revenue</th>
                                <th>Net Profit</th>
                                <th>Profit Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001502</td>
                                <td>SED-250ml</td>
                                <td>Sting</td>
                                <td>Energy Drink</td>
                                <td>
                                    <select class="form-select">
                                        <option>Beverages</option>
                                        <option>Snacks</option>
                                        <option>Canned Goods</option>
                                        <option>Grocery</option>
                                    </select>
                                </td>
                                <td><span class="badge bg-success">15</span></td>
                                <td>P 2,000.00</td>
                                <td>P 1,475.00</td>
                                <td>73.75%</td>
                            </tr>
                            <tr>
                                <td>001504</td>
                                <td>YTS-90g-OR</td>
                                <td>Young Town Sardine</td>
                                <td>Canned Sardine</td>
                                <td>
                                    <select class="form-select">
                                        <option>Canned Goods</option>
                                        <option>Snacks</option>
                                        <option>Beverages</option>
                                        <option>Grocery</option>
                                    </select>
                                </td>
                                <td><span class="badge bg-success">18</span></td>
                                <td>P 450.00</td>
                                <td>P 90.00</td>
                                <td>20.00%</td>
                            </tr>
                            <tr>
                                <td>001501</td>
                                <td>NA-25g</td>
                                <td>Nestea Apple</td>
                                <td>Iced Tea Juice</td>
                                <td>
                                    <select class="form-select">
                                        <option>Beverages</option>
                                        <option>Snacks</option>
                                        <option>Canned Goods</option>
                                        <option>Grocery</option>
                                    </select>
                                </td>
                                <td><span class="badge bg-success">13</span></td>
                                <td>P 364.00</td>
                                <td>P 39.00</td>
                                <td>10.71%</td>
                            </tr>
                            <tr>
                                <td>001503</td>
                                <td>WS-1kg</td>
                                <td>White Sugar</td>
                                <td>Sweetener</td>
                                <td>
                                    <select class="form-select">
                                        <option>Groceries</option>
                                        <option>Snacks</option>
                                        <option>Canned Goods</option>
                                        <option>Beverages</option>
                                    </select>
                                </td>
                                <td><span class="badge bg-success">6kg</span></td>
                                <td>P 1,110.00</td>
                                <td>P 30.00</td>
                                <td>2.70%</td>
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
