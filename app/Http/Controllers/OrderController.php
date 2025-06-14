<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingFee; // Import ShippingFee model
use App\Models\Shipping; // Import Shipping model
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate();
        return view('backend.order.index')->with('orders', $orders);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Hàm chuẩn hóa tên tỉnh (xóa từ "Tỉnh" và "Thành phố" đầu chuỗi)
    private function normalizeProvinceName($name)
    {
        // Xoá "Tỉnh" hoặc "Thành phố" đầu chuỗi
        $name = preg_replace('/^(Tỉnh|Thành phố)\s+/iu', '', $name);
    
        // Xoá khoảng trắng thừa
        $name = trim($name);
    
        return $name;
    }

    public function store(Request $request)
    {
        // 1. VALIDATE INPUT
        $request->validate([
            'first_name' => 'string|required|max:255',
            'last_name' => 'string|required|max:255',
            'email' => 'email|required|max:255',
            'phone' => 'required|numeric|min:10',
            'country' => 'required|string|max:100',
            'shipping_address1' => 'required|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'province_name' => 'nullable|string|max:255',
            'shipping_postcode' => 'nullable|string|max:20',
            'shipping_id' => 'required|string|max:255',
            'shipping_price' => 'nullable|numeric',
            'coupon' => 'nullable|numeric',
            'payment_method' => 'required|string|in:cod,cardpay,vnpay',
            'card_number' => 'nullable|numeric|digits:16',
            'card_name' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|string|size:5|regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
            'cvv' => 'nullable|numeric|digits:3',
        ]);
    
        // dd($request->all()); 

        if (Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->count() == 0) {
            return back()->with('error', 'Giỏ hàng đang trống!');
        }

        // 3. SHIPPING INFO
        $shippingModel = Shipping::where('id', $request->shipping_id)->first();
        if (!$shippingModel) {
            return back()->with('error', 'Không tìm thấy phương thức vận chuyển phù hợp.');
        }

        $shipping_id = $shippingModel->id;
        $province = $this->normalizeProvinceName($request->province_name) ?? 'Cần Thơ';
        $shippingFee = ShippingFee::where('province_name', $province)
                                ->where('shipping_id', $shipping_id)
                                ->first();
        $shipping_price = $shippingFee ? $shippingFee->price : 0;

        $sub_total = (int) Helper::totalCartPrice();
        $quantity = Helper::cartCount();
        $coupon = session('coupon')['value'] ?? 0;
        $total_amount = $sub_total + $shipping_price - $coupon;

       if ($request->payment_method === 'vnpay') {
            $order_data = [
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => auth()->user()->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'shipping_id' => $request->shipping_id,
                'sub_total' => $sub_total,
                'quantity' => $quantity,
                'coupon' => $coupon,
                'total_amount' => $total_amount,
                'address1' => $request->shipping_address1,
                'address2' => $request->shipping_address2,
                'post_code' => $request->shipping_postcode,
                'payment_method' => 'vnpay',
                'payment_status' => 'paid',
                'country' => $request->country, // Thêm country vào đây
            ];

            session(['vnpay_order_data' => $order_data]);

            // VNPay settings
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('cart.vnpay_return');
            $vnp_TmnCode = "RZYBNT5M";
            $vnp_HashSecret = "YHNZQ4561JN1QTQKVI2UNPDQAUWP04B6";
            $vnp_TxnRef = $order_data['order_number'];
            $vnp_OrderInfo = "Thanh toán đơn hàng " . $vnp_TxnRef;
            $vnp_Amount = $order_data['total_amount'] * 100;

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $request->ip(),
                "vnp_Locale" => 'vn',
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => 'billpayment',
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            // Bắt đầu mã hóa đúng chuẩn theo VNPay
            ksort($inputData);
            $hashdata = '';
            $i = 0;
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $query = http_build_query($inputData);
            $vnp_Url .= '?' . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

            return redirect($vnp_Url);
        }
        // Nếu không phải VNPay thì tạo đơn hàng luôn
        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = auth()->user()->id;
        $order_data['shipping_id'] = $shipping_id;
        $order_data['sub_total'] = $sub_total;
        $order_data['quantity'] = $quantity;
        $order_data['coupon'] = $coupon;
        $order_data['total_amount'] = $total_amount;
        $order_data['address1'] = $request->shipping_address1;
        $order_data['address2'] = $request->shipping_address2;
        $order_data['post_code'] = $request->shipping_postcode;
        $order_data['payment_status'] = in_array($request->payment_method, ['cardpay']) ? 'paid' : 'Unpaid';
        $order_data['country'] = $request->country; // Thêm country vào đây
        $order->fill($order_data);
        $order->save();
        $cartItems = Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->get();

        // GÁN order_id CHO CART ITEMS
        Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->update(['order_id' => $order->id]);

        // TRỪ TỒN KHO
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }

        // Gửi notification
        $admin = User::where('role', 'admin')->first();
        $details = [
            'title' => 'Đơn hàng mới',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        Notification::send($admin, new StatusNotification($details));

        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('home')->with('success', 'Đặt hàng thành công. Cảm ơn bạn đã mua sắm!');
    }


    public function vnpayReturn(Request $request)
    {
        // Validate chữ ký ở đây nếu muốn bảo mật hơn...

        if ($request->vnp_ResponseCode == '00') {
            // Thành công
            $order_data = session('vnpay_order_data');
            if (!$order_data) return redirect()->route('home')->with('error', 'Không tìm thấy thông tin đơn hàng.');

            $order_data['payment_status'] = 'paid';
            $order = Order::create($order_data);

            Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->update(['order_id' => $order->id]);

            $admin = User::where('role', 'admin')->first();
            $details = [
                'title' => 'Đơn hàng mới (VNPay)',
                'actionURL' => route('order.show', $order->id),
                'fas' => 'fa-file-alt'
            ];
            Notification::send($admin, new StatusNotification($details));

            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('vnpay_order_data');

            return redirect()->route('home')->with('success', 'Thanh toán VNPay thành công. Đơn hàng đã được ghi nhận.');
        }

        return redirect()->route('home')->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy đơn hàng cùng với các sản phẩm trong giỏ và thông tin vận chuyển
        $order = Order::with(['shipping.fee'])->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        return view('backend.order.show')->with('order', $order);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
    
        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            request()->session()->flash('error', 'Đơn hàng không tồn tại.');
            return redirect()->route('order.index');
        }
    
        // Validate dữ liệu từ form
        $this->validate($request, [
            'status' => 'required|in:new,process,shipping,delivered,cancel_requested,cancelled,failed_delivery,out_of_stock'
        ]);
    
        // Lấy tất cả dữ liệu từ request
        $data = $request->all();
    
        // Kiểm tra trạng thái và cập nhật sản phẩm trong kho khi trạng thái là 'delivered'
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // Giảm số lượng sản phẩm trong kho theo số lượng đã bán
                $product->stock -= $cart->quantity;
                $product->save();
            }
    
            // Cập nhật payment_status thành 'paid' khi giao hàng thành công
            $order->payment_status = 'paid';
        }
    
        // Cập nhật trạng thái đơn hàng
        $order->status = $request->status;
    
        // Lưu lại thông tin đơn hàng
        $status = $order->save();
    
        // Thông báo kết quả và quay lại trang danh sách đơn hàng
        if ($status) {
            request()->session()->flash('success', 'Cập nhật đơn hàng thành công');
        } else {
            request()->session()->flash('error', 'Đã có lỗi khi cập nhật đơn hàng');
        }
    
        return redirect()->route('order.index');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }
    
    public function productTrackOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->id)
                      ->where('order_number', $request->order_number)
                      ->first();
    
        if (!$order) {
            session()->flash('error', 'Mã đơn hàng không hợp lệ. Vui lòng thử lại!');
            return back();
        }
    
        $validStatuses = ['new', 'process', 'shipping', 'delivered', 'cancel_requested', 'cancelled', 'failed_delivery', 'out_of_stock'];
        $status = $request->input('status');
    
        if (!in_array($status, $validStatuses)) {
            session()->flash('error', 'Trạng thái không hợp lệ.');
            return back();
        }
    
        // Xử lý theo trạng thái hiện tại của đơn hàng
        $statusChanges = [
            'new' => ['process', 'out_of_stock'],
            'cancel_requested' => ['cancel_requested'],
            'process' => ['shipping'],
            'shipping' => ['delivered', 'failed_delivery']
        ];
    
        // Kiểm tra trạng thái hợp lệ dựa trên trạng thái hiện tại
        if (isset($statusChanges[$order->status]) && !in_array($status, $statusChanges[$order->status])) {
            $errorMessages = [
                'new' => 'Trạng thái không hợp lệ từ trạng thái "Mới".',
                'cancel_requested' => 'Chỉ có thể xác nhận yêu cầu hủy đơn.',
                'process' => 'Trạng thái "Đã xử lý" chỉ có thể chuyển sang "Đang giao hàng".',
                'shipping' => 'Trạng thái "Đang giao hàng" chỉ có thể chuyển sang "Giao hàng thành công" hoặc "Giao hàng thất bại".'
            ];
    
            session()->flash('error', $errorMessages[$order->status] ?? 'Không thể thay đổi trạng thái nữa.');
            return back();
        }
    
        // Cập nhật trạng thái
        $order->status = $status;
        $order->save();
    
        // Hiển thị thông báo thành công
        session()->flash('success', 'Trạng thái đơn hàng đã được cập nhật.');
        return redirect()->route('home');
    }
    

    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';

        $pdf = PDF::loadView('backend.order.pdf', compact('order'));

        // ➕ Cấu hình khổ giấy kiểu máy in hóa đơn (ví dụ khổ 58mm x chiều dài tùy)
        $pdf->setPaper([0, 0, 226.77, 1000], 'portrait');
        // 226.77 = 80mm, bạn có thể đổi thành 164.41 nếu là 58mm

        return $pdf->download($file_name);
    }

    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float) ($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
