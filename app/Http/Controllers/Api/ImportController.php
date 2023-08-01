<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\ImportResource;
    use App\Models\Import;

    class ImportController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $imports = Import::with(['product'])->orderBy('created_at', 'desc')->get();
            return response()->json(ImportResource::collection($imports));
        }
    }
