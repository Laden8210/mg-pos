@extends('layout')
@section('title', 'Dashboard')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <h2>Dashboard</h2>

      <div class="row">
        <div class="col-lg-8 col-md-12 order-1">
          <div class="row mb-4">
            <div class="col-lg-6 col-md-12 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                     <span class="badge bg-label-warning rounded-pill">Total Income</span>

                  </div>
                  <h3 class="card-title mb-2">₱12,628</h3>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                     <span class="badge bg-label-warning rounded-pill">Total Sales</span>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>

                    </div>
                  </div>

                  <h3 class="card-title text-nowrap mb-1">₱4,679</h3>

                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                       <span class="badge bg-label-warning rounded-pill">Total Items</span>
                      <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>

                      </div>
                    </div>

                    <h3 class="card-title text-nowrap mb-1">100</h3>

                  </div>
                </div>
              </div>
          </div>



          <!-- Total Revenue -->
          <div class="card mb-4">
            <div class="row row-bordered g-0">
              <div class="col-md-8">

                <h5 class="card-header m-0 me-2 pb-3 ">Total Revenue</h5>
                <div id="totalRevenueChart" class="px-2"></div>
              </div>
              <div class="col-md-4">
                <div class="card-body">
                  <div class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        2022
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                        <a class="dropdown-item" href="javascript:void(0);">2021</a>
                        <a class="dropdown-item" href="javascript:void(0);">2020</a>
                        <a class="dropdown-item" href="javascript:void(0);">2019</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="growthChart"></div>
                <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                  <div class="d-flex">
                    <div class="me-2">
                      <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                      <small>2022</small>
                      <h6 class="mb-0">₱32.5k</h6>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="me-2">
                      <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                      <small>2021</small>
                      <h6 class="mb-0">₱41.2k</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /Total Revenue -->
        </div>
 <!-- Most Selling Items (Moved to the right side) -->
<div class="col-md-6 col-lg-4 order-3 mb-4">
   <div class="card h-100">
     <div class="card-header d-flex align-items-center justify-content-between">
       <h5 class="card-title m-0 me-2 badge bg-label-primary rounded-pill">Most Selling Items</h5>

       <div class="dropdown">
         <button class="btn p-0" type="button" id="paymentID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="bx bx-dots-vertical-rounded"></i>
         </button>

       </div>
     </div>
     <div class="card-body">
       <div class="table-responsive">
         <table class="table datanew">
           <thead>
             <tr>
               <th>Rank</th>
               <th>Item</th>
               <th>Sales</th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td>1</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
             <tr>
               <td>2</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
             <tr>
               <td>3</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
             <tr>
               <td>4</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
             <tr>
               <td>5</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
             <tr>
               <td>6</td>
               <td class="productimgname">
                 <a href="javascript:void(0);" class="product-img">
                   <img src="{{asset('img/product/noimage.png')}}" alt="product" class="rounded" />
                 </a>
                 <a href="javascript:void(0);">Jasmine Rice</a>
               </td>
               <td>₱ 85,380.00</td>
             </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </div>

 <!-- /Payments -->
</div>
</div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
      // Data for the chart
      var options = {
          chart: {
              type: 'bar',
              height: 350,
              toolbar: {
                  show: false
              }
          },
          series: [{
              name: 'Revenue',
              data: [32500, 41200, 58000, 47000] // Example data for 2022, 2021, 2020, 2019
          }],
          xaxis: {
              categories: ['2022', '2021', '2020', '2019'],
              title: {
                  text: 'Years'
              }
          },
          yaxis: {
              title: {
                  text: 'Revenue in ₱'
              }
          },
          dataLabels: {
              enabled: true,
          },
          fill: {
              opacity: 1,
          },
          colors: ['#008FFB'],
      };

      // Render the chart
      var chart = new ApexCharts(document.querySelector("#totalRevenueChart"), options);
      chart.render();
  });
</script>

@endsection
