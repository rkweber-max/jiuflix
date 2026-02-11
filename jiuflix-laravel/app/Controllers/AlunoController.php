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

    public function show($id) {
        $aluno = Aluno::getById($id);

        return new JsonResponse($aluno, JsonResponse::HTTP_OK);
    }

    public function deleted($id) {
        $aluno = Aluno::destroy($id);

        return new JsonResponse($aluno, JsonResponse::HTTP_ACCEPTED);
    }

    public function updated (Request $request, $id) {
        $aluno = Aluno::find($id);

        $aluno->name = $request->input('name');
        $aluno->type_graduation = $request->input('type_graduation');

        $aluno->save();

        return new JsonResponse($aluno, JsonResponse::HTTP_ACCEPTED);
    }
}