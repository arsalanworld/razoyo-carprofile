<?php
namespace Razoyo\CarProfile\Controller\Edit;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Form implements AccountInterface, HttpGetActionInterface
{
    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        private PageFactory $resultPageFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
