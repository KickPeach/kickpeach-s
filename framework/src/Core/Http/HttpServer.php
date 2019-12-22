<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Http;

use KickPeachs\Core\Annotation\Mapping\RequestMapping;
use KickPeachs\Core\Annotation\Parser\RequestMappingParser;
use KickPeachs\Core\Bean\BeanFactory;
use Swoole;

class HttpServer
{

    protected $httpServer;

    public function run()
    {
        BeanFactory::get('Config')->load();
        $config = BeanFactory::get('Config')->get("http");
        $this->httpServer = new Swoole\Http\Server($config['host'], $config['port']);
        $this->httpServer->set($config['setting']);
        $this->httpServer->on('start', [$this, 'start']);
        $this->httpServer->on('workerStart', [$this, 'workerStart']);
        $this->httpServer->on('request', [$this, 'request']);

        $this->httpServer->start();
    }

    public function start()
    {
        $reload = BeanFactory::get('Reload');
        $reload->watchDir = [CONFIG_PATH, APP_PATH, ROOT_PATH];
        $reload->md5Value = $reload->getFilesMd5();

        \Swoole\Timer::Tick(2000, function () use ($reload) {
            if ($reload->checkReload()) {
                $this->httpServer->reload();
            }
        });

        $config = BeanFactory::get('Config')->get("http");
        echo "***********************************************************************" . PHP_EOL;
        echo sprintf("*HTTP     | Listen: %s:%d, type: TCP, worker: %d  ", $config['host'], $config['port'], $config['setting']['worker_num']) . PHP_EOL;
        if (isset($config['rpcEnable']) && (int)$config['rpcEnable'] === 1) {
            $config = BeanFactory::get('Config')->get("rpc");
            echo sprintf("*RPC      | Listen: %s:%d, type: TCP, worker: %d  ", $config['host'], $config['port'], $config['setting']['worker_num']) . PHP_EOL;
            echo "***********************************************************************" . PHP_EOL;
        }
    }


    public function workerStart()
    {
        $this->loadAnnotations();

    }

    public function request($request, $response)
    {
        $path_info = $request->server['path_info'];
        $method = $request->server['request_method'];

        $response->end($path_info . $method);
    }

    private function loadAnnotations()
    {
        $controllerFiles = $this->treeAppPath(APP_PATH, "Controller");
        if (empty($controllerFiles)) {
            return;
        }

        foreach ($controllerFiles as $controllerFile) {
            $className = explode('.', end(explode('/', $controllerFile)))[0];
            $fileContent = file_get_contents($controllerFile, false, null, 0, 500);

            preg_match('/namespace\s(.*)/i', $fileContent, $nameSpace);
            if (!isset($nameSpace[1])) {
                return;
            }

            $nameSpace = str_replace([' ', ';', '"'], '', $nameSpace[1]);
            $className = trim($nameSpace) . "\\" . $className;

            $obj = new $className;
            $reflectClass = new \ReflectionClass($obj);
            $classDocComment = $reflectClass->getDocComment();

            if (!$classDocComment) {
                return;
            }

            foreach ($reflectClass->getMethods() as $method) {
                $methodDocComment = $method->getDocComment();
                if (!$methodDocComment) {
                    return;
                }

                (new RequestMappingParser())->parse((new RequestMapping($classDocComment, $methodDocComment, $reflectClass, $method)));
            }
        }

    }

    private function treeAppPath($dirPath, $filter)
    {
        $dirs = glob($dirPath . '/*');
        $dirsArr = [];

        if (empty($dirs)) {
            return $dirsArr;
        }

        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                $res = $this->treeAppPath($dir, $filter);
                $dirsArr = array_merge($dirsArr, $res);
            } else {
                if (stristr($dir, $filter)) {
                    $dirsArr[] = $dir;
                }
            }
        }
        return $dirsArr;
    }
}
