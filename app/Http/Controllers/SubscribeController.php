<?php
namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmationMail;


class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);
        // Lưu email vào bảng subscribers
            $subscriber = Subscriber::create([
                'email' => $request->email,
            ]);

        // Gửi email cảm ơn và mã giảm giá
        Mail::send('auth.emails.subscription_confirmation', [
            'email' => $request->email,
            'discount_code' => 'WELCOME10',
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Cảm ơn bạn đã đăng ký nhận bản tin!');
        });

        return back()->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email của bạn để nhận mã giảm giá.');
    }
    public function unsubscribe($email)
    {
        // Tìm và xóa subscriber theo email
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            // Xóa email khỏi bảng subscribers
            $subscriber->delete();

            // Gửi email thông báo đã hủy đăng ký
            Mail::send('auth.emails.unsubscription_confirmation', [
                'email' => $email,
            ], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Bạn đã hủy đăng ký nhận bản tin!');
            });

            return redirect()->route('home')->with('success', 'Bạn đã hủy đăng ký thành công!');
        }

        return redirect()->route('home')->with('error', 'Email này không tồn tại trong danh sách đăng ký.');
    }

}
