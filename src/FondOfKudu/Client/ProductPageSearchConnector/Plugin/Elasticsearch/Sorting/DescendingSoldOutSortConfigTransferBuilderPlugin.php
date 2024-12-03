<?php

namespace FondOfKudu\Client\ProductPageSearchConnector\Plugin\Elasticsearch\Sorting;

use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\SortConfigTransfer;
use Spryker\Client\Catalog\Dependency\Plugin\SortConfigTransferBuilderPluginInterface;
use Spryker\Client\Kernel\AbstractPlugin;

class DescendingSoldOutSortConfigTransferBuilderPlugin extends AbstractPlugin implements SortConfigTransferBuilderPluginInterface
{
    /**
     * @var string
     */
    public const PARAMETER_NAME = 'sold_out';

    /**
     * @return \Generated\Shared\Transfer\SortConfigTransfer
     */
    public function build(): SortConfigTransfer
    {
        return (new SortConfigTransfer())
            ->setName('is_sold_out')
            ->setParameterName(static::PARAMETER_NAME)
            ->setFieldName(PageIndexMap::STRING_SORT)
            ->setIsDescending(true);
    }
}
