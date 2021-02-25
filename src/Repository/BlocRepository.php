<?php

namespace App\Repository;

use App\Entity\Bloc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use SSH\CommonBundle\Utils\MyTools;

/**
 * @method Bloc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bloc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bloc[]    findAll()
 * @method Bloc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlocRepository extends ServiceEntityRepository
{

    /**
     * Table name
     *
     * @var string
     */
    const TABLE_NAME = 'bloc';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bloc::class);
    }

    public function findByQuiz($quiz)
    {
        $parameters  = [
            ':quiz' => $quiz
        ];

        $select = [
            'id' => "q.id",
            'title' => "q.title"
        ];

        $sql = '';
        $rsm = new ResultSetMapping();

        foreach ($select as $column => $value) {
            $sql .= $value . ' AS ' . $column . ', ';
            $rsm->addScalarResult($column, $column);
        }
        $sql = 'SELECT ' . substr($sql, 0, -2)
                . ' FROM ' . self::TABLE_NAME . ' AS q '
                . ' WHERE  q.quiz_id  = :quiz ' ;


        $cacheKey = sha1($sql . json_encode($parameters));
        return $this->getEntityManager()
                        ->createNativeQuery($sql, $rsm)
                        ->setParameters($parameters)
                        ->enableResultCache(3000, $cacheKey)
                        ->getResult();
    }

}
