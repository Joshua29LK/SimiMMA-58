<?php
namespace Bss\ThemeDesign\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Translation extends AbstractFieldArray
{
    /**
     * Rows cache
     *
     * @var array|null
     */
    private $_arrayRowsCache;

    /**
     * @var ScopeConfigInterface
     */
    protected $config;

    public function __construct(
        Context $context,
        ScopeConfigInterface $config,
        array $data = [], 
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        $this->config = $config;
        parent::__construct(
            $context, 
            $data, 
            $secureRenderer
        );
    }
    
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

    /**
     * Obtain existing data from form element
     *
     * Each row will be instance of \Magento\Framework\DataObject
     *
     * @return array
     */
    public function getArrayRows()
    {
        if (null !== $this->_arrayRowsCache) {
            return $this->_arrayRowsCache;
        }
        $result = [];
        /** @var \Magento\Framework\Data\Form\Element\AbstractElement */
        $element = $this->getElement();
        $code = $this->getRequest()->getParam('language');
        $value = $this->config->getValue("languages/translation_list/translation_$code");
        if($value) {
            $element->setValue(json_decode($value, true));
        } else {
            $element->setValue("");
        }
        if ($element->getValue() && is_array($element->getValue())) {
            foreach ($element->getValue() as $rowId => $row) {
                $rowColumnValues = [];
                foreach ($row as $key => $value) {
                    $row[$key] = $value;
                    $rowColumnValues[$this->_getCellInputElementId($rowId, $key)] = $row[$key];
                }
                $row['_id'] = $rowId;
                $row['column_values'] = $rowColumnValues;
                $result[$rowId] = new \Magento\Framework\DataObject($row);
                $this->_prepareArrayRow($result[$rowId]);
            }
        }
        $this->_arrayRowsCache = $result;
        return $this->_arrayRowsCache;
    }
}
