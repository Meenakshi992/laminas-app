<?php
namespace User;

// Add these import statements:
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    // getConfig() 
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    // getServiceConfig()
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

     // getControllerConfig()
     public function getControllerConfig()
     {
         return [
             'factories' => [
                 Controller\AlbumController::class => function($container) {
                     return new Controller\AlbumController(
                         $container->get(Model\AlbumTable::class)
                     );
                 },
             ],
         ];
     }
}