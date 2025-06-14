<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\User;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Customer; 
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('frontend.pages.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        // Xóa token cũ nếu có
        PasswordReset::where('email', $request->email)->delete();

        // Tạo token mới
        $token = Str::random(60);

        // Lưu token vào bảng password_resets
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Gửi email reset mật khẩu
        Mail::send('auth.emails.reset_password', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Yêu cầu đặt lại mật khẩu');
        });

        return redirect()->back()->with('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn.');
    }

    public function showResetForm(Request $request, $token)
    {
        // Lấy email từ query string
        $email = $request->input('email'); 
        // Kiểm tra xem token và email có hợp lệ không
        $resetRecord = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->first();
        if ($resetRecord) {
            // Hiển thị form reset mật khẩu nếu token hợp lệ
            return view('frontend.pages.reset_password', ['token' => $token, 'email' => $email]);
        } else {
            // Nếu không hợp lệ, chuyển hướng đến trang đăng nhập với thông báo lỗi
            return redirect()->route('login.form')->with('error', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.');
        }
    }
   public function emailresetPassword(Request $request)
    {
        $email = $request->input('email');

        // Xác nhận dữ liệu đầu vào với thông báo tùy chỉnh
        $request->validate([
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Tìm người dùng dựa trên email và token (được gửi trong form)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng với email này.');
        }

        // Kiểm tra mật khẩu mới có khác mật khẩu hiện tại không
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu mới không thể trùng với mật khẩu hiện tại.');
        }

        // Cập nhật mật khẩu mới
        $user->update(['password' => Hash::make($request->new_password)]);

        // Trả về thông báo thành công
        PasswordReset::where('email', $email)->delete();
        return redirect()->route('login.form')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

}
