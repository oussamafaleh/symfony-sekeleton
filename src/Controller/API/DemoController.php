<?php

 namespace App\Controller\API;

use App\Entity\Quiz;
use App\Annotations\Mapping;
use App\Manager\DemoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Operation;

/**
 * Class QuizController
 * @package App\Controller\API
 * @Route("/api")
 *
 */
 class DemoController extends AbstractController
 {

     private $manager = null;

    /**
     * ProfilController constructor.
     */
    public function __construct(DemoManager $demoManager)
    {
        $this->manager = $demoManager;
    }

    /**
     * @Route("/demo", name="quiz_lists", methods={"GET"})
     * @Mapping(object="App\ApiModel\Back\Demo\Demo", as="demo")
     * @Operation(
     *     tags={"Demo"},
     *     summary="demo for skeleton",
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="name of user",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Returned when the ws-quiz is not authorized"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the quiz is not found"
     *     )
     * )
     */
    public function list(Request $request)
    {
        return $this->manager->list($request);
    }

    
}
