<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Store\Business\StoreFacade;

class ProductPageSearchConnectorToStoreFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreFacade|MockObject $storeFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreTransfer|MockObject $storeTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeBridge
     */
    protected ProductPageSearchConnectorToStoreFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->storeFacadeMock = $this->createMock(StoreFacade::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->bridge = new ProductPageSearchConnectorToStoreFacadeBridge($this->storeFacadeMock);
    }

    /**
     * @return void
     */
    public function testFindStoreByName(): void
    {
        $this->storeFacadeMock->expects(static::once())
            ->method('findStoreByName')
            ->with('storeName')
            ->willReturn($this->storeTransferMock);

        $storeTransfer = $this->bridge->findStoreByName('storeName');

        static::assertEquals($storeTransfer, $this->storeTransferMock);
    }
}
