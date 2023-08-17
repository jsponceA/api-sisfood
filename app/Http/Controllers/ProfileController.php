<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */

    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail(auth()->user()->id);

        return response()->json([
            "user" => $user
        ], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(ProfileFormRequest $request, int $id): JsonResponse
    {
        $data = $request->all();

        $user = User::query()->findOrFail(auth()->user()->id);

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
            "user" => $user->load(["rol","branch"])
        ], Response::HTTP_OK);
    }
}
