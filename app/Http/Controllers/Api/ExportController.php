<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\ExportProductRequest;
    use App\Models\Export;
    use App\Models\Product;

    class ExportController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $exports = Export::with(['product'])->orderBy('created_at', 'desc')->get();
            return response()->json($exports);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(ExportProductRequest $request) {
            $product = Product::where('id', $request->product_id)->first();

            if($request->quantity <= $product->quantity) {
                $export = Export::create($request->validated());

                return response()->json([
                    'message' => "Product Exported",
                    'data' => $export
                ]);
            }

            return response()->json([
                'message' => "The provided quality is outside the current product quality - remains $product->quantity"
            ], 400);
        }
    }
