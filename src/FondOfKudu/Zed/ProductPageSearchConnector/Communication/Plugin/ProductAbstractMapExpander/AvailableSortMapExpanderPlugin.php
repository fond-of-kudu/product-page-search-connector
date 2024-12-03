<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Communication\Plugin\ProductAbstractMapExpander;

use FondOfKudu\Shared\ProductPageSearchConnector\ProductPageSearchConnectorConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \FondOfKudu\Zed\ProductPageSearchConnector\Communication\ProductPageSearchConnectorCommunicationFactory getFactory()
 */
class AvailableSortMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        $available = (int)$productData[ProductPageSearchConnectorConstants::ATTR_AVAILABLE];

        $pageMapBuilder->addIntegerSort($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, $available);
        $pageMapBuilder->addIntegerFacet($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, $available);

        return $pageMapTransfer;
    }
}
