<?php

 namespace App\Controller\API;

use App\Entity\Quiz;
use App\Annotations\Mapping;
use App\Manager\QuizManager;
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
 class QuizController extends AbstractController
 {

     private $manager = null;

    /**
     * ProfilController constructor.
     */
    public function __construct(QuizManager $quizManager)
    {
        $this->manager = $quizManager;
    }

    /**
     * @Route("/quizs", name="quiz_lists", methods={"GET"})
     * @Mapping(object="App\ApiModel\Back\Quizs\Quizs", as="quizs")
     * @Operation(
     *     tags={"Quiz"},
     *     summary="back quiz list",
     *     @SWG\Parameter(
     *         name="code",
     *         in="query",
     *         type="string",
     *         description="code",
     *         required=false
     *     ),
     *      @SWG\Parameter(
     *         name="sort_column",
     *         in="query",
     *         description="sort column",
     *         required=false,
     *         type="string",
     *         enum={"created_at", "code", "label"},
     *     ),
     *     @SWG\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="sorting direction  default asc",
     *         required=false,
     *         type="string",
     *         enum={"ASC", "DESC"},
     *     ),
     *     @SWG\Parameter(
     *         name="active",
     *         in="query",
     *         description="show active quiz !",
     *         required=false,
     *         type="string",
     *         enum={"true", "false"},
     *     ),
     *     @SWG\Parameter(
     *         name="index",
     *         in="query",
     *         type="string",
     *         description="page number",
     *         required=false
     *     ),
     *     @SWG\Parameter(
     *        name="size",
     *         in="query",
     *         type="string",
     *         description=" max per page number",
     *         required=false
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
