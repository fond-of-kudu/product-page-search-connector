<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector;

use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeBridge;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeInterface;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeBridge;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductPageSearchConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_AVAILABILITY = 'FACADE_AVAILABILITY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addStoreFacade($container);
        $container = $this->addAvailabilityFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, static fn (Container $container): ProductPageSearchConnectorToStoreFacadeInterface => new ProductPageSearchConnectorToStoreFacadeBridge(
            $container->getLocator()->store()->facade(),
        ));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityFacade(Container $container): Container
    {
        $container->set(static::FACADE_AVAILABILITY, static fn (Container $container): ProductPageSearchConnectorToAvailabilityFacadeInterface => new ProductPageSearchConnectorToAvailabilityFacadeBridge(
            $container->getLocator()->availability()->facade(),
        ));

        return $container;
    }
}
