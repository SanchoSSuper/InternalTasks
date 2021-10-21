<?php

namespace Magento\PDFGenerator\Controller\Adminhtml\Template;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\PDFGenerator\Api\TemplateRepositoryInterface;

/**
 * Delete several articles
 */
class MassDelete extends Action
{
    /**
     * @var TemplateRepositoryInterface
     */
    private $templateRepository;

    /**
     * @param Context $context
     * @param TemplateRepositoryInterface $templateRepositoryInterface
     */
    public function __construct(
        Context $context,
        TemplateRepositoryInterface $templateRepositoryInterface
    ) {
        parent::__construct($context);
        $this->templateRepository = $templateRepositoryInterface;
    }

    /**
     * @return Redirect
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect
    {
        $ids = $this->getRequest()->getParam('selected', []);
        $resultRedirect = $this->resultRedirectFactory->create();
        $result = $resultRedirect->setPath('*/*/index', ['_current' => true]);

        if (!is_array($ids) || !count($ids)) {
            $result =  $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        foreach ($ids as $id) {
            if ($this->templateRepository->getById($id)) {
                try {
                    $this->templateRepository->deleteById($id);
                } catch (CouldNotDeleteException $e) {
                    $this->messageManager->addErrorMessage(__('Error while trying to delete template with id' . $id));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    $result =  $resultRedirect->setPath('*/*/index', array('_current' => true));
                }
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($ids)));

        return $result;
    }
}
