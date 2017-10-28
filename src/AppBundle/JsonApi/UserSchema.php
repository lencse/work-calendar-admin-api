<?php

namespace AppBundle\JsonApi;

use AppBundle\Auth\User;
use Neomerx\JsonApi\Schema\SchemaProvider;

class UserSchema extends SchemaProvider
{

    const RESOURCE = 'user';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param User $resource
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getId($resource)
    {
        return 'me';
    }

    /**
     * Get resource attributes.
     *
     * @param User $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->getName(),
            'email' => $resource->getEmail(),
            'avatar' => $resource->getAvatar(),
        ];
    }
}
