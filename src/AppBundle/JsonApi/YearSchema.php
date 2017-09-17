<?php

namespace AppBundle\JsonApi;

use AppBundle\Entity\Year;
use Neomerx\JsonApi\Schema\SchemaProvider;

class YearSchema extends SchemaProvider
{

    const RESOURCE = 'years';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param Year $resource
     *
     * @return string
     */
    public function getId($resource)
    {
        return $resource->getYear();
    }

    /**
     * Get resource attributes.
     *
     * @param Year $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'year' => $resource->getYear(),
            'is-enabled' => $resource->isEnabled(),
        ];
    }
}
