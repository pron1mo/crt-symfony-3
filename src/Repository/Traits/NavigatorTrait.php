<?php


namespace App\Repository\Traits;


trait NavigatorTrait
{

    public function countPages($page, $limit)
    {
        $query = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->orderBy('p.createdAt', 'DESC')
            ->setFirstResult( ($limit * $page) - $limit );
        return $query->getQuery()->getResult();
    }

    public function countTotal()
    {
        $query = $this->createQueryBuilder('p')->select('count(p.id)');
        $result = $query->getQuery()->getOneOrNullResult();
        return $result ? array_shift($result) : 0;
    }

}
