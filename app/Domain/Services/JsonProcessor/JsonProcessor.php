<?php
/**
 * Created by PhpStorm.
 * User: lacasera
 * Date: 12/29/18
 * Time: 5:09 PM
 */
namespace App\Domain\Services\JsonProcessor;

use Illuminate\Support\Facades\Storage;

class JsonProcessor
{
    protected $path = 'products.json';

    public function create(array $product, $id = null)
    {
        try {
            if (is_null($id)){
                $product['id'] = rand(1, 100000000);
            }
            $product['created_at'] = date('Y-m-d H:i:s');

            $products = $this->getProducts();

            array_push($products,$product);

            Storage::disk('local')->put($this->path, json_encode($products));

           return $this->getProducts();

        } catch(\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * @return array
     */
    public function getProducts() : array
    {
        return Storage::disk('local')->exists($this->path)
            ? json_decode(Storage::disk('local')->get($this->path)) : [];
    }

    public function getProduct($id)
    {
        $products = $this->getProducts();

        foreach ($products as $product){
            if ($product->id == $id){
                return $product;
            } else {
                return  (object) [];
            }
        }
    }
    public function updateProduct($data, $id)
    {
        $products = $this->getProducts();
        foreach ($products as $product){
            if ($product->id == $id){
                 $product->name = $data['name'];
                 $product->quantity = $data['quantity'];
                 $product->price = $data['price'];
            } else {
                return  (object) [];
            }
        }
        Storage::disk('local')->put($this->path, json_encode($products));

        return $this->getProduct($id);
    }

}