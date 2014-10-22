<?php
namespace OnyxPrize;

use OnyxPrize\Model\OnyxPrize;
use OnyxPrize\Model\OnyxPrizeTable;
use OnyxPrize\Model\OnyxPrizeSetting;
use OnyxPrize\Model\OnyxPrizeSettingTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(                      
                'OnyxPrize' => function($sm){
                    return new OnyxPrize($sm);
                },                
                'OnyxPrizeTable' =>  function($sm) {
                    $tableGateway = $sm->get('OnyxPrizeTableGateway');
                    $table = new OnyxPrizeTable($tableGateway);
                    return $table;
                },
                'OnyxPrizeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype($sm->get('OnyxPrize'));
                    return new TableGateway('onyx_prize', $dbAdapter, null, $resultSetPrototype);
                },  
                'OnyxPrizeSetting' => function($sm){
                    return new OnyxPrizeSetting($sm);
                },                
                'OnyxPrizeSettingTable' =>  function($sm) {
                    $tableGateway = $sm->get('OnyxPrizeSettingTableGateway');
                    $table = new OnyxPrizeSettingTable($tableGateway);
                    return $table;
                },
                'OnyxPrizeSettingTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype($sm->get('OnyxPrizeSetting'));
                    return new TableGateway('onyx_prize_setting', $dbAdapter, null, $resultSetPrototype);
                },  
            ),
            
        );
    }


}
