<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenceRequest;
use App\Models\Expence;
    use Illuminate\Http\Request;
use Nette\Schema\Expect;

    class ExpenceController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $expences = Expence::orderBy('created_at', 'desc')->get();
            return response()->json($expences);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(ExpenceRequest $request) {
            $expence = Expence::create($request->validated());

            return response()->json([
                'message' => "Expence Recorded Successfully",
                'data' => $expence,
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(ExpenceRequest $request, Expence $expence) {
            $expence->update($request->validated());

            return response()->json([
                'message' => "Expence Recorded Updated",
                'data' => $expence,
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Expence $expence) {
            $expence->delete();
            return response()->json([ 'message' => "Expence Recorded Deleted" ]);
        }
    }
