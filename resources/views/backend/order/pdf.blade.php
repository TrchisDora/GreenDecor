<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Chi tiết đơn hàng - Green Store</title>
    <style>
    body {
        font-family: "DejaVu Sans", Arial, sans-serif;
        margin: 0;
        padding: 2px; /* Lề sát 2px */
        font-size: 11px;
        width: 100%;
        box-sizing: border-box;
    }

    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .text-center {
        text-align: center;
    }

    .title {
        font-size: 14px;
        font-weight: bold;
        margin: 5px 0;
    }

    .sub-title {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .section {
        margin-bottom: 8px;
    }

    p {
        margin: 1px 0;
        line-height: 1.3;
    }

    .box {
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        padding: 4px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        margin-top: 5px;
    }

    th, td {
        padding: 3px;
        border: 1px solid #000; /* Thêm viền bảng rõ nét */
        text-align: left;
        vertical-align: top;
        word-break: break-word;
    }

    th {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    .logo {
        display: block;
        margin: 0 auto 5px auto;
        width: 70px;
        height: auto;
    }

    .footer {
        text-align: center;
        margin-top: 5px;
        font-size: 10px;
    }
</style>

</head>
<body>
    <div class="container">
        <div class="text-center">
            
            <p class="title">GREEN STORE</p>
            <p class="sub-title">CHI TIẾT ĐƠN HÀNG</p>
        </div>
        <h3>Thông tin đơn hàng</h3>
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p><strong>Phương thức thanh toán:</strong>
                    @if($order->payment_method == 'cod') Thanh toán khi nhận hàng
                    @elseif($order->payment_method == 'paypal') PayPal
                    @elseif($order->payment_method == 'cardpay') Thẻ tín dụng
                    @endif
                </p>
                
                <p><strong>Trạng thái thanh toán:</strong> 
                    {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                </p>
                <hr>
                <h3>Thông tin khách hàng</h3>
                <p><strong>Họ và tên:</strong> {{ ucfirst($order->user->name) }}</p>
                <p><strong>Email:</strong> {{ strtolower($order->user->email) }}</p>
                <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'Chưa có' }}</p>
                <hr>
                <h3>Thông tin giao hàng</h3>
    <p><strong>Họ và tên:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
    <p><strong>Địa chỉ nhận hàng:</strong> {{ $order->phone }}, {{ $order->address1 }}, {{ $order->country }}</p>
    <p><strong>Mã bưu điện:</strong> {{ $order->post_code }}</p>
    <p><strong>Phí vận chuyển:</strong> ${{ number_format($order->shipping->price, 2) }}</p>

        <!-- Danh sách sản phẩm -->
        <div class="section">
            <h3>Sản phẩm trong đơn</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->carts as $cart)
                    <tr>
                        <td>{{ $cart->product->title }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>${{ number_format($cart->price, 2) }}</td>
                        <td>${{ number_format($cart->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       <!-- Tổng hóa đơn -->
<div class="section text-right" style="margin-top: 20px;">
    <h2 class="font-weight-bold">Tổng hóa đơn: ${{ number_format($order->total_amount, 2) }}</h2>
    <p><em>(Tổng hóa đơn bao gồm phí vận chuyển)</em></p>
</div>


        <!-- Lời cam kết -->
        <div class="section text-center">
            <p><strong>Green Store cam kết chịu trách nhiệm từ việc lập đơn, đóng gói đến vận chuyển hàng hóa.</strong></p>
            <p class="text-muted">Liên hệ qua số điện thoại: <strong>0788781116</strong> hoặc địa chỉ: <strong>12 Lương Định Của, TP. Cần Thơ</strong></p>
            <small class="text-muted">&copy; {{ date('Y') }} Green Store. All Rights Reserved.</small>
        </div>
    </div>
</body>
</html>
