<?php

namespace Magento\PDFGenerator\Controller\PDF;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Template\Filter;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\PDFGenerator\Api\TemplateRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class GeneratePDF implements HttpGetActionInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TemplateRepositoryInterface
     */
    private $templateRepository;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @param LoggerInterface $logger
     * @param Filter $filter
     * @param StoreManagerInterface $storeManager
     * @param TemplateRepositoryInterface $templateRepository
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        LoggerInterface             $logger,
        Filter                      $filter,
        StoreManagerInterface       $storeManager,
        TemplateRepositoryInterface $templateRepository,
        BlockRepositoryInterface    $blockRepository
    ) {
        $this->logger = $logger;
        $this->filter = $filter;
        $this->storeManager = $storeManager;
        $this->templateRepository = $templateRepository;
        $this->blockRepository = $blockRepository;
    }

    /**
     *
     */
    public function execute()
    {
        $this->pdfGenerator();
    }

    /**
     * Generate PDF file from url data
     */
    public function pdfGenerator()
    {
        $html2pdf = new Html2Pdf('P', 'A4', 'en');
        $template = $this->templateRepository->getNewestTemplate();
        $data['header'] = $this->blockRepository->getById($template->getHeader())->getIdentifier();
        $data['footer'] = $this->blockRepository->getById($template->getFooter())->getIdentifier();

        $html = $this->filter->setVariables($data)
            ->filter($template->getBody());

        $html2pdf->writeHTML($html);
        try {
            $html2pdf->output('myPdf.pdf', 'D');
        } catch (Html2PdfException $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
