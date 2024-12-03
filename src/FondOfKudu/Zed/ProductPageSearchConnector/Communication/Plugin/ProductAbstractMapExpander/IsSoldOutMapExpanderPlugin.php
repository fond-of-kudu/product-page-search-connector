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
class IsSoldOutMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands and returns the provided PageMapTransfer objects data.
     *
     * @api
     *
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
        $soldOut = 'yes';

        if (
            isset($productData[ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT]) &&
            $productData[ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT] === 'no'
        ) {
            $soldOut = 'no';
        }

        $pageMapTransfer->setIsSoldOut($soldOut);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT, $soldOut);

        $pageMapBuilder->addStringSort($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT, $soldOut);
        $pageMapBuilder->addStringFacet($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT, $soldOut);

        return $pageMapTransfer;
    }
}
