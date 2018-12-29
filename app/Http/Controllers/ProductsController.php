<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\JsonProcessor\JsonProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class ProductsController extends Controller
{
    protected $jsonProcessor;

    public function __construct(JsonProcessor $jsonProcessor)
    {
        $this->jsonProcessor = $jsonProcessor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products =  $this->jsonProcessor->getProducts();
        return response()->json(['data' => $products], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|integer'
        ]);
        $products = $this->jsonProcessor->create($request->all());
        return response()->json(['data' => $products], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->jsonProcessor->getProduct($id);
        return response()->json(['data' => $product], 200);
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
      $product = $this->jsonProcessor->updateProduct($request->all(), $id);
        return response()->json(['data' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
