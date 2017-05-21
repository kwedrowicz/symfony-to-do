<?php
declare(strict_types=1);

namespace AppBundle\SearchRepository;

use AppBundle\Entity\User;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Elastica\Query\Term;
use FOS\ElasticaBundle\Repository;

class TaskRepository extends Repository
{
    public function findWithUser(User $user, string $search = null)
    {
        $boolQuery = new BoolQuery();
        if ($search) {
            $fieldQuery = new MultiMatch();
            $fieldQuery->setQuery($search);
            $fieldQuery->setFields(['subject', 'category', 'tags']);
            $boolQuery->addMust($fieldQuery);
        }
        $userFilter = new Term();
        $userFilter->setTerm('user', $user->getUsername());
        $boolQuery->addFilter($userFilter);

        return $this->find($boolQuery, 1000);
    }
}