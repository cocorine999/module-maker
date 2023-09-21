<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * DateTimeResource
 *
 * This resource class extends the JsonResource class and provides a convenient
 * way to format and present DateTime objects in API responses. It includes
 * methods to convert DateTime to ISO 8601 format, calculate human-readable
 * time differences, and display DateTime in a human-readable day and time format.
 * The DateTimeResource class is a versatile tool for consistent and user-friendly
 * representation of date and time data in your API.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Resources
 */
class DateTimeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'datetime' => $this->toISOString(),
            'human_diff' => $this->diffForHumans(),
            'human' => $this->toDayDateTimeString(),
        ];
    }
}