<?php

namespace AppBundle\JsonApi;

use Lencse\WorkCalendar\Api\JsonApi\DayTypeSchema;
use Lencse\WorkCalendar\Day\DayType;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Http\Headers\MediaType;
use Symfony\Component\HttpFoundation\Response;

class JsonApi
{

    /**
     * @var Encoder
     */
    private $encoder;

    /**
     * @var string[]
     */
    private $mapping = [
        DayType::class => DayTypeSchema::class
    ];

    public function __construct()
    {
        $this->encoder = Encoder::instance($this->mapping, new EncoderOptions(JSON_PRETTY_PRINT, '/api'));
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function response($data): Response
    {
        return Response::create(
            $this->encoder->encodeData($data),
            Response::HTTP_OK,
            ['Content-Type' => MediaType::JSON_API_MEDIA_TYPE]
        );
    }
}
