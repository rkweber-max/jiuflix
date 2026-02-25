<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAlunoRequest;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class AlunoController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $typeGraduation = $request->input('type_graduation');

        $aluno = Aluno::create(['id' => $id, 'name' => $name, 'type_graduation' => $typeGraduation]);

        Log::channel('json')->info('User created successfuly', ['message' => 'User created successfuly']);

        return new JsonResponse($aluno, JsonResponse::HTTP_CREATED);
    }

    public function getAll()
    {
        $alunos = Aluno::all()->toArray();

        return new JsonResponse(['Alunos' => $alunos, 'message' => 'Alunos retornados com sucesso!'], JsonResponse::HTTP_OK);
    }

    public function show($id)
    {
        $aluno = Aluno::getById($id);

        if ($aluno == null) {
            return new JsonResponse(['id' => $id, 'message' => 'Aluno não encontrado!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['id' => $aluno->id, 'message' => 'Aluno encontrado com sucesso!'], JsonResponse::HTTP_OK);
    }

    public function deleted($id)
    {
        $aluno = Aluno::destroy($id);

        if ($aluno == null) {
            return new JsonResponse(['id' => $id, 'message' => 'Aluno não encontrado!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['id' => $id, 'message' => 'Aluno deletado com sucesso!'], JsonResponse::HTTP_ACCEPTED);
    }

    public function updated(UpdateAlunoRequest $request, $id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return new JsonResponse(
                ['id' => $id, 'message' => 'Aluno não encontrado!'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $aluno->update($request->validated());

        return new JsonResponse(['id' => $id, 'name' => $aluno->name, 'type_graduation' => $aluno->type_graduation], JsonResponse::HTTP_ACCEPTED);
    }
}
