<?php

namespace App\Manager;

use App\Entity\Demo;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DemoManager extends AbstractManager
{

    /** @var string */
    private $code;


    /** @var Quiz */
    private $quiz;


    public function __construct(Registry $entityManager, RequestStack $requestStack)
    {
        parent::__construct($entityManager, $requestStack);
    }

    /**
     * ClientModel initializer.
     */
  /*  public function init($settings = [])
    {
        parent::setSettings($settings);
        if ($this->getCode()) {

            // find existing Client
            $this->quiz = $this->apiEntityManager
                    ->getRepository(Quiz::class)
                    ->findOneBy(["code" => $this->getCode()]);

        }

        return $this;
    }*/

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
       // $filters = (array) $this->request->get('quizs');
        
        $data = $this->apiEntityManager
                ->getRepository(Demo::class)
                ->findAll();
                dump($data);
                exit();

        return ['data' => $data];
    }




}
