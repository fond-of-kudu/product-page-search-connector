<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ProductPageSearchConnectorToStoreFacadeInterface
{
    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(string $storeName): ?StoreTransfer;
}
