<?php
namespace Bss\ThemeDesign\Model;

class Server extends \Simi\Simiconnector\Model\Server
{
    /**
     * @return mixed|string
     * @throws Exception
     * error code
     * 1 Not Login
     * 2 Miss username or password to login
     * 3 Access Denied
     * 4 Invalid method
     * 5 Login failed
     * 6 Resource cannot callable
     * 7 Missed input Value
     */
    public function run()
    {
        $this->helper = $this->simiObjectManager->get('\Simi\Simiconnector\Helper\Data');
        $data = $this->data;
        if (count($data) == 0) {
            throw new \Simi\Simiconnector\Helper\SimiException(__('Invalid method.'), 4);
        }

        if (!isset($data['resource'])) {
            throw new \Simi\Simiconnector\Helper\SimiException(__('Invalid method.'), 4);
        }

        if (!$this->_getCheckoutSession()->getData('simiconnector_platform')) {
            $this->_getCheckoutSession()->setData('simiconnector_platform', 'native');
        }
        
        if($data['resource'] == "app_configs") {
            $className = "Bss\ThemeDesign\Model\Api\AppConfigs";
        } else {
            if ((strpos($data['resource'], 'migrate')) !== false) {
                $migrateResource = explode('_', $data['resource'])[1];
                $className = 'Simi\\' . ucfirst($data['module']) . '\Model\Api\Migrate\\' . ucfirst($migrateResource);
            } else {
                $className = 'Simi\\' . ucfirst($data['module']) . '\Model\Api\\' . ucfirst($data['resource']);
            }
        }
        if (!class_exists($className)) {
            throw new \Simi\Simiconnector\Helper\SimiException(__('Invalid method.'), 4);
        }

        $model = $this->simiObjectManager->get($className);

        if (is_callable([&$model, $this->method])) {
            //Avoid using direct function, need to change solution when found better one
            $callFunctionName = 'call_user_func_array';
            $this->result = $callFunctionName([&$model, $this->method], [$data]);
            $this->eventManager->dispatch(
                'simi_simiconnector_model_server_return_' . $data['resource'],
                ['object' => $this, 'data' => $this->data]
            );
            return $this->result;
        }
        throw new \Simi\Simiconnector\Helper\SimiException(__('Resource cannot callable.'), 4);
    }
}
