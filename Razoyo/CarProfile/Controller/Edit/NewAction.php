<?php
namespace Razoyo\CarProfile\Controller\Edit;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

class NewAction implements AccountInterface, HttpGetActionInterface
{
    /**
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        private ForwardFactory $resultForwardFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('form');
    }
}
