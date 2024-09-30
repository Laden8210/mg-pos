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
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>Delivery No</th>
                                <th>Company Name</th>
                                <th>Contact Person</th>
                                <th>Contact NO.</th>
                                <th>Delivery Date</th>
                                <th>Address</th>
                                <th>Items</th>
                                <th>Status</th>
                                <th>Date Delivered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>KCC Mall of Marbel</td>
                                <td>Mr. Adan</td>
                                <td>09366958521</td>
                                <td>04/05/2024</td>
                                <td>Koronadal City, South Cotabato</td>
                                <td>
                                    <select class="Items">
                                        <option>Nova</option>
                                        <option>Siga</option>
                                        <option>Popcornd</option>
                                        <option>Piatos</option>
                                    </select>
                                </td>
                                <td><select class="Status">
                                        <option>Delivered</option>
                                        <option>Pending</option>
                                    </select>
                                </td>
                                <td>10/05/2024</td>
                            </tr>
                            <tr>
                                <td>001</td>
                                <td>KCC Mall of Marbel</td>
                                <td>Mr. Adan</td>
                                <td>09366958521</td>
                                <td>04/05/2024</td>
                                <td>Koronadal City, South Cotabato</td>
                                <td>
                                    <select class="Items">
                                        <option>Nova</option>
                                        <option>Siga</option>
                                        <option>Popcornd</option>
                                        <option>Piatos</option>
                                    </select>
                                </td>
                                <td><select class="Status">
                                        <option>Delivered</option>
                                        <option>Pending</option>
                                    </select>
                                </td>
                                <td>10/05/2024</td>
                            </tr>
                            <tr>
                                <td>001</td>
                                <td>KCC Mall of Marbel</td>
                                <td>Mr. Adan</td>
                                <td>09366958521</td>
                                <td>04/05/2024</td>
                                <td>Koronadal City, South Cotabato</td>
                                <td>
                                    <select class="Items">
                                        <option>Nova</option>
                                        <option>Siga</option>
                                        <option>Popcornd</option>
                                        <option>Piatos</option>
                                    </select>
                                </td>
                                <td><select class="Status">
                                        <option>Pending</option>
                                        <option>Delivered</option>
                                    </select>
                                </td>
                                <td>#</td>
                            </tr>
                            <tr>
                                <td>001</td>
                                <td>KCC Mall of Marbel</td>
                                <td>Mr. Adan</td>
                                <td>09366958521</td>
                                <td>04/05/2024</td>
                                <td>Koronadal City, South Cotabato</td>
                                <td>
                                    <select class="Items">
                                        <option>Nova</option>
                                        <option>Siga</option>
                                        <option>Popcornd</option>
                                        <option>Piatos</option>
                                    </select>
                                </td>
                                <td><select class="Status">
                                        <option>Pending</option>
                                        <option>Delivered</option>
                                    </select>
                                </td>
                                <td>#</td>
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
<div class="modal-footer">
    <td><button class="btn btn-link" onclick="printReport()"><i class="fas fa-print"></i></button></td>
</div>
@stop