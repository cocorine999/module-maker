<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\Manager;


/**
 * Class `AbstractService`
 *
 * The AbstractService class provides a base implementation for service classes.
 * It defines common properties and methods that can be used by concrete service classes.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Services\Manager
 */
abstract class AbstractService
{
    /**
     * The repository associated with the service.
     *
     * @var object
     */
    protected $repository;


    /**
     * AbstractService constructor.
     *
     * @param object $repository The repository associated with the service.
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }


    /**
     * Set the repository associated with the service.
     *
     * @param  object $repository The model instance.
     * @return void
     */
    public function setRepository($repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Get the repository associated with the repository.
     *
     * @return object The repository instance.
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
