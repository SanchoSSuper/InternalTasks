<?php

namespace Magento\PDFGenerator\Api;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\PDFGenerator\Api\Data\TemplateSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\PDFGenerator\Api\Data\TemplateInterface;

interface TemplateRepositoryInterface
{
    /**
     * @param int $id
     * @return TemplateInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): TemplateInterface;

    /**
     * @param TemplateInterface $template
     * @return TemplateInterface
     * @throws AlreadyExistsException
     */
    public function save(TemplateInterface $template): TemplateInterface;

    /**
     * @param TemplateInterface $template
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TemplateInterface $template): bool;

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TemplateSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TemplateSearchResultInterface;

    /**
     * @return mixed
     */
    public function getNewestTemplate();
}
