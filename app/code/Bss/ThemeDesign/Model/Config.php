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
        $themeSelected = $this->scopeConfig->getValue('themedesign/theme_list/selected_theme');
        
        $themeConfig = [
            'theme_selected' => $themeSelected,
            'key_color' => $this->scopeConfig->getValue('themedesign/basic_colors/key_color'),
            'top_menu_icon_color' => $this->scopeConfig->getValue('themedesign/basic_colors/top_menu_icon_color'),
            'button_background' => $this->scopeConfig->getValue('themedesign/basic_colors/button_background_color'),
            'button_text_color' => $this->scopeConfig->getValue('themedesign/basic_colors/button_text_color'),
            'menu_background' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_background_color'),
            'menu_text_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_text_color'),
            'menu_line_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_line_color'),
            'menu_icon_color' => $this->scopeConfig->getValue('themedesign/basic_colors/menu_icon_color'),
            'search_box_background' => $this->scopeConfig->getValue('themedesign/advance_colors/search_box_background_color'),
            'search_text_color' => $this->scopeConfig->getValue('themedesign/advance_colors/search_text_color'),
            'app_background' => $this->scopeConfig->getValue('themedesign/advance_colors/app_background_color'),
            'content_color' => $this->scopeConfig->getValue('themedesign/advance_colors/content_color'),
            'image_border_color' => $this->scopeConfig->getValue('themedesign/advance_colors/image_border_color'),
            'line' => $this->scopeConfig->getValue('themedesign/advance_colors/line_color'),
            'price_color' => $this->scopeConfig->getValue('themedesign/advance_colors/price_color'),
            'special_price_color' => $this->scopeConfig->getValue('themedesign/advance_colors/special_price_color'),
            'icon_color' => $this->scopeConfig->getValue('themedesign/advance_colors/icon_color'),
            'section_color' => $this->scopeConfig->getValue('themedesign/advance_colors/section_color'),
            'status_bar_text' => $this->scopeConfig->getValue('themedesign/advance_colors/status_bar_text_color'),
            'loading_color' => $this->scopeConfig->getValue('themedesign/advance_colors/loading_color')
        ];

        $languagesConfig = [];
        $languages = $this->scopeConfig->getValue("languages/translation_list/list");
        if($languages) {
            $languages = json_decode($languages, true);
            foreach ($languages as $languageCode) {
                $configValue = $this->scopeConfig->getValue("languages/translation_list/translation_$languageCode");
                if ($configValue) {
                    $decodedValue = json_decode($configValue, true);
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
        return $resultJson;
    }
}
