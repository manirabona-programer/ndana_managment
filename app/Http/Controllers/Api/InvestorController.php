<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreInvestor;
    use App\Http\Resources\InvestorResource;
    use App\Models\Investor;

    class InvestorController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $investors = Investor::orderBy('created_at', 'desc')->get();
            return response()->json(InvestorResource::collection($investors));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param StoreInvestor $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreInvestor $request) {
            $investor = Investor::create($request->validated());

            return response()->json([
                'message' => "Investor registed successfully",
                'data' => $investor
            ], 201);
        }

        /**
         * Display the specified resource.
         *
         * @param  Investor $investor
         * @return \Illuminate\Http\Response
         */
        public function show(Investor $investor) {
            return response()->json($investor);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  Investor $investor
         * @return \Illuminate\Http\Response
         */
        public function update(StoreInvestor $request, Investor $investor) {
            $investor->update($request->validated());

            return response()->json([
                'message' => "Investor registed successfully",
                'data' => $investor
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  Investor $investor
         * @return \Illuminate\Http\Response
         */
        public function destroy(Investor $investor) {
            $investor->update([ 'active_status' => false ]);
            return response()->json([ 'message' => "Investor deleted successfully" ]);
        }
    }
