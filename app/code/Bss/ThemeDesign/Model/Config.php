<?php
namespace Bss\ThemeDesign\Model;

use Bss\ThemeDesign\Api\ConfigInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{
    /**
     * JSON result factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * Scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        JsonFactory $resultJsonFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get application configuration
     */
    public function getAppConfig()
    {
        $themeConfig = [
            'key_color' => $this->scopeConfig->getValue('themedesign/basic_colors/key_color'),
            'top_menu_icon_color' => $this->scopeConfig->getValue('themedesign/basic_colors/top_menu_icon_color'),
            'button_background_color' => $this->scopeConfig->getValue('themedesign/basic_colors/button_background_color'),
            'button_text_color' => $this->scopeConfig->getValue('themedesign/basic_colors/button_text_color'),
            'menu_background_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_background_color'),
            'menu_text_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_text_color'),
            'menu_line_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_line_color'),
            'menu_icon_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_icon_color'),
            'search_box_background_color' => $this->scopeConfig->getValue('themedesign/advance_colors/search_box_background_color'),
            'search_text_color' => $this->scopeConfig->getValue('themedesign/advance_colors/search_text_color'),
            'app_background_color' => $this->scopeConfig->getValue('themedesign/advance_colors/app_background_color'),
            'content_color' => $this->scopeConfig->getValue('themedesign/advance_colors/content_color'),
            'image_border_color' => $this->scopeConfig->getValue('themedesign/advance_colors/image_border_color'),
            'line_color' => $this->scopeConfig->getValue('themedesign/advance_colors/line_color'),
            'price_color' => $this->scopeConfig->getValue('themedesign/advance_colors/price_color'),
            'special_price_color' => $this->scopeConfig->getValue('themedesign/advance_colors/special_price_color'),
            'icon_color' => $this->scopeConfig->getValue('themedesign/advance_colors/icon_color'),
            'section_color' => $this->scopeConfig->getValue('themedesign/advance_colors/section_color'),
            'status_bar_text_color' => $this->scopeConfig->getValue('themedesign/advance_colors/status_bar_text_color'),
            'loading_color' => $this->scopeConfig->getValue('themedesign/advance_colors/loading_color')
        ];

        $languagesConfig = [];
        $languages = ['en_US', 'it_IT', 'nb_NO', 'es_ES', 'zh_CN', 'ru_RU', 'nl_NL',
            'fr_FR', 'ko_KR', 'th_TH', 'ja_JP', 'pt_BR', 'pt_PT', 'fr_CA', 'ar_SA',
            'ar_KW', 'ar_MA', 'he_IL', 'es_MX', 'zh_HK', 'zh_TW', 'de_CH', 'sv_SE'];

        foreach ($languages as $languageCode) {
            $configValue = $this->scopeConfig->getValue("languages/translation_list_$languageCode");
            if (!empty($configValue)) {
                $decodedValue = json_decode(reset($configValue), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $formattedValue = [];
                    foreach ($decodedValue as $key => $value) {
                        $formattedValue[$key] = [
                            'original' => $value['original'],
                            'translated' => $value['translated']
                        ];
                    }
                    $languagesConfig[$languageCode] = $formattedValue;
                } else {
                    $languagesConfig[$languageCode] = [];
                }
            } else {
                $languagesConfig[$languageCode] = [];
            }
        }
        
        $result = [
            'app-configs' => [
                [
                    'theme' => $themeConfig,
                    'languages' => $languagesConfig
                ]
            ]
        ];
        $resultJson = json_encode($result, JSON_UNESCAPED_UNICODE);
        print_r($resultJson);
    }
}
