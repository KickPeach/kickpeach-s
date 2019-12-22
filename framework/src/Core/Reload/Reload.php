<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Reload;


class Reload
{
    private static $instance;
    public $watchDir = [];
    public  $md5Value;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function checkReload()
    {
        $newMd5Value = $this->getFilesMd5();
        if ($newMd5Value == $this->md5Value) {
            return false;
        }

        $this->md5Value = $newMd5Value;
        return true;
    }

    private static function md5file($dir)
    {
        $md5File = [];
        if (!is_dir($dir)) {
            return '';
        }

        $d = dir($dir);
        while (false !== ($entry = $d->read())) {
            if ($entry !== '.' && $entry !== '..') {
                if (is_dir($dir . '/' . $entry)) {
                    $md5File[] = self::md5File($dir . '/' . $entry);
                } elseif (substr($entry, -4) === '.php') {
                    $md5File[] = md5_file($dir . '/' . $entry);
                }
                $md5File[] = $entry;
            }
        }
        $d->close();
        return md5(implode('', $md5File));

    }

    public function getFilesMd5()
    {
        $md5 = '';
        foreach ($this->watchDir as $dir) {
            $md5 .= self::md5file($dir);
        }
        return md5($md5);
    }
}