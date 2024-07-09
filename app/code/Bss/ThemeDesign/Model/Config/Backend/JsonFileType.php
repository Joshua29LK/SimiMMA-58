<?php
namespace Bss\ThemeDesign\Model\Config\Backend;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Config\Storage\WriterInterface;

class JsonFileType extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * @var WriterInterface
     */
    protected $configWriter;
    public function __construct(
        \Magento\Framework\Model\Context $context, 
        \Magento\Framework\Registry $registry, 
        ScopeConfigInterface $config, 
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, 
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface $requestData, 
        Filesystem $filesystem, 
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, 
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        WriterInterface $configWriter,
        array $data = []
    ) {
        $this->configWriter = $configWriter;
        parent::__construct(
            $context, 
            $registry, 
            $config, 
            $cacheTypeList, 
            $uploaderFactory, 
            $requestData, 
            $filesystem, 
            $resource, 
            $resourceCollection, 
            $data
        );
    }
    /**
     * @return string[]
     */
    public function getAllowedExtensions() {
        return ['json'];
    }

    public function afterSave()
    {
        $fileName = $this->getValue();
        if($fileName) {
            $fileName = str_replace('default/', '', $fileName);
            $filePath = $this->_getUploadDir() . '/' . $fileName;

            if (file_exists($filePath)) {
                $fileContents = file_get_contents($filePath);
                $jsonData = json_decode($fileContents, true);

                $listLanguage = [];
                if ($jsonData !== null && json_last_error() === JSON_ERROR_NONE) {
                    foreach ($jsonData as $code => $listTranslation) {
                        $listLanguage[] = $code;
                        $this->saveToConfig($code, $listTranslation);
                    }
                    if($listLanguage) {
                        $this->configWriter->save('languages/translation_list/list', json_encode($listLanguage));
                    }
                    $this->configWriter->save('languages/language_import_json/language_file_upload', "");
                    unlink($filePath);
                } else {
                    throw new \Exception("File is not valid JSON.");
                }
            }
        }

        return parent::afterSave();
    }

    public function saveToConfig($code, $listTranslation)
    {
        try {
            $path = "languages/translation_list/translation_$code";
            $currentValue = $this->_config->getValue($path);
            
            $formattedData = [];
            foreach ($listTranslation as $original => $translated) {
                $uniqueKey = "_".uniqid()."_";
                $formattedData[$uniqueKey] = [
                    'original' => $original,
                    'translated' => $translated,
                ];
            }
            $jsonFormattedData = json_encode($formattedData);
            
            if ($currentValue) {
                $newValue = json_decode($currentValue, true);
                if (is_array($newValue) && is_array($formattedData)) {
                    $newValue = array_merge($newValue, $formattedData);
                } else {
                    $newValue = $formattedData;
                }
                $uniqueValues = [];
                $uniqueKeys = [];
                foreach ($newValue as $key => $item) {
                    $original = $item['original'];
                    $uniqueValues[$original] = $item;
                    $uniqueKeys[$original] = $key;
                }
                $finalValues = [];
                foreach ($uniqueKeys as $original => $key) {
                    $finalValues[$key] = $uniqueValues[$original];
                }
                $newValue = json_encode($finalValues);
            } else {
                $newValue = $jsonFormattedData;
            }
            
            $this->configWriter->save($path, $newValue, \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT, 0);
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
    }

}