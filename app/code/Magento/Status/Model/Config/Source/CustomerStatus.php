<?php

namespace Magento\Status\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Source model for customer status type
 */
class CustomerStatus extends AbstractSource
{
    /**
     * @return array[]
     */
    public function getAllOptions(): array
    {
        return [
            ['value' => 0, 'label' => __('Happy')],
            ['value' => 1, 'label' => __('Sad')],
            ['value' => 2, 'label' => __('Angry')],
        ];
    }

    /**
     * @param AbstractAttribute $attribute
     * @return AbstractFrontend
     */
    public function setAttribute($attribute)
    {
        return parent::setAttribute($attribute);
    }
}
