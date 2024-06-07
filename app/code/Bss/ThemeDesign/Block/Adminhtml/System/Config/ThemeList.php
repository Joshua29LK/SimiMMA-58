<?php
namespace Bss\ThemeDesign\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ThemeList extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Template used to render the block
     *
     * @var string
     */
    protected $_template = 'Bss_ThemeDesign::system/config/themelist.phtml';

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * Render element HTML
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        return $this->toHtml();
    }
    
    /**
     * Retrieve the selected theme
     *
     * @return array
     */
    public function getSelectedTheme()
    {
        return $this->scopeConfig->getValue('themedesign/theme_list/selected_theme');
    }
    
    /**
     * Retrieve the initial theme list
     *
     * @return array
     */
    public function getInitThemesList()
    {
        $theme = [
            'standard' => ['name' => 'Standard', 'flag' => 'standard.webp'],
            'matrix' => ['name' => 'Matrix', 'flag' => 'matrix.jpg'],
            'zara' => ['name' => 'Zara', 'flag' => 'zara.jpg']
        ];

        return $theme;
    }
}
