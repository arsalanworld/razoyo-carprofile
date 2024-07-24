<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\ViewModel;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CarProfile implements ArgumentInterface
{
    public function __construct(
        private SessionFactory $customerSessionFactory,
        private CustomerRepositoryInterface $customerRepository
    ) {
    }

    /**
     * Get Car Profile data
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProfile()
    {
        $customerData = $this->customerSessionFactory->create();
        $customer = $this->customerRepository->getById($customerData->getId());
        $carProfileAttr = $customer->getCustomAttribute(\Razoyo\CarProfile\Setup\Patch\Data\CarProfile::ATTRIBUTE_CODE);
        return ($carProfileAttr) ? json_decode($carProfileAttr->getValue(), true) : [];
    }
}
