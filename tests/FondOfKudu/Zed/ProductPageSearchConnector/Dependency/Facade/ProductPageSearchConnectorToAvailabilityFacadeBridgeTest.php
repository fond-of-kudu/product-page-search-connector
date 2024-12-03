<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Availability\Business\AvailabilityFacade;

class ProductPageSearchConnectorToAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Availability\Business\AvailabilityFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected AvailabilityFacade|MockObject $availabilityFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreTransfer|MockObject $storeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductAbstractAvailabilityTransfer|MockObject $productAbstractAvailabilityTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeBridge
     */
    protected ProductPageSearchConnectorToAvailabilityFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->availabilityFacadeMock = $this->createMock(AvailabilityFacade::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->productAbstractAvailabilityTransferMock = $this->createMock(ProductAbstractAvailabilityTransfer::class);
        $this->bridge = new ProductPageSearchConnectorToAvailabilityFacadeBridge($this->availabilityFacadeMock);
    }

    /**
     * @return void
     */
    public function testFindOrCreateProductAbstractAvailabilityBySkuForStore(): void
    {
        $this->availabilityFacadeMock->expects(static::once())
            ->method('findOrCreateProductAbstractAvailabilityBySkuForStore')
            ->with('sku', $this->storeTransferMock)
            ->willReturn($this->productAbstractAvailabilityTransferMock);

        $productAbstractAvailabilityTransfer = $this->bridge->findOrCreateProductAbstractAvailabilityBySkuForStore('sku', $this->storeTransferMock);

        static::assertEquals($productAbstractAvailabilityTransfer, $this->productAbstractAvailabilityTransferMock);
    }
}
