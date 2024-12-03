<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Communication;

use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeInterface;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeInterface;
use FondOfKudu\Zed\ProductPageSearchConnector\ProductPageSearchConnectorDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ProductPageSearchConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeInterface
     */
    public function getStoreFacade(): ProductPageSearchConnectorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductPageSearchConnectorDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeInterface
     */
    public function getAvailabilityFacade(): ProductPageSearchConnectorToAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ProductPageSearchConnectorDependencyProvider::FACADE_AVAILABILITY);
    }
}
