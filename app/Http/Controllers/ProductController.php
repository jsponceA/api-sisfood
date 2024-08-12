<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input("page");
        $perPage = $request->input("perPage");
        $search = trim($request->input("search"));
        $paginated = $request->input("paginated",true);

        $products = Product::query()
            ->with(["category"])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where("name", "LIKE", "%{$search}%")
                    ->orWhere("barcode", "LIKE", "%{$search}%");
            })
            ->orderByDesc("id")
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json([
            "products" => $products
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request): JsonResponse
    {
        $data = $request->all();

        if ($request->hasFile("image")){
            $data["image"] = basename(Storage::putFile("products",$request->file("image")));
        }
        $product = Product::query()->create($data);

        Product::query()->where("id",$product->id)
            ->update(["barcode"=>$this->generateBarCode($product->id,$product->created_at)]);

        return response()->json([
            "message" => "Producto creado satisfactoriamente"
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::query()->findOrFail($id);

        return response()->json([
            "product" => $product
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, int $id): JsonResponse
    {
        $data = $request->all();
        $product = Product::query()->findOrFail($id);
        if ($request->hasFile("image")){
            Storage::delete("products/{$product->image}");
            $data["image"] = basename(Storage::putFile("products",$request->file("image")));
        }else{
            unset($data["image"]);
        }
        $data["barcode"] = $this->generateBarCode($product->id,$product->created_at);
        $product->update($data);

        return response()->json([
            "message" => "Producto modificado satisfactoriamente",
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::query()->findOrFail($id);
        $product->delete();

        Storage::delete("products/{$product->image}");
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get All resource for all actions
     */

    public function searchOneProduct(Request $request)
    {
        $search = trim($request->input("search"));

        $product = Product::query()
            ->where("barcode", $search)
            ->orWhere("name", $search)
            ->first();

        return response()->json([
            "product" => $product
        ], Response::HTTP_OK);
    }

    public function searchSensitive(Request $request)
    {
        $search = trim($request->input("search"));

        $products = Product::query()
            ->where("barcode", "LIKE","%{$search}%")
            ->orWhere("name", "LIKE","%{$search}%")
            ->orderByDesc("id")
            ->take(5)
            ->get();

        return response()->json([
            "products" => $products
        ], Response::HTTP_OK);
    }

    public function productsFilters(Request $request){

        $search = trim($request->input("search"));
        $selectedFoodType = $request->input("selectedFoodType");

        $products = Product::query()
            ->with(["category"])
            ->whereHas("category",function ($q) use ($selectedFoodType){
                $q->where("name",$selectedFoodType);
            })
            ->orderBy("id")
            ->get();

        return response()->json([
            "products" => $products
        ], Response::HTTP_OK);
    }
    public function generateBarCode(int $id, $created_at)
    {
        return $id.now()->parse($created_at)->format("dmy");
    }

    public function updateBarCodes()
    {
        /*$products = Product::query()->get();
        foreach ($products as $p) {
            $p = Product::query()->findOrFail($p->id);
            $p->barcode = $this->generateBarCode($p->id,$p->created_at);
            $p->update();
        }*/
    }

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("categories", $resourceTypes)) {
            $response["categories"] = Category::query()
                ->orderBy("id","ASC")
                ->get();
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
