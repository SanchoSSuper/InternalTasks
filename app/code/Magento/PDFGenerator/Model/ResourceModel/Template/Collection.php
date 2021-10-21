<?php

namespace Magento\PDFGenerator\Model\ResourceModel\Template;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\PDFGenerator\Api\Data\TemplateInterface;
use Magento\PDFGenerator\Model\Template as Model;
use Magento\PDFGenerator\Model\ResourceModel\Template as ResorceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = TemplateInterface::TEMPLATE_ID;

    /**
     * Collection Constructor.
     */
    public function _construct()
    {
        $this->_init(Model::class, ResorceModel::class);
    }
}
