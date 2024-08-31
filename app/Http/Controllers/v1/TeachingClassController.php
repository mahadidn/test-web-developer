<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TeachingClassResource;
use App\Models\TeachingClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachingClassController extends Controller
{
    
    public function getTeachingClass(Request $request): JsonResponse{

        $classes = TeachingClass::where('user_id', Auth::user()->id)->get();
        
        $classNames = $classes->map(function ($class) {
            return $class->class_name;
        });

        return response()->json([
            'class' => $classNames->all()
        ], 200);
    }

}
