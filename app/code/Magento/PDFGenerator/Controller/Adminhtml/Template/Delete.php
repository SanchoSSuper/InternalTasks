<?php

namespace Magento\PDFGenerator\Controller\Adminhtml\Template;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;
use Magento\PDFGenerator\Api\TemplateRepositoryInterface;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Template';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var TemplateRepositoryInterface
     */
    protected $templateRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param TemplateRepositoryInterface $templateRepositoryInterface
     */
    public function __construct(
        Context                            $context,
        PageFactory                        $resultPageFactory,
        TemplateRepositoryInterface $templateRepositoryInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->templateRepository = $templateRepositoryInterface;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $result = $resultRedirect->setPath('*/*/index', array('_current' => true));
        try {
            $id = $this->getRequest()->getParam('id');
            $this->templateRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Template has been deleted!'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete template'));
            $result = $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        return $result;
    }
}
