<?php
namespace Razoyo\CarProfile\Controller\Index;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;

class Index implements AccountInterface
{
    /**
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        private PageFactory $resultPageFactory,
        private RedirectFactory $resultRedirectFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultRedirectFactory->create()->setPath('*/edit/new');
        return $this->resultPageFactory->create();
    }
}
