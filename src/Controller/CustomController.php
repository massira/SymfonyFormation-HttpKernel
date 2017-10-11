<?php

namespace HttpKernel\Formation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CustomController
 *
 * @package HttpKernel\Formation\Controller
 */
class CustomController extends Controller
{
    /**
     * @param string $name
     *
     * @return Response
     */
    public function helloAction($name)
    {
        return new Response('Hello '.$name);
    }
}