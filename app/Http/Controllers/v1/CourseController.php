<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CourseRequest;
use App\Http\Resources\v1\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PSpell\Config;

class CourseController extends Controller
{
    
    public function listCourse(): JsonResponse{
        $courses = Course::get();

        return response()->json([
            'mk' => CourseResource::collection($courses) 
        ], 201);
    }

    public function addCourse(CourseRequest $request): JsonResponse{

        $validatedData = $request->validated();
        
        $namamk = $validatedData['mk']['namamk'];
        $kodemk = $validatedData['mk']['kodemk'];
        $sks = $validatedData['mk']['sks'];

        $course = Course::create([
            'kode_mk' => $kodemk,
            'nama_mk' => $namamk,
            'sks' => $sks
        ]);

        if(!$course){
            return response()->json([
                "status" => "Gagal"
            ], 404);
        }else{
            return response()->json([
                "status" => "OK"
            ], 201);
        }

    }

    public function removeCourse(Request $request): JsonResponse {

        $validatedData = $request->validate([
            "mk.kodemk" => "required",
        ]);

        $kodemk = $validatedData['mk']['kodemk'];

        $isSuccess = Course::where('kode_mk', $kodemk)->delete();

        if($isSuccess){
            return response()->json([
                "status" => "OK"
            ], 201);
        }else {
            return response()->json([
                "status" => "Gagal"
            ], 404);
        }

    }

    public function updateCourse(Request $request, $kodeMk): JsonResponse {

        $validatedData = $request->validate([
            "mk.kodemk" => "required",
            "mk.namamk" => "required",
            "mk.sks" => "required"
        ]);

        $kodemk = $validatedData['mk']['kodemk'];
        $namamk = $validatedData['mk']['namamk'];
        $sks = $validatedData['mk']['sks'];

        $mk = Course::where('kode_mk', $kodeMk)->first();
        
        if(!$mk){
            return response()->json([
                "status" => "Gagal"
            ], 404);
        }

        if($kodeMk != $mk->kode_mk){
            $request->validate([
                "mk.kodemk" => "unique:course,kode_mk"
            ]);

            $mk->kode_mk = $kodemk;
        }

        $mk->nama_mk = $namamk;
        $mk->sks = $sks;
        $mk->save();

        return response()->json([
            "status" => "OK"
        ], 201);

    }

}
