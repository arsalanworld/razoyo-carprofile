<?php
namespace Razoyo\CarProfile\Controller\Index;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements AccountInterface
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
