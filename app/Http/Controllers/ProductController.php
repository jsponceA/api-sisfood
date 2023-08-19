<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        $products = Product::query()
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

        $product = Product::query()->create($data);

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
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get All resource for all actions
     */

    public function searchSensitive(Request $request)
    {
        $search = trim($request->input("search"));

        $products = Product::query()
            ->where("barcode", $search)
            ->orWhere("name", $search)
            ->orderByDesc("id")
            ->take(10)
            ->get();

        return response()->json([
            "products" => $products
        ], Response::HTTP_OK);
    }

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("categories", $resourceTypes)) {
            $response["categories"] = ["BEBIDAS","COMIDAS","SNACK","EXTRAS"];
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
