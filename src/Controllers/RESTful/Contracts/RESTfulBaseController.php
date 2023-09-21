<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Controllers\RESTful\Contracts;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\BaseDTO;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * **`RESTfulBaseController`**
 *
 * This controller provides a RESTful interface for managing resources.
 * It extends the base Controller class and encapsulates common CRUD operations.
 * The controller delegates the actual implementation of the operations to a service contract.
 *
 * @property \LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonReadWriteServiceContract $restJsonReadWriteService The RESTful service contract responsible for handling CRUD operations.
 *
 * @method void __construct(\LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonReadWriteServiceContract $restJsonReadWriteService)              The constructor of the controller class creates a new instance of the controller and initializes the `$restJsonReadWriteService` property. It expects an implementation of the `RestJsonReadWriteServiceContract`, which is a contract defining the methods for performing CRUD operations on resources. This service will be used throughout the controller methods to interact with the underlying data storage.
 * @method \Illuminate\Http\JsonResponse index()                                Display a listing of the resource.
 * @method \Illuminate\Http\JsonResponse store(Request $request)                Store a newly created resource in storage.
 * @method \Illuminate\Http\JsonResponse show(string $id)                       Display the specified resource.
 * @method \Illuminate\Http\JsonResponse update(Request $request, string $id)   Update the specified resource in storage.
 * @method \Illuminate\Http\JsonResponse softDelete(string $id)                 Soft delete the specified resource.
 * @method \Illuminate\Http\JsonResponse permanentDelete(string $id)            Permanently delete the specified resource.
 * @method \Illuminate\Http\JsonResponse loadTrash()                            Load the trash and display the soft deleted resources.
 * @method \Illuminate\Http\JsonResponse restoreFromTrash(string $id)           Restore the specified soft deleted resource from the trash.
 * @method \Illuminate\Http\JsonResponse restoreAllFromTrash()                  Restore all soft deleted resources from the trash.
 * @method \Illuminate\Http\JsonResponse emptyTrash()                           Empty the trash.
 * @method \Illuminate\Http\JsonResponse deletePermanentlyFromTrash(string $id) Permanently delete the specified soft deleted resource from the trash.
 * @method \Illuminate\Http\JsonResponse deletePermanentlyAll()                 Permanently delete all resources.
 * @method \Illuminate\Http\JsonResponse search(Request $request)               Filter resources based on the provided request parameters.
 *
 * @package **`\LaravelCoreModule\CoreModuleMaker\Controllers\Contracts\RESTfulBaseController`**
 */
class RESTfulBaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The RESTful service contract responsible for handling CRUD operations.
     *
     * @var RestJsonReadWriteServiceContract
     */
    protected $restJsonReadWriteService;

    /**
     * Create a new RESTfulController instance.
     *
     * @param RestJsonReadWriteServiceContract $restJsonReadWriteService The RESTful service contract for managing resources.
     * @return void
     */
    public function __construct(RestJsonReadWriteServiceContract $restJsonReadWriteService)
    {
        $this->restJsonReadWriteService = $restJsonReadWriteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the listing of resources.
     */
    public function index(): JsonResponse
    {
        return $this->restJsonReadWriteService->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request The request object containing the data for creating the resource.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating the status of the operation.
     */
    public function store(Request $request): JsonResponse
    {
        return $this->restJsonReadWriteService->create(BaseDTO::fromRequest($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id                    The identifier of the resource to be displayed.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->findById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request The request object containing the data for updating the resource.
     * @param  string                   $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating the status of the operation.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->update($id, BaseDTO::fromRequest($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id                    The identifier of the resource to be removed.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function softDelete(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->softDelete($id);
    }

    /**
     * Permanently delete the specified soft deleted resource.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be permanently deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function permanentDelete(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDelete($id);
    }

    /**
     * Load the trash and display the soft deleted resources.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the soft deleted resources.
     */
    public function loadTrash(): JsonResponse
    {
        return $this->restJsonReadWriteService->trash();
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be restored.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function restoreFromTrash(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->restore($id);
    }

    /**
     * Restore all soft deleted resources from the trash.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function restoreAllFromTrash(): JsonResponse
    {
        return $this->restJsonReadWriteService->restoreAll();
    }

    /**
     * Empty the trash.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function emptyTrash(): JsonResponse
    {
        return $this->restJsonReadWriteService->emptyTrash();
    }

    /**
     * Delete permanently soft deleted resources from the trash.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be permanently deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function deletePermanentlyFromTrash(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDelete($id);
    }

    /**
     * Permanently Delete all resources.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function deletePermanentlyAll(): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDeleteAll();
    }

    /**
     * Filter all resources.
     *
     * @param  Request $request              The request object containing the filter parameters.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the filtered resources.
     */
    public function search(Request $request): JsonResponse
    {
        return $this->restJsonReadWriteService->search($request->all());
    }
}