<?php
namespace Bss\ThemeDesign\Model\Api;
use Lyranetwork\Epaync\Block\Payment\Rest\Head as LyranetworkHeade;
class AppConfigs extends \Simi\Simiconnector\Model\Api\Apiabstract
{
    public $DEFAULT_ORDER = 'store_id';
    public $method = 'callApi';

    public function setBuilderQuery()
    {
    }

    public function index()
    {
        return $this->getAppConfig();
    }

    /**
     * Get application configuration
     */
    public function getAppConfig()
    {
        $themeSelected = $this->getStoreConfig('themedesign/theme_list/selected_theme');

        $themeConfig = [
            'theme_selected' => $themeSelected,
            'key_color' => $this->getStoreConfig('themedesign/basic_colors/key_color'),
            'top_menu_icon_color' => $this->getStoreConfig('themedesign/basic_colors/top_menu_icon_color'),
            'button_background' => $this->getStoreConfig('themedesign/basic_colors/button_background_color'),
            'button_text_color' => $this->getStoreConfig('themedesign/basic_colors/button_text_color'),
            'menu_background' => $this->getStoreConfig('themedesign/basic_colors/menu_background_color'),
            'menu_text_color' => $this->getStoreConfig('themedesign/basic_colors/menu_text_color'),
            'menu_line_color' => $this->getStoreConfig('themedesign/basic_colors/menu_line_color'),
            'menu_icon_color' => $this->getStoreConfig('themedesign/basic_colors/menu_icon_color'),
            'search_box_background' => $this->getStoreConfig('themedesign/advance_colors/search_box_background_color'),
            'search_text_color' => $this->getStoreConfig('themedesign/advance_colors/search_text_color'),
            'app_background' => $this->getStoreConfig('themedesign/advance_colors/app_background_color'),
            'content_color' => $this->getStoreConfig('themedesign/advance_colors/content_color'),
            'image_border_color' => $this->getStoreConfig('themedesign/advance_colors/image_border_color'),
            'line' => $this->getStoreConfig('themedesign/advance_colors/line_color'),
            'price_color' => $this->getStoreConfig('themedesign/advance_colors/price_color'),
            'special_price_color' => $this->getStoreConfig('themedesign/advance_colors/special_price_color'),
            'icon_color' => $this->getStoreConfig('themedesign/advance_colors/icon_color'),
            'section_color' => $this->getStoreConfig('themedesign/advance_colors/section_color'),
            'status_bar_text' => $this->getStoreConfig('themedesign/advance_colors/status_bar_text_color'),
            'loading_color' => $this->getStoreConfig('themedesign/advance_colors/loading_color')
        ];

        $languagesConfig = [];
        $languages = ['en_US', 'it_IT', 'nb_NO', 'es_ES', 'zh_CN', 'ru_RU', 'nl_NL',
            'fr_FR', 'ko_KR', 'th_TH', 'ja_JP', 'pt_BR', 'pt_PT', 'fr_CA', 'ar_SA',
            'ar_KW', 'ar_MA', 'he_IL', 'es_MX', 'zh_HK', 'zh_TW', 'de_CH', 'sv_SE'];

        foreach ($languages as $languageCode) {
            $configValue = $this->getStoreConfig("languages/translation_list_$languageCode");
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

        return $result;
    }
}