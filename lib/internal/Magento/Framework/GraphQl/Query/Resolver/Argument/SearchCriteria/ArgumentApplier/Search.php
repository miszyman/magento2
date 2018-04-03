<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\ArgumentApplier;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\ArgumentApplierInterface;

class Search implements ArgumentApplierInterface
{
    const ARGUMENT_NAME = 'search';

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     */
    public function __construct(FilterBuilder $filterBuilder, FilterGroupBuilder $filterGroupBuilder)
    {
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function applyArgument(SearchCriteriaInterface $searchCriteria, $argument) : SearchCriteriaInterface
    {
        $searchTerm = $argument;
        $searchTermFilter = $this->filterBuilder->setField('search_term')->setValue($searchTerm)->create();
        $this->filterGroupBuilder->addFilter($searchTermFilter);
        $filterGroups = $searchCriteria->getFilterGroups();
        $filterGroups[] = $this->filterGroupBuilder->create();
        $searchCriteria->setFilterGroups($filterGroups);
        $searchCriteria->setRequestName('quick_search_container');
        return $searchCriteria;
    }
}
