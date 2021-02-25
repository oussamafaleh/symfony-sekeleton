<?php

namespace App\ApiModel\Back\Quizs;

use Symfony\Component\Validator\Constraints as Assert;
use SSH\CommonBundle\Model\Traits\ApiList;
use SSH\CommonBundle\Request\CommonParameterBag;

class Quizs extends CommonParameterBag
{

    use ApiList;

    /**
     * @var string
     *
     * @Assert\Regex({
     *    "pattern":"/^[0-9a-zA-Z- _]+/"
     * })
     * @Assert\Regex("/^[0-9a-zA-Z- _]+/")
     */
    public $code;

    /**
     * @var string
     *
     * @Assert\Regex("/^(code|label|created_at)/")
     */
    public $sort_column = 'created_at';

}
