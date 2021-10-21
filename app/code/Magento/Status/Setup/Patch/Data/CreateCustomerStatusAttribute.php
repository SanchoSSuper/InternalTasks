<?php

namespace Magento\Status\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\ResourceModel\Attribute;

class CreateCustomerStatusAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private CustomerSetupFactory $customerSetupFactory;

    /**
     * @var SetFactory
     */
    private SetFactory $attributeSetFactory;

    /**
     * @var Attribute
     */
    private Attribute $attribute;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param SetFactory $attributeSetFactory
     * @param Attribute $attribute
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        SetFactory $attributeSetFactory,
        Attribute $attribute
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attribute = $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $customerSetup = $this->customerSetupFactory->create();
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'customer_status',
            [
                'type' => 'int',
                'label' => 'Status',
                'input' => 'select',
                'required' => false,
                'visible' => true,
                'source' => 'Magento\Status\Model\Config\Source\CustomerStatus',
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
            ]
        );

        $sampleAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'customer_status')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address'],
            ]);

        $this->attribute->save($sampleAttribute);

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
