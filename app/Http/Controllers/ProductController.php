<?php

namespace App\Http\Controllers;

use App\Repository\IProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $product;
    public function __construct(IProductRepository $product)
    {
        $this->product = $product;
    }
    public function index(){
          $products =  $this->product->getAllProducts();
            return view('product.index',get_defined_vars());
    }
    public function create(){
        return view('product.create');
    }
    public function store(Request $request){
            $request->validate([
                'picture' => 'required',
                'title' => 'required',
                'price' => 'required',
                'description' => 'required'
            ]);
            $data = $request->all();
            // picture upload
            if( $image = $request->file('picture')){
                $name = time().".".$image->getClientOriginalName();
                $image->move(public_path('images'),$name);
                $data['picture'] = "$name";
            }
            $this->product->createProduct($data);
            return redirect('/');
    }
    public function show($id){
      $product = $this->product->getSingleProduct($id);
        return view('product.show',get_defined_vars());
    }
    public function edit($id){
      $product = $this->product->editProduct($id);
        return view('product.edit',get_defined_vars());
    }
    public function update($id, Request $request){
        $request->validate([
            'picture' => 'required',
            'title' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        $data = $request->all();
        // picture upload
        if( $image = $request->file('picture')){
            $name = time().".".$image->getClientOriginalName();
            $image->move(public_path('images'),$name);
            $data['picture'] = "$name";
        }
        $product = $this->product->updateProduct($id,$data);
        return redirect('/');
      }
      public function delete($id){
        $product = $this->product->deleteProduct($id);
        return redirect('/');
      }
}
