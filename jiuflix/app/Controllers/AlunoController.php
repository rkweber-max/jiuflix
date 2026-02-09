<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AlunoController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $typeGraduation = $request->input('type_graduation');

        $aluno = Aluno::create(['id' => $id, 'name' => $name, 'type_graduation' => $typeGraduation]);

        return new JsonResponse($aluno, JsonResponse::HTTP_CREATED);
    }

    public function getAll () {
        $aluno = Aluno::all();

        return new JsonResponse($aluno, JsonResponse::HTTP_OK);
    }
}