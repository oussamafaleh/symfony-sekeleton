<?php

namespace App\Manager;

use App\Entity\Quiz;
use App\Entity\Bloc;
use App\Entity\Question;
use App\Entity\Description;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

class QuizManager extends AbstractManager
{

    /** @var string */
    private $code;


    /** @var Quiz */
    private $quiz;


    public function __construct(Registry $entityManager, RequestStack $requestStack)
    {
        parent::__construct($entityManager,  $requestStack);
    }

    /**
     * ClientModel initializer.
     */
    public function init($settings = [])
    {
        parent::setSettings($settings);
        if ($this->getCode()) {

            // find existing Client
            $this->quiz = $this->apiEntityManager
                    ->getRepository(Quiz::class)
                    ->findOneBy(["code" => $this->getCode()]);

        }

        return $this;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return backClientManager
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }



    /**
     * @return array
     *
     * list of back user
     */
    public function list()
    {
//        $filters = (array) $this->request->get('quizs');
//        
//        $data = $this->apiEntityManager
//                ->getRepository(Quiz::class)
//                ->findByFilters($filters);
//
//
//        $data = \SSH\CommonBundle\Utils\MyTools::paginator($data, $filters['index'], $filters['size']);
//        return ['data' => $data];
        return ['data' => "hello word"];
    }




}
