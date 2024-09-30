@extends('layout')
@section('title', 'Inventory Report')
@section('content')
<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h2>Inventory Report</h2>
      <div class="card mt-2">
         <div class="card-body">
            <div class="main-content">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="col-lg-1 col-md-6 col-12">
                     <a>
                        <img src="{{asset('img/MG.png')}}" alt="product" class="logo">
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
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>QTY on hand</th>
                        <th>Date Received</th>
                        <th>Expiration Date</th>
                        <th>Reorder Point</th>
                        <th>Batch</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>001501</td>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                              <img src="{{asset('img/product/noimage.png')}}" alt="product">
                           </a>
                           <a href="javascript:void(0);">Nestea Apple</a>
                        </td>
                        <td>Iced Tea Juice</td>
                        <td>
                           <select class="select">
                              <option>Category</option>
                              <option>Grocery</option>
                              <option>Beverages</option>
                              <option>Canned Goods</option>
                              <option>Snacks</option>
                           </select>
                        </td>
                        <td>50</td>
                        <td>02/08/24</td>
                        <td>02/08/26</td>
                        <td>
                           <span class="badges bg-lightgreen">10</span>
                        </td>
                        <td>1</td>
                     </tr>
                     <tr>
                        <td>001501</td>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                              <img src="{{asset('img/product/noimage.png')}}" alt="product">
                           </a>
                           <a href="javascript:void(0);">Nestea Apple</a>
                        </td>
                        <td>Iced Tea Juice</td>
                        <td>
                           <select class="select">
                              <option>Category</option>
                              <option>Grocery</option>
                              <option>Beverages</option>
                              <option>Canned Goods</option>
                              <option>Snacks</option>
                           </select>
                        </td>
                        <td>50</td>
                        <td>02/08/24</td>
                        <td>02/08/26</td>
                        <td>
                           <span class="badges bg-lightgreen">10</span>
                        </td>
                        <td>1</td>
                     </tr>
                     <tr>
                        <td>001501</td>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                              <img src="{{asset('img/product/noimage.png')}}" alt="product">
                           </a>
                           <a href="javascript:void(0);">Nestea Apple</a>
                        </td>
                        <td>Iced Tea Juice</td>
                        <td>
                           <select class="select">
                              <option>Category</option>
                              <option>Grocery</option>
                              <option>Beverages</option>
                              <option>Canned Goods</option>
                              <option>Snacks</option>
                           </select>
                        </td>
                        <td>50</td>
                        <td>02/08/24</td>
                        <td>02/08/26</td>
                        <td>
                           <span class="badges bg-lightgreen">10</span>
                        </td>
                        <td>1</td>
                     </tr>
                     <tr>
                        <td>001501</td>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                              <img src="{{asset('img/product/noimage.png')}}" alt="product">
                           </a>
                           <a href="javascript:void(0);">Nestea Apple</a>
                        </td>
                        <td>Iced Tea Juice</td>
                        <td>
                           <select class="select">
                              <option>Category</option>
                              <option>Grocery</option>
                              <option>Beverages</option>
                              <option>Canned Goods</option>
                              <option>Snacks</option>
                           </select>
                        </td>
                        <td>50</td>
                        <td>02/08/24</td>
                        <td>02/08/26</td>
                        <td>
                           <span class="badges bg-lightgreen">10</span>
                        </td>
                        <td>1</td>
                     </tr>
                     <tr>
                        <td>001501</td>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                              <img src="{{asset('img/product/noimage.png')}}" alt="product">
                           </a>
                           <a href="javascript:void(0);">Nestea Apple</a>
                        </td>
                        <td>Iced Tea Juice</td>
                        <td>
                           <select class="select">
                              <option>Category</option>
                              <option>Grocery</option>
                              <option>Beverages</option>
                              <option>Canned Goods</option>
                              <option>Snacks</option>
                           </select>
                        </td>
                        <td>50</td>
                        <td>02/08/24</td>
                        <td>02/08/26</td>
                        <td>
                           <span class="badges bg-lightgreen">10</span>
                        </td>
                        <td>1</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="row justify-content-end">
               <!-- View Button -->
               <div class="btn-group col-sm-2 mt-5">
                  <button type="button" class="btn btn-warning">View</button>
               </div>

               <!-- Print Button -->
               <div class="btn-group col-sm-2 mt-5">
                  <button type="button" class="btn btn-success">Print</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop