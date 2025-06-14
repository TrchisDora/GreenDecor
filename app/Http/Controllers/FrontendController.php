<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\User;
use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        // return $banner;
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();
        // return $category;
        return view('frontend.index')
                ->with('featured', $featured)
                ->with('posts', $posts)
                ->with('banners', $banners)
                ->with('product_lists', $products)
                ->with('category_lists', $category);
    }
    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
        // dd($product_detail);
        return view('frontend.pages.product_detail')->with('product_detail', $product_detail);
    }

    public function productGrids()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category


        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productLists()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category


        return view('frontend.pages.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }
    
    public function productSearch(Request $request)
    {
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $products = Product::orwhere('title', 'like', '%'.$request->search.'%')
                    ->orwhere('slug', 'like', '%'.$request->search.'%')
                    ->orwhere('description', 'like', '%'.$request->search.'%')
                    ->orwhere('summary', 'like', '%'.$request->search.'%')
                    ->orwhere('price', 'like', '%'.$request->search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate('9');
        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }

    public function productFilter(Request $request)
    {
        $data = $request->all();
        $queryParams = [];
    
        // Xử lý tham số 'show'
        if (!empty($data['show'])) {
            $queryParams['show'] = $data['show'];
        }
    
        // Xử lý tham số 'sortBy'
        if (!empty($data['sortBy'])) {
            $queryParams['sortBy'] = $data['sortBy'];
        }
    
        // Xử lý tham số 'category'
        if (!empty($data['category'])) {
            $queryParams['category'] = implode(',', $data['category']);
        }
    
        // Xử lý tham số 'brand'
        if (!empty($data['brand'])) {
            $queryParams['brand'] = implode(',', $data['brand']);
        }
    
        if (!empty($data['price_range'])) {
            $queryParams['price'] = $data['price_range'];
        }
    
        // Tạo query string
        $queryString = http_build_query($queryParams);
        
        $segments = request()->segments(); // ví dụ: ['product-grids', 'mens-fashion', 'jeans-pants']
        $baseRoute = $segments[0] ?? 'product-grids'; // đảm bảo không bị lỗi
    
        // Gắn route đúng với slug
        $redirectUrl = url()->to(implode('/', $segments)) . '?' . $queryString;
    
        return redirect($redirectUrl);
    }
 
    public function productCat(Request $request)
    {
        $categoryData = Category::getProductByCat($request->slug);
        $query = $categoryData->products(); // Eloquent query
    
        // Xử lý các bộ lọc (giống productFilter)
        if (!empty($request->sortBy)) {
            switch ($request->sortBy) {
                case 'price':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'title':
                    $query->orderBy('title', 'ASC');
                    break;
            }
        }
    
        if (!empty($request->category)) {
            $catIds = explode(',', $request->category);
            $query->whereIn('cat_id', $catIds); // Hoặc 'category_id' nếu đúng cột
        }
        if (!empty($request->brand)) {
            $brandSlugs = explode(',', $request->brand);
            $brandIds = Brand::whereIn('slug', $brandSlugs)->pluck('id')->toArray();
            $query->whereIn('brand_id', $brandIds);
        }
    
        if (!empty($request->price)) {
            $price = explode('-', $request->price);
            if (count($price) == 2) {
                $query->whereBetween('price', [$price[0], $price[1]]);
            }
        }
    
        $products = $query->paginate($request->show ?? 9);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
    
        if (request()->is('product-grids/*')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products'));
        }
    }
    
    public function productSubCat(Request $request)
    {
        $categoryData = Category::getProductBySubCat($request->sub_slug);
        $query = $categoryData->sub_products(); 
    
        // Bộ lọc y hệt như trên
        if (!empty($request->sortBy)) {
            switch ($request->sortBy) {
                case 'price':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'title':
                    $query->orderBy('title', 'ASC');
                    break;
            }
        }
    
        if (!empty($request->category)) {
            $catIds = explode(',', $request->category);
            $query->whereIn('cat_id', $catIds);
        }
        if (!empty($request->brand)) {
            $brandSlugs = explode(',', $request->brand);
            $brandIds = Brand::whereIn('slug', $brandSlugs)->pluck('id')->toArray();
            $query->whereIn('brand_id', $brandIds);
        }
    
        if (!empty($request->price)) {
            $price = explode('-', $request->price);
            if (count($price) == 2) {
                $query->whereBetween('price', [$price[0], $price[1]]);
            }
        }
    
        $products = $query->paginate($request->show ?? 9);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
    
        if (request()->is('product-grids/*')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products'));
        }
    }
    
    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%'.$request->search.'%')
            ->orwhere('quote', 'like', '%'.$request->search.'%')
            ->orwhere('summary', 'like', '%'.$request->search.'%')
            ->orwhere('description', 'like', '%'.$request->search.'%')
            ->orwhere('slug', 'like', '%'.$request->search.'%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category='.$category;
                } else {
                    $catURL .= ','.$category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag='.$tag;
                } else {
                    $tagURL .= ','.$tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL.$tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Logged in successfully!');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logged out successfully');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            request()->session()->flash('success', 'Registered successfully');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
            ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('frontend.pages.forgot_password');
    }

}
