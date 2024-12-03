<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Communication\Plugin\ProductAbstractMapExpander;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductPageSearchConnector\ProductPageSearchConnectorConstants;
use FondOfKudu\Zed\ProductPageSearchConnector\Communication\ProductPageSearchConnectorCommunicationFactory;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeBridge;
use FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeBridge;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\DecimalObject\Decimal;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder;

class AvailableMapExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PageMapTransfer
     */
    protected PageMapTransfer|MockObject $pageMapTransferMock;

    /**
     * @var \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected PageMapBuilder|MockObject $pageMapBuilderMock;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LocaleTransfer|MockObject $localeTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Communication\ProductPageSearchConnectorCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductPageSearchConnectorCommunicationFactory|MockObject $ProductPageSearchConnectorCommunicationFactoryMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductPageSearchConnectorToStoreFacadeBridge|MockObject $storeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Dependency\Facade\ProductPageSearchConnectorToAvailabilityFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductPageSearchConnectorToAvailabilityFacadeBridge|MockObject $availabilityFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreTransfer|MockObject $storeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductAbstractAvailabilityTransfer|MockObject $productAbstractAvailabilityTransferMock;

    /**
     * @var \Spryker\DecimalObject\Decimal|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Decimal|MockObject $decimalMock;

    /**
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Communication\Plugin\ProductAbstractMapExpander\AvailableMapExpanderPlugin
     */
    protected AvailableMapExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageMapTransferMock = $this->createMock(PageMapTransfer::class);
        $this->pageMapBuilderMock = $this->createMock(PageMapBuilder::class);
        $this->localeTransferMock = $this->createMock(LocaleTransfer::class);
        $this->ProductPageSearchConnectorCommunicationFactoryMock = $this->createMock(ProductPageSearchConnectorCommunicationFactory::class);
        $this->storeFacadeMock = $this->createMock(ProductPageSearchConnectorToStoreFacadeBridge::class);
        $this->availabilityFacadeMock = $this->createMock(ProductPageSearchConnectorToAvailabilityFacadeBridge::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->productAbstractAvailabilityTransferMock = $this->createMock(ProductAbstractAvailabilityTransfer::class);
        $this->decimalMock = $this->createMock(Decimal::class);

        $this->plugin = new AvailableMapExpanderPlugin();
        $this->plugin->setFactory($this->ProductPageSearchConnectorCommunicationFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = [
            ProductPageSearchConnectorConstants::PRODUCT_DATA_LOCALE => 'de_DE',
            ProductPageSearchConnectorConstants::PRODUCT_DATA_ID_PRODUCT_ABSTRACT => 99,
            ProductPageSearchConnectorConstants::PRODUCT_DATA_SKU => 'SKU-000-1111',
            ProductPageSearchConnectorConstants::PRODUCT_DATA_STORE => 'AFFENZAHN_COM',
        ];

        $this->ProductPageSearchConnectorCommunicationFactoryMock->expects(static::once())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->storeFacadeMock->expects(static::once())
            ->method('findStoreByName')
            ->with($productData[ProductPageSearchConnectorConstants::PRODUCT_DATA_STORE])
            ->willReturn($this->storeTransferMock);

        $this->ProductPageSearchConnectorCommunicationFactoryMock->expects(static::once())
            ->method('getAvailabilityFacade')
            ->willReturn($this->availabilityFacadeMock);

        $this->availabilityFacadeMock->expects(static::once())
            ->method('findOrCreateProductAbstractAvailabilityBySkuForStore')
            ->with(
                $productData[ProductPageSearchConnectorConstants::PRODUCT_DATA_SKU],
                $this->storeTransferMock,
            )
            ->willReturn($this->productAbstractAvailabilityTransferMock);

        $this->productAbstractAvailabilityTransferMock->expects(static::once())
            ->method('getIsNeverOutOfStock')
            ->willReturn(false);

        $this->productAbstractAvailabilityTransferMock->expects(static::once())
            ->method('getAvailability')
            ->willReturn($this->decimalMock);

        $this->decimalMock->expects(static::once())
            ->method('greaterThan')
            ->with(0)
            ->willReturn(true);

        $this->pageMapTransferMock->expects(static::once())
            ->method('setAvailable')
            ->with(true)
            ->willReturnSelf();

        $this->pageMapBuilderMock->expects(static::once())
            ->method('addSearchResultData')
            ->with($this->pageMapTransferMock, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, true)
            ->willReturnSelf();

        $pageMapTransfer = $this->plugin->expandProductMap(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localeTransferMock,
        );

        static::assertEquals($pageMapTransfer, $this->pageMapTransferMock);
    }
}
