<?php

namespace FondOfKudu\Client\ProductPageSearchConnector\Plugin\Elasticsearch\Expander;

use Codeception\Test\Unit;
use Elastica\Query;
use FondOfKudu\Shared\ProductPageSearchConnector\ProductPageSearchConnectorConstants;
use Generated\Shared\Search\PageIndexMap;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class AvailableQueryExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QueryInterface|MockObject $queryMock;

    /**
     * @var \Elastica\Query|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Query|MockObject $esQueryMock;

    /**
     * @var \FondOfKudu\Client\ProductPageSearchConnector\Plugin\Elasticsearch\Expander\AvailableQueryExpanderPlugin
     */
    protected AvailableQueryExpanderPlugin $availableQueryExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->queryMock = $this->createMock(QueryInterface::class);
        $this->esQueryMock = $this->createMock(Query::class);
        $this->availableQueryExpanderPlugin = new AvailableQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $requestParameters = [ProductPageSearchConnectorConstants::ATTR_AVAILABLE => 1];

        $this->queryMock->expects(static::once())
            ->method('getSearchQuery')
            ->willReturn($this->esQueryMock);

        $this->esQueryMock->expects(static::once())
            ->method('addSort')
            ->with([
                PageIndexMap::INTEGER_SORT . '.' . ProductPageSearchConnectorConstants::ATTR_AVAILABLE => [
                    'order' => SortConfig::DIRECTION_DESC,
                    'mode' => 'min',
                ],
            ]);

        $searchQuery = $this->availableQueryExpanderPlugin->expandQuery($this->queryMock, $requestParameters);

        static::assertEquals($this->queryMock, $searchQuery);
    }
}
