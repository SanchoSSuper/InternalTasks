<?php

namespace Magento\PDFGenerator\Controller\Adminhtml\Template;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;
use Magento\PDFGenerator\Api\Data\TemplateInterface;
use Magento\PDFGenerator\Api\TemplateRepositoryInterface;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Template';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var TemplateRepositoryInterface
     */
    private $templateRepository;

    /**
     * @var TemplateInterface
     */
    private $template;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param TemplateRepositoryInterface $templateRepositoryInterface
     * @param TemplateInterface $templateInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        TemplateRepositoryInterface $templateRepositoryInterface,
        TemplateInterface $templateInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->templateRepository = $templateRepositoryInterface;
        $this->template = $templateInterface;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $result = $resultRedirect->setPath('*/*/');

        if($data) {
            $this->template->setData($data);
            try{
                $data = array_filter($data, function($value) {return $value !== ''; });
                $this->templateRepository->save($this->template);
                $this->messageManager->addSuccessMessage(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                $result = $resultRedirect->setPath('*/*/');
            } catch(Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                $result = $resultRedirect->setPath('*/*/edit', ['id' => $this->template->getTemplateId()]);
            }
        }

        return $result;
    }
}
