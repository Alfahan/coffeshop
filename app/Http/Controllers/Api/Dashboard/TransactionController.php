<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transactions::with("product", "user")
            ->when(request()->q, function ($transactions) {
                $transactions = $transactions->where("name", "like", "%" . request()->q . "%");
            })
            ->latest()
            ->paginate(5);

        //return with Api Resource
        return ResponseFormatter::success($transactions, "Data Post berhasil di dapatkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Transactions::with("product")->whereId($id)->first();

        if ($product) {
            //return success with Api Resource
            return ResponseFormatter::success($product, "Detail Data Post");
        }

        //return failed with Api Resource
        return ResponseFormatter::error(null, "Detail Data Post Tidak DItemukan!", 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transactions $transaction)
    {
        $validator = Validator::make($request->all(), [
            "status" => "required|unique:transactions,status," . $transaction->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction->update([
            "status" => $request->status,
        ]);

        $transaction->save();

        if ($transaction) {
            //return success with Api Resource
            return ResponseFormatter::success($transaction, "Data Post Berhasil Diupdate!");
        }

        //return failed with Api Resource
        return ResponseFormatter::error(null, "Data Post Gagal Diupdate!", 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transaction)
    {
        if ($transaction->delete()) {
            //return success with Api Resource
            return ResponseFormatter::success(null, "Data Post Berhasil Dihapus!");
        }

        //return failed with Api Resource
        return ResponseFormatter::error(null, "Data Post Gagal Dihapus!", 500);
    }
}
