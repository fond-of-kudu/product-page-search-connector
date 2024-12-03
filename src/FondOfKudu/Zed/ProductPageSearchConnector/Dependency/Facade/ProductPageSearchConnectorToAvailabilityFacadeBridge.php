<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Availability\Business\AvailabilityFacadeInterface;

class ProductPageSearchConnectorToAvailabilityFacadeBridge implements ProductPageSearchConnectorToAvailabilityFacadeInterface
{
    /**
     * @var \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface
     */
    protected $availabilityFacade;

    /**
     * @param \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface $availabilityFacade
     */
    public function __construct(AvailabilityFacadeInterface $availabilityFacade)
    {
        $this->availabilityFacade = $availabilityFacade;
    }

    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|null
     */
    public function findOrCreateProductAbstractAvailabilityBySkuForStore(
        string $sku,
        StoreTransfer $storeTransfer
    ): ?ProductAbstractAvailabilityTransfer {
        return $this->availabilityFacade->findOrCreateProductAbstractAvailabilityBySkuForStore($sku, $storeTransfer);
    }
}
