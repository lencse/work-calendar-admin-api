<?php

namespace AppBundle\JsonApi;

use AppBundle\Entity\PublicationData;
use Neomerx\JsonApi\Schema\SchemaProvider;

class PublicationDataSchema extends SchemaProvider
{

    const RESOURCE = 'publication';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param PublicationData $resource
     *
     * @return string
     */
    public function getId($resource)
    {
        return 'data';
    }

    /**
     * Get resource attributes.
     *
     * @param PublicationData $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'publication-date' => $resource->getPublicationDate() ? $resource->getPublicationDate()->format('c') : null,
            'is-draft' => $resource->isDraft(),
        ];
    }
}
