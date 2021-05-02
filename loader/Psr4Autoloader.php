<?php
declare(strict_types=1);

namespace Loader;

class Psr4Autoloader
{
    /**
     * Class map [ namespace => directory ]
     * @var array
     */
    protected array $classMap = [];

    public function addNamespace(string $namespace, string $directory): self
    {
        $namespace = trim($namespace, '\\');
        if (!isset($this->classMap[$namespace])) {
            $this->classMap[$namespace] = [];
        }
        $this->classMap[$namespace][] = trim($directory, DIRECTORY_SEPARATOR);
        return $this;
    }

    public function register(): void
    {
        spl_autoload_register([$this, 'load'], true);
    }

    public function load(string $fullClassName): bool
    {
        if ($file = $this->findFile($fullClassName)) {
            include $file;
            return true;
        }
        return false;
    }

    private function findFile(string $class): bool|string
    {
        $fullPath = strtr($class, '\\', DIRECTORY_SEPARATOR);

        while (false !== $lastPos = strrpos($class, '\\')) {

            $class = trim(substr($class, 0, $lastPos + 1), '\\');
            $prefix = substr($fullPath, 0, $lastPos);

            if (isset($this->classMap[$prefix])) {
                $pathEnd = substr($fullPath, $lastPos) . '.php';
                foreach ($this->classMap[$prefix] as $dir) {
                    if (file_exists($file = $dir . $pathEnd)) {
                        return $file;
                    }
                }
            }
        }

        return false;
    }
}