<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input("page");
        $perPage = $request->input("perPage");
        $search = trim($request->input("search"));

        $users = User::query()
            ->with(["rol", "branch"])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where("username", "LIKE", "%{$search}%")
                    ->orWhere("username", "LIKE", "%{$search}%");
            })
            ->orderByDesc("id")
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json([
            "users" => $users
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request): JsonResponse
    {
        $data = $request->all();

        if ($request->hasFile("photo")) {
            $nameImage = Storage::putFile("users", $request->file("photo"));
            $data["photo"] = basename($nameImage);
        }
        $user = User::query()->create($data);

        return response()->json([
            "message" => "Usuario creado satisfactoriamente"
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        return response()->json([
            "user" => $user
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, int $id): JsonResponse
    {
        $data = $request->all();

        $user = User::query()->findOrFail($id);

        if ($request->hasFile("photo")) {
            Storage::delete("users/" . $user->photo);
            $nameImage = Storage::putFile("users", $request->file("photo"));
            $data["photo"] = basename($nameImage);
        }else{
            unset($data["photo"]);
        }

        if (empty($data["password"])){
            unset($data["password"]);
        }

        $user->update($data);

        return response()->json([
            "message" => "Usuario modificado satisfactoriamente",
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        Storage::delete("users/" . $user->photo);
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get All resource for all actions
     */

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("roles", $resourceTypes)) {
            $response["roles"] = Role::query()->orderByDesc("id")->get();
        }
        if (in_array("branches", $resourceTypes)) {
            $response["branches"] = Branch::query()->orderByDesc("id")->get();
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
