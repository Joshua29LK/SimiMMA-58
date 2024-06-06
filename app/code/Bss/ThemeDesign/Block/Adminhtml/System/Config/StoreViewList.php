<?php
namespace Bss\ThemeDesign\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class StoreViewList extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Template used to render the block
     *
     * @var string
     */
    protected $_template = 'Bss_ThemeDesign::system/config/storeviewlist.phtml';

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
     * Retrieve the initial languages list
     *
     * @return array
     */
    public function getInitLanguagesList()
    {
        $languages = [
            'en_US' => ['name' => 'English (US)', 'flag' => 'us.webp'],
            'it_IT' => ['name' => 'Italian', 'flag' => 'it.webp'],
            'nb_NO' => ['name' => 'Norwegian', 'flag' => 'no.webp'],
            'es_ES' => ['name' => 'Spanish (Spain)', 'flag' => 'es.webp'],
            'zh_CN' => ['name' => 'Chinese (Simplified)', 'flag' => 'cn.webp'],
            'ru_RU' => ['name' => 'Russian', 'flag' => 'ru.webp'],
            'nl_NL' => ['name' => 'Dutch', 'flag' => 'nl.webp'],
            'fr_FR' => ['name' => 'French', 'flag' => 'fr.webp'],
            'ko_KR' => ['name' => 'Korean', 'flag' => 'kr.webp'],
            'th_TH' => ['name' => 'Thai', 'flag' => 'th.webp'],
            'ja_JP' => ['name' => 'Japanese', 'flag' => 'jp.webp'],
            'pt_BR' => ['name' => 'Portuguese (Brazil)', 'flag' => 'br.webp'],
            'pt_PT' => ['name' => 'Portuguese (Portugal)', 'flag' => 'pt.webp'],
            'fr_CA' => ['name' => 'French (Canada)', 'flag' => 'ca.webp'],
            'ar_SA' => ['name' => 'Arabic (Saudi Arabia)', 'flag' => 'sa.webp'],
            'ar_KW' => ['name' => 'Arabic (Kuwait)', 'flag' => 'kw.webp'],
            'ar_MA' => ['name' => 'Arabic (Morocco)', 'flag' => 'ma.webp'],
            'he_IL' => ['name' => 'Hebrew', 'flag' => 'il.webp'],
            'es_MX' => ['name' => 'Spanish (Mexico)', 'flag' => 'mx.webp'],
            'zh_HK' => ['name' => 'Chinese (Hong Kong)', 'flag' => 'hk.webp'],
            'zh_TW' => ['name' => 'Chinese (Taiwan)', 'flag' => 'tw.webp'],
            'de_CH' => ['name' => 'German (Switzerland)', 'flag' => 'ch.webp'],
            'sv_SE' => ['name' => 'Swedish', 'flag' => 'se.webp'],
        ];

        return $languages;
    }
}
