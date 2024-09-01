<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CpmkRequest;
use App\Http\Resources\v1\CpmkResource;
use App\Models\Cpmk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpmkController extends Controller
{
    public function list(): JsonResponse {
        $cpmk = Cpmk::get();

        // return ['cpmk' => CpmkResource::collection($cpmk)];
        return response()->json([
            'cpmk' => CpmkResource::collection($cpmk)
        ], 201);
    }

    public function addCpmk(CpmkRequest $request): JsonResponse{
        
        $validatedData = $request->validated();
        $rights = json_decode(Auth::user()->rights);

        if(!in_array('buatCPMK', $rights)){
            return response()->json([
                "status" => "Gagal"
            ], 403);
        }

        $kodecpl = $validatedData['cpmk']['kodecpl'];
        $kodecpmk = $validatedData['cpmk']['kodecpmk'];
        $deskripsi = $validatedData['cpmk']['deskripsi'];

        $cpmk = new Cpmk();
        $cpmk->kode_cpl = $kodecpl;
        $cpmk->kode_cpmk = $kodecpmk;
        $cpmk->deskripsi = $deskripsi;
        $cpmk->save();

        return response()->json([
            "status" => "OK"
        ], 201);

    }

    public function removeCpmk(Request $request, $kodeCpmk): JsonResponse {

        $rights = json_decode(Auth::user()->rights);
        if(!in_array("hapusCPMK", $rights)){
            return response()->json([
                "status" => "Gagal"
            ], 403);
        }

        $validatedData = $request->validate([
            "cpmk.kodecpmk" => "required"
        ]);

        $kodecpmk = $validatedData['cpmk']['kodecpmk'];

        $isSuccess = Cpmk::where('kode_cpmk', $kodecpmk)->first();
        $isSuccess->delete();
        if(!$isSuccess){
            return response()->json([
                "status" => "Gagal"
            ], 404);
        }else {
            return response()->json([
                "status" => "OK"
            ], 201);
        }

    }

    public function updateCpmk(Request $request, $kodeCpmk): JsonResponse {

        $rights = json_decode(Auth::user()->rights);

        if(!in_array('editCPMK', $rights)){
            return response()->json([
                "status" => "Gagal"
            ], 403);
        }

        $validatedData = $request->validate([
            "cpmk.kodecpl" => "required",
            "cpmk.kodecpmk" => "required",
            "cpmk.deskripsi" => "required"
        ]);

        $kodecpl = $validatedData['cpmk']['kodecpl'];
        $kodecpmk = $validatedData['cpmk']['kodecpmk'];
        $deskripsi = $validatedData['cpmk']['deskripsi'];

        $cpmk = Cpmk::where('kode_cpmk', $kodeCpmk)->first();
        if(!$cpmk){
            return response()->json([
                "status" => "Gagal"
            ], 404);
        }
        
        if($kodecpmk != $cpmk->kode_cpmk){
            $request->validate([
                "cpmk.kodecpmk" => "unique:cpmk,kode_cpmk"
            ]);
            
            $cpmk->kode_cpmk = $kodecpmk;
        }
        
        $cpmk->kode_cpl = $kodecpl;
        $cpmk->deskripsi = $deskripsi;
        $cpmk->save();

        return response()->json([
            "status" => "OK"
        ], 201); 
        
    }

}
