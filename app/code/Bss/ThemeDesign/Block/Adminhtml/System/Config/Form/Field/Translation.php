<?php
namespace Bss\ThemeDesign\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Translation extends AbstractFieldArray
{
    /**
     * Prepare to render the block
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('original', ['label' => __('Original Text')]);
        $this->addColumn('translated', ['label' => __('Translated Text')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
