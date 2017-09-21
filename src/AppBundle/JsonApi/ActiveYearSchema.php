<?php

namespace AppBundle\JsonApi;

use AppBundle\Entity\ActiveYear;
use Neomerx\JsonApi\Schema\SchemaProvider;

class ActiveYearSchema extends SchemaProvider
{

    const RESOURCE = 'active-years';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param ActiveYear $resource
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
     * @param ActiveYear $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'year' => $resource->getYear(),
        ];
    }
}
