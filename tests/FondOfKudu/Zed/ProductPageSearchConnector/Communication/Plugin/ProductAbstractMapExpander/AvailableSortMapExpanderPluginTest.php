<?php

namespace FondOfKudu\Zed\ProductPageSearchConnector\Communication\Plugin\ProductAbstractMapExpander;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductPageSearchConnector\ProductPageSearchConnectorConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder;

class AvailableSortMapExpanderPluginTest extends Unit
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
     * @var \FondOfKudu\Zed\ProductPageSearchConnector\Communication\Plugin\ProductAbstractMapExpander\AvailableSortMapExpanderPlugin
     */
    protected AvailableSortMapExpanderPlugin $availableSortMapExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageMapTransferMock = $this->createMock(PageMapTransfer::class);
        $this->pageMapBuilderMock = $this->createMock(PageMapBuilder::class);
        $this->localeTransferMock = $this->createMock(LocaleTransfer::class);
        $this->availableSortMapExpanderPlugin = new AvailableSortMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = [
            ProductPageSearchConnectorConstants::ATTR_AVAILABLE => 1,
        ];

        $this->pageMapBuilderMock->expects(static::once())
            ->method('addIntegerSort')
            ->with($this->pageMapTransferMock, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, 1)
            ->willReturnSelf();

        $this->pageMapBuilderMock->expects(static::once())
            ->method('addIntegerFacet')
            ->with($this->pageMapTransferMock, ProductPageSearchConnectorConstants::ATTR_AVAILABLE, 1)
            ->willReturnSelf();

        $pageMapTransfer = $this->availableSortMapExpanderPlugin->expandProductMap(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localeTransferMock,
        );

        static::assertEquals($pageMapTransfer, $this->pageMapTransferMock);
    }
}
