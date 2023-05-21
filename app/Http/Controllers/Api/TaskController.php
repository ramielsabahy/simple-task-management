<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateTaskRequest;
use App\Http\Requests\Tasks\ListTasksRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Repositories\Task\TaskRepository;
use App\Services\DeleteTaskService;
use App\Services\ListTasksService;
use App\Services\StatusUpdatedEmailService;
use App\Services\StoreTaskService;
use App\Services\TaskDetailsService;
use App\Services\UpdateTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $repository;

    /**
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateTaskRequest $request
     * @param StoreTaskService $storeTaskService
     * @return JsonResponse
     */
    public function store(CreateTaskRequest $request, StoreTaskService $storeTaskService) : JsonResponse
    {
        $task = $storeTaskService->store($request->only('title','description','due_date','status'));
        return customResponse(new TaskResource($task), "Task created successfully", 200);
    }

    /**
     * @param ListTasksService $listTasksService
     * @return JsonResponse
     */
    public function index(ListTasksService $listTasksService, ListTasksRequest $request) : JsonResponse
    {
        $tasks = $listTasksService->all($request);
        return customResponse(TaskResource::collection($tasks));
    }

    /**
     * @param $id
     * @param TaskDetailsService $taskDetailsService
     * @return JsonResponse
     */
    public function show($id, TaskDetailsService $taskDetailsService) : JsonResponse
    {
        $task = $taskDetailsService->find($id);
        if ($task)
            return customResponse(new TaskResource($task));
        return customResponse((object)[], "Task not found", 404);
    }

    /**
     * @param $id
     * @param UpdateTaskRequest $request
     * @param UpdateTaskService $updateTaskService
     * @return JsonResponse
     */
    public function update($id, UpdateTaskRequest $request, UpdateTaskService $updateTaskService, StatusUpdatedEmailService $emailService) : JsonResponse
    {
        $updated = $updateTaskService->update($id, $request->only('title','description','due_date','status'));
        if ($updated){
            if (isset($request->status))
                $emailService->send($id);
            return customResponse((object)[], "Task updated successfully", 200);
        }
        return customResponse((object)[], "No task found for you with this id", 404);
    }

    /**
     * @param $id
     * @param UpdateTaskRequest $request
     * @param UpdateTaskService $updateTaskService
     * @return JsonResponse
     */
    public function toggleStatus($id, UpdateTaskRequest $request, UpdateTaskService $updateTaskService) : JsonResponse
    {
        $toggled = $updateTaskService->update($id, $request->only('status'));
        if ($toggled)
            return customResponse((object)[], "Status updated successfully", 200);
        return customResponse((object)[], "No task found for you with this id", 404);
    }

    /**
     * @param $id
     * @param DeleteTaskService $deleteTaskService
     * @return JsonResponse
     */
    public function destroy($id, DeleteTaskService $deleteTaskService)
    {
        $deleted = $deleteTaskService->destroy($id);
        if ($deleted)
            return customResponse((object)[], "Task deleted successfully", 200);
        return customResponse((object)[], "No task found for you with this id", 404);
    }
}
