<?php

declare(strict_types = 1);

namespace {{namespace}};

use LaravelCoreModule\CoreModuleMaker\Controllers\RESTful\Contracts\RESTfulBaseController;
use {{requestNamespace}}\Create{{resourceName}}Request;
use {{requestNamespace}}\Update{{resourceName}}Request;
use Illuminate\Http\JsonResponse;
use {{resourceNamespace}}\RESTful\Contracts\{{resourceName}}RESTfulReadWriteServiceContract;

/**
 * **`{{resourceController}}`**
 * Controller for managing {{module}} resources.
 * This controller extends the RESTfulController and provides CRUD operations for {{module}} resources.
 *
 * @method \Illuminate\Http\JsonResponse store{{resourceName}}(\{{requestNamespace}}\Create{{resourceName}}Request $request)                     Store a newly created {{module}}.
 * @method \Illuminate\Http\JsonResponse update{{resourceName}}(\{{requestNamespace}}\Update{{resourceName}}Request $request, string $id)        Update an existing {{module}} resource.
 * @package **`\{{namespace}}`**
 */
class {{resourceController}} extends RESTfulBaseController
{
    /**
     * The {{resourceName}} RESTful Read-Write Service instance.
     *
     * @var {{resourceNamespace}}\RESTful\Contracts\{{resourceName}}RESTfulReadWriteServiceContract
     */
    protected ${{module}}RESTfulReadWriteService;

    /**
     * Create a new {{resourceController}} instance.
     *
     * @param \{{resourceNamespace}}\RESTful\Contracts\{{resourceName}}RESTfulReadWriteServiceContract ${{module}}RESTfulReadWriteService The {{resourceName}} RESTful Read-Write Service instance.
     */
    public function __construct({{resourceName}}RESTfulReadWriteServiceContract ${{module}}RESTfulReadWriteService)
    {
        parent::__construct(${{module}}RESTfulReadWriteService);

        $this->{{module}}RESTfulReadWriteService = ${{module}}RESTfulReadWriteService;
    }

    /**
     * Store a newly created {{module}}.
     *
     * @param  \{{requestNamespace}}\Create{{resourceName}}Request $request The request object containing the data for creating the {{module}}.
     * @return \Illuminate\Http\JsonResponse                                     The JSON response indicating the status of the operation.
     *
     * @throws \Illuminate\Validation\ValidationException                        If the validation fails for the request.
     */
    public function store{{resourceName}}(Create{{resourceName}}Request $request): JsonResponse
    {
        // Use the {{module}}RESTfulReadWriteService to create the {{module}}.
        return $this->{{module}}RESTfulReadWriteService->create($request->getDto());
    }

    /**
     * Update an existing {{module}} resource.
     *
     * @param  \{{requestNamespace}}\Update{{resourceName}}Request $request The request object containing the data for updating the {{module}}.
     * @param  string $id                                                        The identifier of the {{module}} resource to be updated.
     * @return \Illuminate\Http\JsonResponse                                     The JSON response indicating the status of the operation.
     *
     * @throws \Illuminate\Validation\ValidationException                        If the validation fails for the request.
     */
    public function update{{resourceName}}(Update{{resourceName}}Request $request, string $id): JsonResponse
    {
        // Update the {{module}} using the {{module}}RESTfulReadWriteService and pass the DTO instance
        return $this->{{module}}RESTfulReadWriteService->update($id, $request->getDto());
    }
}
