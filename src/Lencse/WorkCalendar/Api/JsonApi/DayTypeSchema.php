<?php

namespace Lencse\WorkCalendar\Api\JsonApi;

use Lencse\WorkCalendar\Day\DayType;
use Neomerx\JsonApi\Schema\SchemaProvider;

class DayTypeSchema extends SchemaProvider
{

    const RESOURCE = 'day-type';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param DayType $resource
     *
     * @return string
     */
    public function getId($resource)
    {
        return $resource->getKey();
    }

    /**
     * Get resource attributes.
     *
     * @param DayType $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'key' => $resource->getKey(),
            'name' => $resource->getName(),
            'is-rest-day' => $resource->isRestDay(),
        ];
    }
}
