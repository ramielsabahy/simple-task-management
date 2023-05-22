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
     * @var StoreTaskService
     */
    private StoreTaskService $storeTaskService;
    /**
     * @var ListTasksService
     */
    private ListTasksService $listTasksService;
    /**
     * @var TaskDetailsService
     */
    private TaskDetailsService $taskDetailsService;
    /**
     * @var UpdateTaskService
     */
    private UpdateTaskService $updateTaskService;
    /**
     * @var DeleteTaskService
     */
    private DeleteTaskService $deleteTaskService;


    /**
     * @param StoreTaskService $storeTaskService
     * @param ListTasksService $listTasksService
     * @param TaskDetailsService $taskDetailsService
     * @param UpdateTaskService $updateTaskService
     * @param DeleteTaskService $deleteTaskService
     */
    public function __construct(
        StoreTaskService $storeTaskService,
        ListTasksService $listTasksService,
        TaskDetailsService $taskDetailsService,
        UpdateTaskService $updateTaskService,
        DeleteTaskService $deleteTaskService
    )
    {
        $this->storeTaskService = $storeTaskService;
        $this->listTasksService = $listTasksService;
        $this->taskDetailsService = $taskDetailsService;
        $this->updateTaskService = $updateTaskService;
        $this->deleteTaskService = $deleteTaskService;
    }

    /**
     * @param CreateTaskRequest $request
     * @return JsonResponse
     */
    public function store(CreateTaskRequest $request) : JsonResponse
    {
        $task = $this->storeTaskService->store($request->only('title','description','due_date','status'));
        return customResponse(new TaskResource($task), "Task created successfully", 200);
    }

    /**
     * @return JsonResponse
     */
    public function index(ListTasksRequest $request) : JsonResponse
    {
        $tasks = $this->listTasksService->all($request);
        return customResponse(TaskResource::collection($tasks));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $task = $this->taskDetailsService->find($id);
        if ($task)
            return customResponse(new TaskResource($task));
        return customResponse((object)[], "Task not found", 404);
    }

    /**
     * @param $id
     * @param UpdateTaskRequest $request
     * @return JsonResponse
     */
    public function update($id, UpdateTaskRequest $request, StatusUpdatedEmailService $emailService) : JsonResponse
    {
        $updated = $this->updateTaskService->update($id, $request->only('title','description','due_date','status'));
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
     * @return JsonResponse
     */
    public function toggleStatus($id, UpdateTaskRequest $request) : JsonResponse
    {
        $toggled = $this->updateTaskService->update($id, $request->only('status'));
        if ($toggled)
            return customResponse((object)[], "Status updated successfully", 200);
        return customResponse((object)[], "No task found for you with this id", 404);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $deleted = $this->deleteTaskService->destroy($id);
        if ($deleted)
            return customResponse((object)[], "Task deleted successfully", 200);
        return customResponse((object)[], "No task found for you with this id", 404);
    }
}
