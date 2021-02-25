<?php


namespace App\ApiModel\Back\Quizs;


use SSH\CommonBundle\Request\CommonParameterBag;
use Symfony\Component\Validator\Constraints as Assert;

class Quiz extends CommonParameterBag
{
    /**
     * @var string
     *
     * @Assert\Regex("/^[a-za-z- _]+/")
     */
    public  $title;

    /**
     * @var string
     *
     * @Assert\Regex("/^[a-za-z- _]+/")
     */
    public  $description;

    /**
     * @var string
     *
     * @Assert\Regex("/^[a-za-z- _]+/")
     */
    public  $category;

    

}