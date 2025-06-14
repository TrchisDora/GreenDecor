<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand=Brand::orderBy('id','DESC')->get();
        return view('backend.brand.index')->with('brands',$brand);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input data
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'photo' => 'required|string',  // Assuming the photo is a string (URL or path)
            'status' => 'required|in:active,inactive',
        ]);

        // Get input data
        $data = $request->all();

        // Process slug for the brand
        $slug = Str::slug($request->title);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . now()->format('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        // Create a new brand
        $status = Brand::create($data);

        // Check result and flash message
        if ($status) {
            request()->session()->flash('success', 'Brand created successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        // Redirect to the brand list page
        return redirect()->route('brand.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('backend.brand.edit')->with('brand',$brand);
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
        // Find the brand by ID
        $brand = Brand::find($id);

        // Validate incoming request
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'photo' => 'nullable|string', // Validate photo as a string (URL or path)
            'status' => 'required|in:active,inactive',
        ]);

        // Get all the input data
        $data = $request->all();

        // If there's a photo URL provided, use it
        if ($request->has('photo') && $request->photo) {
            $data['photo'] = $request->photo; // Update the photo URL/path
        }

        // Update the brand data
        $status = $brand->fill($data)->save();

        // Check if the update was successful and set session messages
        if ($status) {
            request()->session()->flash('success', 'Brand updated successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        // Redirect back to the brand index page
        return redirect()->route('brand.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::find($id);
        if($brand){
            $status=$brand->delete();
            if($status){
                request()->session()->flash('success','Brand deleted successfully');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('brand.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
