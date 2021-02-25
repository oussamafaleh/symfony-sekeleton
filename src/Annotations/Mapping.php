<?php

namespace App\Annotations;

/**
 * @Annotation
 */
class Mapping
{

    /**
     * @var string Fully Qualified class name of ApiParameterBag
     */
    public $object;

    /**
     * @var string Name for the parameterBag
     */
    public $as;

}
