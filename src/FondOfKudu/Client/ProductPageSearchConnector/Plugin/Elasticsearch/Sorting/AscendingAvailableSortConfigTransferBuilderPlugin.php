<?php

namespace FondOfKudu\Client\ProductPageSearchConnector\Plugin\Elasticsearch\Sorting;

use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\SortConfigTransfer;
use Spryker\Client\Catalog\Dependency\Plugin\SortConfigTransferBuilderPluginInterface;
use Spryker\Client\Kernel\AbstractPlugin;

class AscendingAvailableSortConfigTransferBuilderPlugin extends AbstractPlugin implements SortConfigTransferBuilderPluginInterface
{
    /**
     * @var string
     */
    public const PARAMETER_NAME = 'available';

    /**
     * @return \Generated\Shared\Transfer\SortConfigTransfer
     */
    public function build(): SortConfigTransfer
    {
        return (new SortConfigTransfer())
            ->setName('available')
            ->setParameterName(static::PARAMETER_NAME)
            ->setFieldName(PageIndexMap::INTEGER_SORT)
            ->setIsDescending(false);
    }
}
