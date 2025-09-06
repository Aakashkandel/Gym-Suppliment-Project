<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        $categories=Category::orderby('priority')->get();
        return view('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)


    {
      
 
       
        $data=$request->validate([
            'name'=>'required|max:255',
            'image'=>'required|image',
            'title'=>'required|max:50',
            'description'=>'required',
            'price'=>'required|integer|min:0',
            'stock'=>'required|integer|min:1',
            'category_id'=>'required',
            'user_id'=>'required',
        
           

        ]);

        $imagepath=time().'.'.$request->image->extension();
        $request->image->move(public_path('images/product'),$imagepath);
        $data['image']=$imagepath;
        Product::create($data);

        return redirect()->route('admin.product.index')->with('success',"Product Added Successfully");

        



       
        
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
        $product=Product::find($id);
        $categories=Category::orderby('priority')->get();
        return view('admin.product.edit',compact('product','categories'));
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
        $product=Product::find($id);
         
        $data=$request->validate([
            'name'=>'required|max:255',
            'image'=>'image',
            'title'=>'required|max:50',
            'description'=>'required',
            'price'=>'required|integer|min:0',
            'stock'=>'required|integer|min:1',
            'category_id'=>'required',
            'user_id'=>'required',
        
           

        ]);
        $data['image'] = $product->image;
        if($request->hasFile('image')){
            $photoname = time().'.'.$request->photopath->extension();
            $request->photopath->move(public_path('images/products'), $photoname);
            //delete old photo
            File::delete(public_path('images/product/'.$product->image));
            // unlink(public_path('images/products/'.$product->photopath));
            $data['image'] = $photoname;
        }
        $product->update($data);
        return redirect()->route('admin.product.index')->with('success','Product updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('admin.product.index')->with('success',"Product Deleted Successfully");
    }
}
