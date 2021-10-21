<?php

namespace Magento\PDFGenerator\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\PDFGenerator\Api\Data\TemplateInterface;
use Magento\PDFGenerator\Api\Data\TemplateSearchResultInterface;
use Magento\PDFGenerator\Api\Data\TemplateSearchResultInterfaceFactory;
use Magento\PDFGenerator\Api\TemplateRepositoryInterface;
use Magento\PDFGenerator\Model\ResourceModel\Template as ResourceModel;
use Magento\PDFGenerator\Model\ResourceModel\Template\CollectionFactory;

class TemplateRepository implements TemplateRepositoryInterface
{
    /**
     * @var TemplateFactory
     */
    private $templateFactory;

    /**
     * @var ResourceModel
     */
    private $templateResource;

    /**
     * @var CollectionFactory
     */
    private $templateCollectionFactory;

    /**
     * @var TemplateSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param TemplateFactory $templateFactory
     * @param ResourceModel $templateResource
     * @param CollectionFactory $templateCollectionFactory
     * @param TemplateSearchResultInterfaceFactory $templateSearchResultInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        TemplateFactory                      $templateFactory,
        ResourceModel                        $templateResource,
        CollectionFactory                    $templateCollectionFactory,
        TemplateSearchResultInterfaceFactory $templateSearchResultInterfaceFactory,
        CollectionProcessorInterface         $collectionProcessor
    ) {
        $this->templateFactory = $templateFactory;
        $this->templateResource = $templateResource;
        $this->templateCollectionFactory = $templateCollectionFactory;
        $this->searchResultFactory = $templateSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return TemplateInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): TemplateInterface
    {
        $template = $this->templateFactory->create();
        $this->templateResource->load($template, $id);
        if (!$template->getId()) {
            throw new NoSuchEntityException(__('Unable to find Student with ID "%1"', $id));
        }
        return $template;
    }

    /**
     * @param TemplateInterface $template
     * @return TemplateInterface
     * @throws AlreadyExistsException
     */
    public function save(TemplateInterface $template): TemplateInterface
    {
        $this->templateResource->save($template);
        return $template;
    }

    /**
     * @param TemplateInterface $template
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TemplateInterface $template): bool
    {
        try {
            $this->templateResource->delete($template);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TemplateSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TemplateSearchResultInterface
    {
        $collection = $this->templateCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @return TemplateInterface
     * @throws NoSuchEntityException
     */
    public function getNewestTemplate()
    {
        $id = '';
        $templateCreatedAt = '';
        $collection = $this->templateCollectionFactory->create();
        foreach ($collection->getItems() as $key => $item) {
            if(!$templateCreatedAt || $templateCreatedAt < $item['created_at']) {
                $id = $key;
                $templateCreatedAt = $item['created_at'];
            }
        }

        return $this->getById($id);
    }
}
