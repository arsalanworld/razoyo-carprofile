<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Edit;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Controller\AccountInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Phrase;
use Razoyo\CarProfile\Setup\Patch\Data\CarProfile;


class EditPost implements AccountInterface, CsrfAwareActionInterface, HttpPostActionInterface
{
    public function __construct(
        private RedirectFactory $resultRedirectFactory,
        private Validator $formKeyValidator,
        private RequestInterface $request,
        private Session $session,
        private CustomerRepositoryInterface $customerRepository,
        private ManagerInterface $messageManager
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());
        $path = '*/*/form';
        if ($validFormKey && $this->getRequest()->isPost()) {
            $customerId = $this->session->getCustomerId();
            $customer = $this->customerRepository->getById($customerId);
            $data = $this->getRequest()->getPost();
            if (!isset($data['car_profile'])) {
                $this->messageManager->addErrorMessage(__('Car Profile is required.'));
            } else {
                try {
                    // Decode and convert to a proper format
                    $carProfile = json_decode($data['car_profile'], true);
                    $customer->setCustomAttribute(CarProfile::ATTRIBUTE_CODE, json_encode($carProfile));
                    $this->customerRepository->save($customer);
                    $path = '*/index/index';
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__($e->getMessage()));
                }
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($path);

        return $resultRedirect;
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
