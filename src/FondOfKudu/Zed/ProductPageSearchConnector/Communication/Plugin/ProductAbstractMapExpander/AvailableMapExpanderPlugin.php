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
class AvailableMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
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
        if ($this->validateProductData($productData) === false) {
            return $pageMapTransfer;
        }

        $storeTransfer = $this->getFactory()
            ->getStoreFacade()
            ->findStoreByName($productData[ProductPageSearchConnectorConstants::PRODUCT_DATA_STORE]);

        if ($storeTransfer === null) {
            return $pageMapTransfer;
        }

        $productAbstractAvailabilityTransfer = $this->getFactory()
            ->getAvailabilityFacade()
            ->findOrCreateProductAbstractAvailabilityBySkuForStore(
                $productData[ProductPageSearchConnectorConstants::PRODUCT_DATA_SKU],
                $storeTransfer,
            );

        if ($productAbstractAvailabilityTransfer === null) {
            return $pageMapTransfer;
        }

        if ($productAbstractAvailabilityTransfer->getIsNeverOutOfStock() === true) {
            $pageMapTransfer->setAvailable(1);
            $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, 1);

            return $pageMapTransfer;
        }

        $available = (int)$productAbstractAvailabilityTransfer
            ->getAvailability()
            ->greaterThan(0);

        $pageMapTransfer->setAvailable($available);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, $available);

        return $pageMapTransfer;
    }

    /**
     * @param array $productData
     *
     * @return bool
     */
    protected function validateProductData(array $productData): bool
    {
        if (
            !array_key_exists(ProductPageSearchConnectorConstants::PRODUCT_DATA_LOCALE, $productData) ||
            !array_key_exists(ProductPageSearchConnectorConstants::PRODUCT_DATA_ID_PRODUCT_ABSTRACT, $productData) ||
            !array_key_exists(ProductPageSearchConnectorConstants::PRODUCT_DATA_SKU, $productData) ||
            !array_key_exists(ProductPageSearchConnectorConstants::PRODUCT_DATA_STORE, $productData)
        ) {
            return false;
        }

        return true;
    }
}
