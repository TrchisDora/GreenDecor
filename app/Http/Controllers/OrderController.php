<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required'
        ]);
        // return $request->all();

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['shipping_id'] = $request->shipping;
        $shipping = Shipping::where('id', $order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }
        if ($request->shipping) {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0];
            }
        } else {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        // $order_data['status']="new";
        // if(request('payment_method')=='paypal'){
        //     $order_data['payment_method']='paypal';
        //     $order_data['payment_status']='paid';
        // }
        // else{
        //     $order_data['payment_method']='cod';
        //     $order_data['payment_status']='Unpaid';
        // }
        if (request('payment_method') == 'paypal') {
            $order_data['payment_method'] = 'paypal';
            $order_data['payment_status'] = 'paid';
        } elseif (request('payment_method') == 'cardpay') {
            $order_data['payment_method'] = 'cardpay';
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }
        $order->fill($order_data);
        $status = $order->save();
        if ($order)
            // dd($order->id);
            $users = User::where('role', 'admin')->first();
        $details = [
            'title' => 'New Order Received',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        if (request('payment_method') == 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } else {
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);        
        request()->session()->flash('success', 'Your product order has been placed. Thank you for shopping with us.');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin đơn hàng với ID và các sản phẩm trong giỏ hàng liên quan
        $order = Order::with('carts')->find($id);

        // Kiểm tra nếu không có đơn hàng
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
        $this->validate($request, [
            'status' => 'required|in:new,process,shipping,delivered,cancel_requested,cancelled,failed_delivery,out_of_stock,store_payment'
        ]);
        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // return $product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
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

    // Phương thức cập nhật trạng thái cho nhiều đơn hàng cùng lúc
    public function bulkUpdate(Request $request)
    {
        // Lấy các ID đơn hàng được chọn và trạng thái mới
        $orderIds = $request->input('order_ids');
        $status = $request->input('status');

        // Kiểm tra nếu có đơn hàng được chọn và trạng thái hợp lệ
        if ($orderIds && $status) {
            // Cập nhật trạng thái cho các đơn hàng đã chọn
            Order::whereIn('id', $orderIds)->update(['status' => $status]);

            // Trả về thông báo thành công
            return redirect()->route('order.index')->with('success', 'Cập nhật trạng thái thành công!');
        }

        // Trả về thông báo lỗi nếu không có đơn hàng hoặc trạng thái không hợp lệ
        return redirect()->route('order.index')->with('error', 'Không có đơn hàng được chọn hoặc trạng thái không hợp lệ.');
    }

    public function productTrackOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->id)
            ->where('order_number', $request->order_number)
            ->first();

        if (!$order) {
            request()->session()->flash('error', 'Mã đơn hàng không hợp lệ. Vui lòng thử lại!');
            return back();
        }

        // Kiểm tra nếu trạng thái đã là kết thúc, không cho phép thay đổi
        if (in_array($order->status, ['delivered', 'store_payment', 'cancelled', 'failed_delivery', 'out_of_stock'])) {
            request()->session()->flash('error', 'Đơn hàng đã ở trạng thái kết thúc và không thể thay đổi nữa.');
            return back();
        }

        // Logic chuyển trạng thái
        if ($order->status == 'new') {
            // Trạng thái mới, chỉ có thể chuyển thành "Đã xử lý đơn hàng" hoặc "Hết hàng"
            $statusMessage = 'Trạng thái đơn hàng: Chờ xử lý đơn hàng. Bạn có thể chuyển sang "Đã xử lý đơn hàng" hoặc "Hết hàng".';
        } elseif ($order->status == 'cancel_requested') {
            // Trạng thái yêu cầu hủy, chỉ có thể chọn "Xác nhận yêu cầu hủy đơn"
            $statusMessage = 'Trạng thái đơn hàng: Bạn đã yêu cầu hủy đơn hàng. Bạn chỉ có thể chọn "Xác nhận yêu cầu hủy đơn".';
        } elseif ($order->status == 'process') {
            // Đã xử lý, chỉ có thể chuyển sang "Đang giao hàng"
            $statusMessage = 'Trạng thái đơn hàng: Đơn hàng đã được xử lý. Bạn có thể chuyển sang "Đang giao hàng".';
        } elseif ($order->status == 'shipping') {
            // Đang giao hàng, có thể chuyển sang "Giao hàng thành công" hoặc "Giao hàng thất bại"
            $statusMessage = 'Trạng thái đơn hàng: Đơn hàng đang giao. Bạn có thể chuyển sang "Giao hàng thành công" hoặc "Giao hàng thất bại".';
        } elseif ($order->status == 'delivered') {
            // Giao hàng thành công, kết thúc
            $statusMessage = 'Trạng thái đơn hàng: Giao hàng thành công. Cảm ơn bạn đã mua hàng!';
            $order->payment_status = 'paid';  // Đổi payment_status thành "paid"
            $order->save();
        } elseif ($order->status == 'failed_delivery') {
            // Giao hàng thất bại, kết thúc
            $statusMessage = 'Trạng thái đơn hàng: Giao hàng thất bại.';
        } elseif ($order->status == 'out_of_stock') {
            // Hết hàng, kết thúc
            $statusMessage = 'Trạng thái đơn hàng: Hết hàng.';
        } elseif ($order->status == 'store_payment') {
            // Thanh toán tại cửa hàng, kết thúc
            $statusMessage = 'Trạng thái đơn hàng: Thanh toán tại cửa hàng.';
            $order->payment_status = 'paid';  // Đổi payment_status thành "paid"
            $order->save();
        } elseif ($order->status == 'cancelled') {
            // Đơn hàng đã hủy, kết thúc
            $statusMessage = 'Trạng thái đơn hàng: Đơn hàng đã bị hủy.';
        }

        request()->session()->flash('success', $statusMessage);
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
