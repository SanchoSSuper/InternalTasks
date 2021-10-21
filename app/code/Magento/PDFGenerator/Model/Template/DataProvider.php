<?php

namespace Magento\PDFGenerator\Model\Template;

use Magento\PDFGenerator\Model\ResourceModel\Template\CollectionFactory;
use Magento\PDFGenerator\Model\Template;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Custom DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $templateCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $templateCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $templateCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        foreach ($items as $item) {
            /** @var Template $item */
            $this->loadedData[$item->getId()] = $item->getData();
        }

        return $this->loadedData;
    }
}
