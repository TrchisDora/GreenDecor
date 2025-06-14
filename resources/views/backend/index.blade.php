@extends('backend.layouts.master')
@section('title', 'Ecommerce Laravel || DASHBOARD')
@section('main-content')
  <div class="container-fluid">
    @include('backend.layouts.notification')
    <!-- Page Heading -->
    <!-- Visit 'codeastro' for more projects -->
    <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
      <div class="card-body">
        <h3 class="font-weight-bold">Welcome {{Auth()->user()->name}} to Dashboard</span></h3>
        <h6 class="font-weight-normal mb-0">Chào mừng bạn đến với trang quản trị <span
          class="text-primary">GreenDecor</span></h6>
      </div>
      </div>
    </div>
    </div>
<!-- Content Row -->
<div class="row">
    <!-- Bên trái: Doanh thu -->
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                            Doanh Thu Tháng Này
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ number_format(\App\Models\Order::countRevenueForCurrentMonth(), 0, ',', '.') }} ₫
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bên phải: Ma trận 2x2 -->
    <div class="col-xl-6 col-lg-6">
        <!-- Hàng trên -->
        <div class="row">
            <!-- Đơn hàng mới -->
            <div class="col-xl-6 col-md-6 ">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng mới</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Order::countNewReceivedOrder() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cart-plus fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm -->
            <div class="col-xl-6 col-md-6 ">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sản phẩm</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Product::countActiveProduct() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hàng dưới -->
        <div class="row">
            <!-- Loại sản phẩm -->
            <div class="col-xl-6 col-md-6 ">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Loại sản phẩm</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Category::countActiveCategory() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sitemap fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bài viết -->
            <div class="col-xl-6 col-md-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bài viết</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Post::countActivePost() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end right col -->
</div>

<div class="row">
    <div class="col-xl-12 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Thống kê doanh thu:</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <canvas id="revenueChart" style="width: 100%; height: 400px;"></canvas>
        </div>
      </div>
    </div>
  </div>
<div class="row">
    <div class="col-xl-12 col-lg-6">
        <!-- Bảng Doanh Thu -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách doanh thu theo tháng:</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Năm</th>
                                <th>Tháng</th>
                                <th>Tổng Doanh Thu (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueData as $data)
                                <tr>
                                    <td>{{ $data->year }}</td>
                                    <td>{{ $data->month }}</td>
                                    <td>{{ number_format($data->total_revenue) }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Row -->
<div class="row">
    <!-- Biểu đồ bên trái -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow h-100 py-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Thống kê đơn hàng:</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="width:100%; height:500px;">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch bên phải -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow h-100 py-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lịch làm việc</h6>
            </div>
            <div class="card-body">
                <div class="calendar-widget">
                    <div class="monthly" id="mycalendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
  @php
    // Lấy 10 sản phẩm có tồn kho thấp nhất
    $lowStockProducts = collect($productstock)->sortBy('stock')->take(10);
    $labels = $lowStockProducts->pluck('title');
    $data = $lowStockProducts->pluck('stock');
  @endphp
  <div class="row">
    <div class="col-xl-12 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Thống kê sản phẩm gần hết:</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <canvas id="lowStockChart" style="width: 100%; height: 400px;"></canvas>
        </div>
      </div>
    </div>
  </div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success text-white">
                <h6 class="m-0 font-weight-bold">Sản phẩm mới nhất</h6>
                <a href="{{ route('product.index') }}" class="btn btn-light btn-sm">Đến trang sản phẩm</a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    @if(count($latestProducts) > 0)
                        <table class="table table-striped table-borderless mb-0" width="100%">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Giá</th>
                                    <th>Giảm giá</th>
                                    <th>Tình trạng</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestProducts as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ number_format($product->price) }} ₫</td>
                                        <td>{{ $product->discount }}%</td>
                                        <td>{{ $product->condition }}</td>
                                        <td>
                                            @if($product->photo)
                                                @php
                                                    $photo = explode(',', $product->photo);
                                                @endphp
                                                <img src="{{ $photo[0] }}" class="img-fluid zoom" style="max-width:80px" alt="Ảnh sản phẩm">
                                            @else
                                                <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid zoom" style="max-width:80px" alt="No image">
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->status == 'active')
                                                <span class="badge badge-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-warning">Không hoạt động</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-3">
                            <h6>Không có sản phẩm nào! Vui lòng thêm sản phẩm mới.</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success text-white">
                <h6 class="m-0 font-weight-bold">Đơn hàng gần nhất</h6>
                <a href="{{ route('order.index') }}" class="btn btn-light btn-sm">Đến trang đơn hàng</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @if(count($latestOrders) > 0)
                        <table class="table table-striped table-borderless mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'new' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($order->total_amount) }} ₫</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-3">
                            <h6>Không có đơn hàng nào!</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success text-white">
                <h6 class="m-0 font-weight-bold">Tài khoản gần đây</h6>
                <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">Đến trang tài khoản</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @if(count($latestUsers) > 0)
                        <table class="table table-striped table-borderless mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestUsers as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                       <td>
                                          {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Không có' }}
                                      </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-3">
                            <h6>Không có tài khoản nào mới!</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
  <!-- Axios -->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <!-- Google Charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    var analytics = <?php echo $users; ?>;
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = { title: 'Last 7 Days registered user' };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
    }
  </script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Line Chart -->
  <script type="text/javascript">
    const url = "{{ route('product.order.income') }}";

    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals = 0, dec_point = '.', thousands_sep = ',') {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      let n = !isFinite(+number) ? 0 : +number;
      let prec = Math.abs(decimals);
      let sep = thousands_sep;
      let dec = dec_point;
      let s = '';
      let toFixedFix = function(n, prec) {
        return (Math.round(n * Math.pow(10, prec)) / Math.pow(10, prec)).toFixed(prec);
      };
      s = (prec ? toFixedFix(n, prec) : Math.round(n).toString()).split('.');
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    axios.get(url).then(function (response) {
      const labels = Object.keys(response.data);
      const data = Object.values(response.data);
      new Chart(document.getElementById("myAreaChart"), {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: "Earnings",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: data,
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
          scales: {
            xAxes: [{
              time: { unit: 'date' },
              gridLines: { display: false, drawBorder: false },
              ticks: { maxTicksLimit: 7 }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                callback: value => '$' + number_format(value)
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }]
          },
          legend: { display: false },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: (tooltipItem, chart) => {
                return chart.datasets[tooltipItem.datasetIndex].label + ': $' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });
    }).catch(console.error);
  </script>

  <!-- Bar Chart: Order Status -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const ctx = document.getElementById('orderStatusChart');
      if (!ctx) return console.error("Canvas with ID 'orderStatusChart' not found.");

      const labels = ['Mới', 'Đã xử lý', 'Đang giao', 'Đã giao', 'Yêu cầu hủy', 'Đã hủy', 'Thất bại', 'Hết hàng'];
      const data = @json(array_values($statusCounts));
      if (!data.length) return console.warn("Không có dữ liệu biểu đồ.");

      const maxValue = Math.max(...data);
      const suggestedMax = Math.ceil((maxValue + 1) / 5) * 5;

      new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Số lượng đơn hàng',
            data: data,
            backgroundColor: ['#42a5f5', '#66bb6a', '#ffca28', '#7e57c2', '#ef5350', '#bdbdbd', '#8d6e63', '#ff7043']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              suggestedMax: suggestedMax,
              ticks: { stepSize: 1, precision: 0 }
            }
          },
          plugins: {
            title: { display: true, font: { size: 18 } },
            legend: { display: false }
          }
        }
      });
    });
  </script>

  <!-- Bar Chart: Low Stock -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const ctx = document.getElementById('lowStockChart').getContext('2d');
      const labels = @json($labels);
      const data = @json($data);

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Số lượng tồn kho',
            data: data,
            backgroundColor: data.map(stock => stock < 5 ? '#dc3545' : '#55ac49')
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1, precision: 0 }
            }
          },
          plugins: {
            title: {
              display: true,
              text: 'Top 10 sản phẩm gần hết hàng',
              font: { size: 18 }
            },
            legend: { display: false }
          }
        }
      });
    });
  </script>

  <!-- Bar Chart: Monthly Revenue -->
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Dữ liệu doanh thu từ Laravel
    const revenueData = @json($revenueData);

    // Lấy danh sách tháng (1 đến 12)
    const months = Array.from({ length: 12 }, (_, i) => i + 1);
    const labels = months.map(month => `Tháng ${month}`);

    // Tạo object chứa doanh thu theo năm
    const revenuesByYear = {};

    // Phân nhóm dữ liệu theo năm và tháng
    revenueData.forEach(item => {
      const { year, month, total_revenue } = item;
      if (!revenuesByYear[year]) {
        revenuesByYear[year] = Array(12).fill(0); // Khởi tạo mảng doanh thu cho năm
      }
      revenuesByYear[year][month - 1] = total_revenue; // Lưu doanh thu vào tháng tương ứng
    });

    // Lấy danh sách các năm (keys của revenuesByYear)
    const years = Object.keys(revenuesByYear);

    // Danh sách màu lạnh (có thể thêm bớt tùy theo nhu cầu)
    const coldColors = [
        '#42a5f5', // Xanh dương
        '#66bb6a', // Xanh lá
        '#64b5f6', // Xanh dương nhạt
        '#81c784', // Xanh lá nhạt
        '#7986cb', // Xanh biển
        '#8e99f3', // Xanh dương tím
        '#00acc1', // Xanh ngọc
        '#26c6da', // Xanh da trời
        '#5c6bc0', // Xanh dương đậm
        '#9fa8da', // Xanh tím nhạt
        '#4caf50', // Xanh lá đậm
        '#0288d1', // Xanh dương đậm hơn
    ];

    // Tạo datasets cho từng năm
    const datasets = years.map((year, index) => ({
      label: `Doanh thu ${year}`,
      data: revenuesByYear[year],
      backgroundColor: coldColors[index % coldColors.length], // Chọn màu lạnh theo vòng lặp
    }));

    // Vẽ biểu đồ
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets,
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => value.toLocaleString() // Định dạng số
            }
          }
        }
      }
    });
  });
</script>


  <!-- Monthly Calendar -->
  <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/js/monthly.js') }}"></script>
  <script>
    $(window).on('load', function () {
      $('#mycalendar').monthly({
        mode: 'event',
        dataType: 'json',
        events: [
          {
            "id": 1,
            "name": "Họp team",
            "startdate": "2025-05-14",
            "enddate": "2025-05-14",
            "starttime": "10:00",
            "endtime": "11:00",
            "color": "#1abc9c"
          },
          {
            "id": 2,
            "name": "Giao hàng",
            "startdate": "2025-05-17",
            "enddate": "2025-05-17",
            "color": "#e74c3c"
          }
        ]
      });

      if (window.location.protocol === 'file:') {
        alert('Lưu ý: Lịch sự kiện không hoạt động khi chạy file HTML trực tiếp (file://). Vui lòng dùng localhost hoặc server.');
      }
    });
  </script>
@endpush
