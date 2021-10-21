<?php

namespace Magento\PDFGenerator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\PDFGenerator\Api\Data\TemplateInterface;

class Template extends AbstractDb
{
    /**
     * Resource Model Constructor.
     */
    protected function _construct()
    {
        $this->_init(TemplateInterface::TABLE, TemplateInterface::TEMPLATE_ID);
    }
}
