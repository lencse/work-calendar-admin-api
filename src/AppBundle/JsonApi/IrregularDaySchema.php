<?php

namespace AppBundle\JsonApi;

use AppBundle\Entity\IrregularDayEntity;
use Lencse\WorkCalendar\Day\DayType;
use Neomerx\JsonApi\Schema\SchemaProvider;

class IrregularDaySchema extends SchemaProvider
{

    const RESOURCE = 'irregular-days';

    /**
     * @var string
     */
    protected $resourceType = self::RESOURCE;

    /**
     * Get resource identity.
     *
     * @param IrregularDayEntity $resource
     *
     * @return string
     */
    public function getId($resource)
    {
        return $resource->getId();
    }

    /**
     * Get resource attributes.
     *
     * @param IrregularDayEntity $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'date' => $resource->getDate()->format('c'),
            'type-key' => $resource->getTypeKey(),
            'description' => $resource->getDescription(),
        ];
    }

    /**
     * Get resource links.
     *
     * @param IrregularDayEntity $resource
     * @param bool $isPrimary
     * @param array $includeRelationships A list of relationships that will be included as full resources.
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'day-type' => [
                self::DATA => DayType::get($resource->getTypeKey())
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getIncludePaths()
    {
        return ['day-type'];
    }


}
