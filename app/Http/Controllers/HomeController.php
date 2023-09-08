<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use DataTables;

class HomeController extends Controller
{
    public function index(Request $request){
        $data =Product::query()->orderBy('id', 'desc');
        if ($request->ajax()) {
            return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $url= asset('storage/'.$data->image);
                return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" title="Edit Content" data-toggle="tooltip" data-id="'.$row->id.'" class="edit" > <button class="btn btn-outline-primary btn-sm">
                Edit</i>
                </button> </a>';
                $btn =$btn.'<a href="javascript:void(0)" title="Delete Content" data-toggle="tooltip" data-id="'.$row->id.'" class="delete" > <button class="btn btn-outline-danger btn-sm">
                Delete
                </button> </a>';
                return $btn;
            })->rawColumns(['image','action'])
              ->make(true);
        }
        return view('index');
    }

    public function create(Request $request){
        return view('create');
    }

    public function insert_product(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            'image'=>'required',
        ]);

        $data = new Product();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;
        $image_path = $request->file('image')->store('image', 'public');
        $data->image  = $image_path;
        $data->save();
        return redirect('/');
    }


    public function editProduct($id){
        $data = Product::find($id);
        return view('edit', compact('data'));
    }

    public function updateProduct(Request $request , $id ){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',

        ]);

        $data=Product::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;

        if($request->hasFile('image')){
          $path='storage/'.$data->image;
          if(File::exists($path)) {
              File::delete($path);
          }
          $image=$request->image;
          if($image){
            $image_path = $request->file('image')->store('image', 'public');
            $data->image  = $image_path;
          }
        }

        $data->save();
        return redirect('/');
    }
    public function deleteProduct(Request $request) {
        $id=$request->product_id;
        $data=Product::find($id);
        if($data->image){
            $path='storage/'.$data->image;
            if(File::exists($path)) {
                File::delete($path);
            }
          }
        $data->delete();
        return response()->json([
         'status' => 'success',
        ]);
    }

       // public function deleteCategory( Request $request ){
    //     $id=$request->category_id;
    //     $data=Category::find($id);
    //     $data->delete();
    //     return response()->json([
    //      'status' => 'success',
    //     ]);

    //  }

}
