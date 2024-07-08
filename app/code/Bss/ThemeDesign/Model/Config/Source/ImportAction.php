<?php

namespace Bss\ThemeDesign\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ImportAction implements OptionSourceInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('-- Please Select --')],
            ['value' => 1, 'label' => __('Append')],
            ['value' => 2, 'label' => __('Replace')]
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
            0 => __('-- Please Select --'),
            1 => __('Append'),
            2 => __('Replace')
        ];
    }
}