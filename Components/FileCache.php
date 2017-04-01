<?php

namespace HeptacomAmp\Components;

use Shopware\Components\Logger;

class FileCache
{
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
        $this->cacheDir = implode(DIRECTORY_SEPARATOR, [
            Shopware()->Container()->getParameter('shopware.httpCache.cache_dir'),
            'heptacom_amp'
        ]);
    }

    /**
     * @param string $css
     * @param string $type
     * @param Callable $callback
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
     * @param string $css
     * @param string $type
     * @param Callable $callback
     * @param Callable $serialize
     * @param Callable $unserialize
     * @return mixed|string
     */
    public function getCachedSerializedContents($input, $type, $callback, $serialize, $unserialize)
    {
        if (!is_dir($typeDir = implode(DIRECTORY_SEPARATOR, [$this->cacheDir, $type]))) {
            if (!mkdir($typeDir, 0777, true)) {
                $this->logger->error('Unable to create cache directory.', ['type_dir' => $typeDir]);
                return call_user_func($callback, $input);
            }
        }

        if (!is_file($fileName = implode(DIRECTORY_SEPARATOR, [$typeDir, hash('md5', $input) . '.amp']))) {
            $processed = call_user_func($callback, $input);
            file_put_contents($fileName, $serialize($processed));
            return $processed;
        }

        return $unserialize(file_get_contents($fileName));
    }
}
