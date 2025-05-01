<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\ShippingFee;
use Log;

class ShippingFeeController extends Controller
{
    // Hàm chuẩn hóa tên tỉnh (xóa từ "Tỉnh" và "Thành phố" đầu chuỗi)
    private function normalizeProvinceName($name)
    {
        // Xoá "Tỉnh" hoặc "Thành phố" đầu chuỗi
        $name = preg_replace('/^(Tỉnh|Thành phố)\s+/iu', '', $name);
    
        // Xoá khoảng trắng thừa
        $name = trim($name);
    
        return $name;
    }

    // Hàm lấy giá vận chuyển
    public function getPrice(Request $request)
    {
        // Lấy giá trị tỉnh và phương thức vận chuyển
        $province = $this->normalizeProvinceName($request->province);
        $shipping_id = $request->shipping_id;

        Log::debug('Received Shipping Request:', ['province' => $province, 'shipping_id' => $shipping_id]);

        // Tìm kiếm giá vận chuyển dựa trên province và type
        $shippingFee = ShippingFee::where('province_name', $province)
                                  ->where('shipping_id', $shipping_id)
                                  ->first();

        // Trả kết quả
        if ($shippingFee) {
            return response()->json([
                'price' => number_format($shippingFee->price, 2)
            ]);
        } else {
            return response()->json([
                'error' => 'Không tìm thấy giá vận chuyển.'
            ], 404);
        }
    }
    public function updateTotal(Request $request) {
        $shippingPrice = (int) $request->shipping_price;
        $user_id = auth()->user()->id;
    
        $total = Cart::totalCartPrice($user_id, $shippingPrice);
    
        return response()->json([
            'total' => number_format($total)
        ]);
    }    
    
}
