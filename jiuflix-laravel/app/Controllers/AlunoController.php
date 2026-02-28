<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassmateRequest;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Enums\Strips;
use Illuminate\Validation\Rule;

class AlunoController extends Controller
{
    public function create(ClassmateRequest $request)
    {
        $name = $request->input('name');
        $typeGraduation = $request->input('type_graduation');

        $aluno = Aluno::create(['name' => $name, 'type_graduation' => $typeGraduation]);

        Log::info('controller.classmate.created', ['message' => 'Classmate created successfuly']);

        return new JsonResponse($aluno, JsonResponse::HTTP_CREATED);
    }

    public function getAll()
    {
        $alunos = Aluno::all()->toArray();

        Log::info('controller.classmate.get_all', ['message' => 'Classmates founded']);

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

    public function updated(ClassmateRequest $request, $id)
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
