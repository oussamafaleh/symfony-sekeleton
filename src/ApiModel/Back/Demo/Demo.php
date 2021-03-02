<?php

namespace App\ApiModel\Back\Quizs;

use Symfony\Component\Validator\Constraints as Assert;
use SSH\CommonBundle\Model\Traits\ApiList;
use SSH\CommonBundle\Request\CommonParameterBag;

class Demo extends CommonParameterBag
{

    use ApiList;

    /**
     * @var string
     *
     * @Assert\Regex({
     *    "pattern":"/^[0-9a-zA-Z- _]+/"
     * })
     * @Assert\Regex("/^[a-zA-Z]+/")
     */
    public $demo;

}
