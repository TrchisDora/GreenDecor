<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Product;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;
use App\Models\Order;
use Spatie\Activitylog\Models\Activity;
class AdminController extends Controller

{
    public function index()
    {
        // Thống kê người dùng theo ngày trong 7 ngày gần nhất
        $data = User::select(
                \DB::raw("COUNT(*) as count"),
                \DB::raw("DAYNAME(created_at) as day_name"),
                \DB::raw("DAY(created_at) as day")
            )
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();

        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }

        // Đếm số lượng đơn hàng theo trạng thái
        $statusCounts = [
            'new' => Order::where('status', 'new')->count(),
            'processed' => Order::where('status', 'processed')->count(),
            'shipping' => Order::where('status', 'shipping')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancel_request' => Order::where('status', 'cancel_request')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
            'failed' => Order::where('status', 'failed')->count(),
            'out_of_stock' => Order::where('status', 'out_of_stock')->count(),
            'store_pickup' => Order::where('status', 'store_pickup')->count(),
        ];

        // Sản phẩm gần hết hàng
        $productstock = Product::select('title', 'stock')
                    ->orderBy('stock', 'asc')
                    ->take(6)
                    ->get();

        // 5 sản phẩm mới nhất
        $latestProducts = Product::orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        // 5 đơn hàng mới nhất
        $latestOrders = Order::orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // 5 người dùng mới nhất
        $latestUsers = User::orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        $revenueData = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(sub_total) as total_revenue')
                    ->where('payment_status', 'paid')
                    ->groupBy('year', 'month')
                    ->orderByRaw('YEAR(created_at) ASC, MONTH(created_at) ASC')  // Sắp xếp theo năm và tháng từ 1 đến 12
                    ->get();
                    
        return view('backend.index', [
            'users' => json_encode($array),
            'statusCounts' => $statusCounts,
            'productstock' => $productstock,
            'latestProducts' => $latestProducts,
            'latestOrders' => $latestOrders,
            'latestUsers' => $latestUsers,
            'revenueData' => $revenueData,  
        ]);
    }


    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    public function settings(){
        $data=Settings::first();
        return view('backend.setting')->with('data',$data);
    }

    public function settingsUpdate(Request $request){
        // return $request->all();
        $this->validate($request,[
            'short_des'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required',
            'logo'=>'required',
            'address'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
        ]);
        $data=$request->all();
        // return $data;
        $settings=Settings::first();
        // return $settings;
        $status=$settings->fill($data)->save();
        if($status){
            request()->session()->flash('success','Setting successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword(){
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        // Xác nhận dữ liệu đầu vào với thông báo tùy chỉnh
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Cập nhật mật khẩu mới
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        // Trả về thông báo thành công
        return redirect()->route('admin')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
