<?php

namespace HeptacomAmp\Components;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Shopware\Components\HttpCache\AppCache;
use Shopware\Components\Logger;

class FileCache
{
    /**
     * @var AppCache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * FileCache constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->cache = Shopware()->Container()->get('httpCache');
        $this->cacheDir = implode(DIRECTORY_SEPARATOR, [$this->cache->getCacheDir(), 'heptacom_amp']);
    }

    /**
     * @param $css
     * @param $type
     * @param $callback
     * @return mixed|string
     */
    public function getCachedContents($input, $type, $callback)
    {
        if (!is_dir($typeDir = implode(DIRECTORY_SEPARATOR, [$this->cacheDir, $type]))) {
            if (!mkdir($typeDir, 0777, true)) {
                $this->logger->error('Unable to create cache directory.', ['type_dir' => $typeDir]);
                return call_user_func($callback, $input);
            }
        }

        if (!is_file($fileName = implode(DIRECTORY_SEPARATOR, [$typeDir, hash('md5', $input) . '.amp']))) {
            $processed = call_user_func($callback, $input);
            file_put_contents($fileName, $processed);
            return $processed;
        }

        return file_get_contents($fileName);
    }

    /**
     * @param null $type
     */
    public function clearCache($type = null)
    {
        if ($type !== null) {
            $dir = implode(DIRECTORY_SEPARATOR, [$this->cacheDir, $type]);
        }
        else {
            $dir = $this->cacheDir;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($dir);
    }
}
