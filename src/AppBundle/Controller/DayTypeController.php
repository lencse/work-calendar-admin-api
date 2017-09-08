<?php

namespace AppBundle\Controller;

use Lencse\WorkCalendar\Api\JsonApi\DayTypeSchema;
use Lencse\WorkCalendar\Day\DayType;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Http\Headers\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/day-type")
 */
class DayTypeController extends Controller
{

    /**
     * @Route("/")
     */
    public function listAction()
    {
        $types = DayType::getAllTypes();
        $encoder = Encoder::instance([
            DayType::class => DayTypeSchema::class
        ], new EncoderOptions(JSON_PRETTY_PRINT, '/'));

        return Response::create(
            $encoder->encodeData($types),
            200,
            ['Content-Type' => MediaType::JSON_API_MEDIA_TYPE]
        );
    }
}
