<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class CarProfile implements DataPatchInterface
{
    public const ATTRIBUTE_CODE = 'car_profile';

    public function __construct(
        private \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        private \Magento\Eav\Model\Config $eavConfig,
        private \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    ) {
    }

    public function apply()
    {
        $customerSetup = $this->eavSetupFactory->create();
        $customerSetup->addAttribute(
            Customer::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'varchar',
                'label' => 'car_profile',
                'input' => 'text',
                'required' => false,
                'visible' => false,
                'user_defined' => true,
                'position' => 999,
                'system' => false,
                'default' => ''
            ]
        );

        $attributeSetId = $customerSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $customerSetup->getDefaultAttributeGroupId(Customer::ENTITY);

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE);
        $attribute->setData('attribute_set_id', $attributeSetId);
        $attribute->setData('attribute_group_id', $attributeGroupId);

        $attribute->setData('used_in_forms', []);

        $this->attributeResource->save($attribute);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
