<?php

namespace App\Repository;

use App\Entity\Description;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use SSH\CommonBundle\Utils\MyTools;

/**
 * @method Description|null find($id, $lockMode = null, $lockVersion = null)
 * @method Description|null findOneBy(array $criteria, array $orderBy = null)
 * @method Description[]    findAll()
 * @method Description[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionRepository extends ServiceEntityRepository
{

    /**
     * Table name
     *
     * @var string
     */
    const TABLE_NAME = 'description';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Description::class);
    }

    // public function findByQuestion($question)
    // {
    //     // dump($question);
    //     // exit;
    //     $parameters  = [
    //         ':question' => $question
    //     ];
    //     $select = [
    //         'name' => "desc.name",
    //         'data' => "desc.data"
    //     ];

    //     $sql = '';
    //     $rsm = new ResultSetMapping();

    //     foreach ($select as $column => $value) {
    //         $sql .= $value . ' AS ' . $column . ', ';
    //         $rsm->addScalarResult($column, $column);
    //     }
    //     $sql = 'SELECT ' . substr($sql, 0, -2)
    //             . ' FROM ' . self::TABLE_NAME . ' AS desc '
    //             . ' WHERE  desc.question_id  = :question' ;

    //     $cacheKey = sha1($sql . json_encode($parameters));
    //         return $this->getEntityManager()
    //                  ->createNativeQuery($sql, $rsm)
    //                     ->setParameters($parameters)
    //                     ->enableResultCache(3000, $cacheKey)
    //                     ->getResult();
    // }
    

}
