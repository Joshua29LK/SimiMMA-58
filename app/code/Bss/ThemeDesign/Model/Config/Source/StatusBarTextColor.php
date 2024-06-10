<?php

namespace Bss\ThemeDesign\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class StatusBarTextColor implements OptionSourceInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '#000000', 'label' => __('Dark')],
            ['value' => '#ffffff', 'label' => __('Light')]
        ];
    }

    /**
     * Retrieve options for select in admin configuration.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            '#000000' => __('Dark'),
            '#ffffff' => __('Light')
        ];
    }
}