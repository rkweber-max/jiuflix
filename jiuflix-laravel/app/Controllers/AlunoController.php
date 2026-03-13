<?php

namespace App\Controllers;

use App\DTO\Request\ClassmateRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassmateRequest;
use App\Models\Aluno;
use App\Repository\AlunoCsvRepository;
use App\Repository\AlunoEloquentRepository;
use App\Repository\AlunoTxtRepository;
use App\Services\AlunoService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class AlunoController extends Controller
{
    public function create(ClassmateRequest $request)
    {
        Log::info('controller.classmate.create.start', [
            'message' => 'Starting classmate creation',
            'request_data' => $request->only(['name', 'type_graduation'])
        ]);

        $dto = ClassmateRequestDTO::fromRequest($request);

        try {
            $arrayClassmate = [
                'name' => $dto->name,
                'type_graduation' => $dto->typeGraduation->value,
                'age' => $dto->age,
                'gender' => $dto->gender,
                'category' => $dto->category
            ];

            $repository = new AlunoTxtRepository();

            $service = new AlunoService();
            $service->setRepository($repository);
            $aluno = $service->createAluno($arrayClassmate);

            Log::info('controller.classmate.create.success', [
                'message' => 'Classmate created successfully',
                'payload' => [
                    'name' => $aluno->name,
                    'type_graduation' => $aluno->typeGraduation->value,
                    'age' => $aluno->age,
                    'gender' => $aluno->gender,
                    'category' => $aluno->category,
                    'id' => $aluno->id,
                ]
            ]);

            return new JsonResponse($aluno->toArray(), JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('controller.classmate.create.error', [
                'message' => 'Failed to create classmate',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getAll()
    {
        Log::info('controller.classmate.get_all.start', [
            'message' => 'Starting to fetch all classmates'
        ]);

        try {
            $alunos = Aluno::all()->toArray();

            Log::info('controller.classmate.get_all.success', [
                'message' => 'Classmates fetched successfully',
                'total_count' => count($alunos)
            ]);

            return new JsonResponse(['Alunos' => $alunos, 'message' => 'Alunos retornados com sucesso!'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('controller.classmate.get_all.error', [
                'message' => 'Failed to fetch classmates',
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function show($id)
    {
        Log::info('controller.classmate.show.start', [
            'message' => 'Starting to fetch classmate by ID',
            'classmate_id' => $id
        ]);

        try {
            $aluno = Aluno::getById($id);

            if ($aluno == null) {
                Log::warning('controller.classmate.show.not_found', [
                    'message' => 'Classmate not found',
                    'classmate_id' => $id
                ]);
                return new JsonResponse(['id' => $id, 'message' => 'Aluno não encontrado!'], JsonResponse::HTTP_NOT_FOUND);
            }

            Log::info('controller.classmate.show.success', [
                'message' => 'Classmate fetched successfully',
                'classmate_id' => $aluno->id,
                'classmate_name' => $aluno->name
            ]);

            return new JsonResponse(['id' => $aluno->id, 'message' => 'Aluno encontrado com sucesso!'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('controller.classmate.show.error', [
                'message' => 'Failed to fetch classmate',
                'classmate_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function deleted($id)
    {
        Log::info('controller.classmate.delete.start', [
            'message' => 'Starting to delete classmate',
            'classmate_id' => $id
        ]);

        try {
            $aluno = Aluno::destroy($id);

            if ($aluno == null) {
                Log::warning('controller.classmate.delete.not_found', [
                    'message' => 'Classmate not found for deletion',
                    'classmate_id' => $id
                ]);
                return new JsonResponse(['id' => $id, 'message' => 'Aluno não encontrado!'], JsonResponse::HTTP_NOT_FOUND);
            }

            Log::info('controller.classmate.delete.success', [
                'message' => 'Classmate deleted successfully',
                'classmate_id' => $id
            ]);

            return new JsonResponse(['id' => $id, 'message' => 'Aluno deletado com sucesso!'], JsonResponse::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            Log::error('controller.classmate.delete.error', [
                'message' => 'Failed to delete classmate',
                'classmate_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function updated(ClassmateRequest $request, $id)
    {
        Log::info('controller.classmate.update.start', [
            'message' => 'Starting to update classmate',
            'classmate_id' => $id,
            'request_data' => $request->validated()
        ]);

        try {
            $aluno = Aluno::find($id);

            if (!$aluno) {
                Log::warning('controller.classmate.update.not_found', [
                    'message' => 'Classmate not found for update',
                    'classmate_id' => $id
                ]);
                return new JsonResponse(
                    ['id' => $id, 'message' => 'Aluno não encontrado!'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }

            $aluno->update($request->validated());

            Log::info('controller.classmate.update.success', [
                'message' => 'Classmate updated successfully',
                'classmate_id' => $id,
                'updated_data' => [
                    'name' => $aluno->name,
                    'type_graduation' => $aluno->type_graduation
                ]
            ]);

            return new JsonResponse(['id' => $id, 'name' => $aluno->name, 'type_graduation' => $aluno->type_graduation], JsonResponse::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            Log::error('controller.classmate.update.error', [
                'message' => 'Failed to update classmate',
                'classmate_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
