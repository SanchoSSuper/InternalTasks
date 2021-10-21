<?php

namespace Magento\PDFGenerator\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\PDFGenerator\Api\Data\TemplateInterface;
use Magento\PDFGenerator\Model\ResourceModel\Template as ResourceModel;

class Template extends AbstractModel implements TemplateInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getTemplateId(): int
    {
        return parent::getData(self::TEMPLATE_ID);
    }

    /**
     * @return array|mixed|null
     */
    public function getIsEnabled()
    {
        return parent::getData(self::IS_ENABLED);
    }

    /**
     * @param $isEnabled
     * @return Template
     */
    public function setIsEnabled($isEnabled)
    {
        return $this->setData(self::IS_ENABLED, $isEnabled);
    }

    /**
     * @return array|mixed|null
     */
    public function getHeader()
    {
        return parent::getData(self::HEADER);
    }

    /**
     * @param $header
     * @return Template
     */
    public function setHeader($header)
    {
        return $this->setData(self::HEADER, $header);
    }

    /**
     * @return array|mixed|null
     */
    public function getFooter()
    {
        return parent::getData(self::FOOTER);
    }

    /**
     * @param $footer
     * @return Template
     */
    public function setFooter($footer)
    {
        return $this->setData(self::FOOTER, $footer);
    }

    /**
     * @return array|mixed|null
     */
    public function getBody()
    {
        return parent::getData(self::BODY);
    }

    /**
     * @param $body
     * @return Template
     */
    public function setBody($body)
    {
        return $this->setData(self::BODY, $body);
    }

    /**
     * @return array|mixed|null
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }
}
