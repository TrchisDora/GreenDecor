<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Hàm tạo yêu cầu thanh toán
    public function createPayment(Request $request)
    {
        $vnp_TmnCode = env('VNPAY_TMN_CODE'); // Mã website
        $vnp_HashSecret = env('VNPAY_HASH_SECRET'); // Chuỗi bí mật
        $vnp_Url = env('VNPAY_URL'); // URL thanh toán
        $vnp_Returnurl = env('VNPAY_RETURN_URL'); // URL nhận kết quả

        // Thông tin đơn hàng
        $vnp_TxnRef = time(); // Mã giao dịch
        $vnp_OrderInfo = 'Thanh toán trả góp đơn hàng #' . $vnp_TxnRef;
        $vnp_OrderType = 'installment';
        $vnp_Amount = 10000000 * 100; // 10 triệu đồng
        $vnp_Locale = 'vn';
        $vnp_BankCode = ''; // Để trống cho user chọn ngân hàng sau
        $vnp_IpAddr = $request->ip();

        // Tạo mảng dữ liệu
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // Sắp xếp và tạo chuỗi mã hóa
        ksort($inputData);
        $hashdata = urldecode(http_build_query($inputData));
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $inputData['vnp_SecureHash'] = $vnp_SecureHash;

        // Tạo URL thanh toán
        $vnp_Url = $vnp_Url . '?' . http_build_query($inputData);

        // Điều hướng người dùng sang VNPAY
        return redirect($vnp_Url);
    }

    // Hàm nhận kết quả trả về
    public function paymentReturn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');

        $inputData = $request->except(['vnp_SecureHashType', 'vnp_SecureHash']);
        ksort($inputData);
        $hashData = urldecode(http_build_query($inputData));

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $request->vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                return "✅ Giao dịch thành công!";
            } else {
                return "❌ Giao dịch thất bại! Mã lỗi: " . $request->vnp_ResponseCode;
            }
        } else {
            return "🚫 Dữ liệu không hợp lệ!";
        }
    }
}
