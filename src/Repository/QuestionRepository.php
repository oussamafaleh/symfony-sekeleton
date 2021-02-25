<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use SSH\CommonBundle\Utils\MyTools;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{

    /**
     * Table name
     *
     * @var string
     */
    const TABLE_NAME = 'question';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findByBloc($bloc)
    {
        $parameters  = [
            ':bloc' => $bloc
        ];
        $select = [
            'id' => "ques.id",
            'question' => "ques.question",
            'type' => "ques.type",
            'text' => "ques.text",
            'video' => "ques.video",
            'score' => "ques.score",
            'type_choice' => "ques.type_choice",
            'data_choices' => "array_to_json(ques.data_choices)"
        ];

        $sql = '';
        $rsm = new ResultSetMapping();

        foreach ($select as $column => $value) {
            $sql .= $value . ' AS ' . $column . ', ';
            $rsm->addScalarResult($column, $column);
        }
        $sql = 'SELECT ' . substr($sql, 0, -2)
                . ' FROM ' . self::TABLE_NAME . ' AS ques '
                . ' WHERE  ques.bloc_id  = :bloc' ;

        $cacheKey = sha1($sql . json_encode($parameters));
            return $this->getEntityManager()
                     ->createNativeQuery($sql, $rsm)
                        ->setParameters($parameters)
                        ->enableResultCache(3000, $cacheKey)
                        ->getResult();
    }
    

}
