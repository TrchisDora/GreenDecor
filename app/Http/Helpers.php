<?php

use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
// use Auth;
class Helper{
        // Hàm chuẩn hóa tên tỉnh (xóa từ "Tỉnh" và "Thành phố" đầu chuỗi)
        public static function normalizeProvinceName($name)
        {
            // Xoá "Tỉnh" hoặc "Thành phố" đầu chuỗi
            $name = preg_replace('/^(Tỉnh|Thành phố)\s+/iu', '', $name);
        
            // Xoá khoảng trắng thừa
            $name = trim($name);
        
            return $name;
        }
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    } 
    
    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>
            
            <li>
            <a href="javascript:void(0);">Danh mục sản phẩm<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
    }
   // Phương thức tính tổng giá trị giỏ hàng cộng với phí vận chuyển
   public static function totalCartPrice($user_id = '', $province = '', $shipping_id = '')
   {
       if (Auth::check()) {
           if ($user_id == "") {
               $user_id = auth()->user()->id;
           }

           // Tính tổng giá trị giỏ hàng (giá * số lượng)
           $totalCart = Cart::where('user_id', $user_id)
                            ->where('order_id', null)
                            ->sum(DB::raw('price * quantity'));

           // Nếu province và shipping_id được cung cấp, lấy giá phí vận chuyển
           if ($province && $shipping_id) {
               $shippingFee = DB::table('tbl_shipping_fee')
                                ->where('province_name', $province)
                                ->where('shipping_id', $shipping_id)
                                ->value('price');

               // Cộng thêm phí vận chuyển vào tổng giỏ hàng
               if ($shippingFee !== null) {
                   $totalCart += $shippingFee;
               }
           }

           return $totalCart;
       }
       
       return 0;
   }
    // Wishlist Count
    public static function wishlistCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            // return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('price');

        }
        else{
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }
    
    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }

    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }
    public static function fixStoragePath($url)
    {
        // Nếu null hoặc rỗng thì trả về ảnh mặc định
        if (empty($url)) {
            return asset('images/no-image.png'); // ảnh mặc định bạn đặt trong public/images/
        }

        // Xóa domain (http://127.0.0.1:8000, http://localhost:8000, ...)
        $relativePath = preg_replace('#^https?://[^/]+#', '', $url);

        // Trả về đường dẫn đầy đủ theo base URL hiện tại
        return url($relativePath);
    }

}

?>