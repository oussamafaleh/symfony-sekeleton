<?php

namespace App\Manager;

use App\Entity\Quiz;
use App\Entity\Bloc;
use App\Entity\Question;
use App\Entity\Description;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Registry;
//use SSH\CommonBundle\Manager\ExceptionManager;
//use SSH\CommonBundle\Utils\MyTools;

class QuizManager extends AbstractManager
{

    /** @var string */
    private $code;


    /** @var Quiz */
    private $quiz;


    public function __construct(Registry $entityManager,/* ExceptionManager $exceptionManager,*/ RequestStack $requestStack)
    {
        parent::__construct($entityManager, /*$exceptionManager,*/ $requestStack);
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

//            if (!$this->quiz instanceof Quiz) {
//                $this->exceptionManager->throwNotFoundException('UNKNOWN_QUIZ');
//            }
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
