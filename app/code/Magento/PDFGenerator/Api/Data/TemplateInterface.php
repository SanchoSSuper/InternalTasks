<?php

namespace Magento\PDFGenerator\Api\Data;

interface TemplateInterface
{
    const TABLE = 'pdf_templates';

    const TEMPLATE_ID = 'template_id';
    const IS_ENABLED = 'is_enabled';
    const HEADER = 'header';
    const FOOTER = 'footer';
    const BODY = 'body';
    const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getTemplateId(): int;

    /**
     * @return mixed
     */
    public function getIsEnabled();

    /**
     * @param $isEnabled
     * @return mixed
     */
    public function setIsEnabled($isEnabled);

    /**
     * @return mixed
     */
    public function getHeader();

    /**
     * @param $header
     * @return mixed
     */
    public function setHeader($header);

    /**
     * @return mixed
     */
    public function getFooter();

    /**
     * @param $footer
     * @return mixed
     */
    public function setFooter($footer);

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @param $body
     * @return mixed
     */
    public function setBody($body);

    /**
     * @return mixed
     */
    public function getCreatedAt();
}
