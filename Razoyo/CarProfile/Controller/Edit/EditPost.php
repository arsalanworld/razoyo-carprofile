<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Edit;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Phrase;


class EditPost implements AccountInterface, CsrfAwareActionInterface, HttpPostActionInterface
{
    public function __construct(
        private RedirectFactory $resultRedirectFactory,
        private Validator $formKeyValidator,
        private RequestInterface $request
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit');

        return new InvalidRequestException(
            $resultRedirect,
            [new Phrase('Invalid Form Key. Please refresh the page.')]
        );
    }

    /**
     * Retrieve request object
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}
