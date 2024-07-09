<?php
namespace Bss\ThemeDesign\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class Translation extends ArraySerialized
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var WriterInterface
     */
    protected $configWriter;
    
    public function __construct(
        \Magento\Framework\Model\Context $context, 
        \Magento\Framework\Registry $registry, 
        ScopeConfigInterface $config, 
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, 
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, 
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Framework\App\RequestInterface $request,
        WriterInterface $configWriter,
        array $data = [], 
        Json $serializer = null
    ) {
        $this->request = $request;
        $this->configWriter = $configWriter;
        parent::__construct(
            $context, 
            $registry, 
            $config, 
            $cacheTypeList, 
            $resource, 
            $resourceCollection, 
            $data, 
            $serializer
        );
    }
    /**
     * Perform actions after the configuration is saved
     *
     * @return $this
     * @throws LocalizedException
     */
    public function afterSave()
    {
        parent::afterSave();
        $data = $this->getValue();
        $code = $this->request->getParam('language');
        $path = "languages/translation_list/translation_$code";
        $this->configWriter->save($path, $data, \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT, 0);

        return $this;
    }
}
