<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use SSH\CommonBundle\Utils\MyTools;

/**
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{

    /**
     * Table name
     *
     * @var string
     */
    const TABLE_NAME = 'quiz';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function findByFilters($filters)
    {
        $parameters = $where = [];
        $code = MyTools::getOption($filters, 'code');
        $sortColumn = MyTools::getOption($filters, 'sort_column', 'created_at');
        $sortOrder = MyTools::getOption($filters, 'sort_order', 'DESC');
        $page = MyTools::getOption($filters, 'index', 1);
        $maxPerPage = MyTools::getOption($filters, 'size', 10);
        $title = MyTools::getOption($filters, 'title');
        $description = MyTools::getOption($filters, 'description');
        $category = MyTools::getOption($filters, 'category');
        $dateFormat = MyTools::getOption($filters, 'date_format', 'YYYY-MM-DD');

        $select = [
            'total' => 'count(*) OVER() ',
            'code' => 'q.code',
            'title' => "q.title",
            'description' => "q.description",
            'category' => "q.category",
            'created_at' => "TO_CHAR(q.created_at,  '" . $dateFormat . "')",
        ];

        $sql = '';
        $rsm = new ResultSetMapping();

        foreach ($select as $column => $value) {
            $sql .= $value . ' AS ' . $column . ', ';
            $rsm->addScalarResult($column, $column);
        }
        $sql = 'SELECT ' . substr($sql, 0, -2)
                . ' FROM ' . self::TABLE_NAME . ' AS q '
        ;

        if (!empty($code)) {
            $parameters[':code'] = $code;
            $where [] = ' q.code = :code';
        }

        if (!empty($label)) {
            $parameters[':label'] = '%' . $label . '%';
            $where [] = ' q.label ILIKE :label';
        }

        if (!empty($lang)) {
            $parameters[':lang'] = '%' . $lang . '%';
            $where [] = ' q.lang ILIKE :lang';
        }

        if (!empty($flag)) {
            $parameters[':flag'] = '%' . $flag . '%';
            $where [] = ' q.flag ILIKE :flag';
        }

        if (!empty($active)) {
            $parameters[':active'] = $active;
            $where[] = ' q.active = :active';
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        if (isset($select[$sortColumn])) {
            $sql .= ' ORDER BY ' . $select[$sortColumn] . '  ' . $sortOrder;
        }

        if ($page > 0) {
            $sql .= ' LIMIT ' . $maxPerPage . ' OFFSET ' . (($page - 1) * $maxPerPage);
        }

        $cacheKey = sha1($sql . json_encode($parameters));
        return $this->getEntityManager()
                        ->createNativeQuery($sql, $rsm)
                        ->setParameters($parameters)
                        ->enableResultCache(3000, $cacheKey)
                        ->getResult();
    }

}
