<?php

namespace Magento\PDFGenerator\Api\Data;

interface TemplateSearchResultInterface
{
    /**
     * @return TemplateInterface[]
     */
    public function getItems();

    /**
     * @param TemplateInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
