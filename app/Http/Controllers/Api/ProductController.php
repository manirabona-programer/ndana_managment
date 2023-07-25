<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreProduct;
    use App\Http\Resources\ProductResource;
    use App\Models\Product;
    use App\Traits\FileStorage;

    class ProductController extends Controller {
        use FileStorage;

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $products = Product::where('active_status', true)->with(['investor'])->orderBy('created_at', 'desc')->get();
            return response()->json(ProductResource::collection($products));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreProduct $request){
            $image = $this->storeImage('products', $request->file('image'));

            $product = Product::create([
                'name' => $request->name,
                'image' => $request->hasFile('image') ? $this->storeImage('products', $request->file('image')) : "",
                'type' => $request->type,
                'category' => $request->category,
                'meta_desc' => $request->meta_desc,
                'color' => $request->color,
                'description' => $request->description,
                'investor_id' => $request->investor_id,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'message' => "Product registed successfully",
                'data' => $product
            ]);
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Product $product) {
            return response()->json($product);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(StoreProduct $request, Product $product)  {
            $product->update([
                'name' => $request->name,
                'image' => $request->hasFile('image') ? $this->storeImage('products', $request->file('image')) : $product->image,
                'type' => $request->type,
                'category' => $request->category,
                'meta_desc' => $request->meta_desc,
                'color' => $request->color,
                'description' => $request->description,
                'investor_id' => $request->investor_id,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'message' => "Product Updated successfully",
                'data' => $product
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  Product $product
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product) {
            $product->update([ 'active_status' => false ]);
            return response()->json([ 'message' => "Product Deleted Successfully "]);
        }
    }
