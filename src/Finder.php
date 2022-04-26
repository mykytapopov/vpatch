<?php
declare(strict_types=1);

namespace MykytaPopov\VPatch;

use MykytaPopov\VPatch\Command\Generate;

class Finder
{
    /**
     * Find files with
     * @param string $path
     * @return array
     */
    public function getOldFiles(string $path, string $extension): array
    {
        if (!file_exists($path)) {
            return [];
        }

        if (is_file($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) === $extension) {
                return [$path];
            }

            if (file_exists($path . '.' . $extension)) {
                return [$path . '.' . $extension];
            }

            return [$path];
        }

        $symfonyFinder = new \Symfony\Component\Finder\Finder();

        $iterator = $symfonyFinder
            ->files()
            ->in($path)
            ->exclude('composer/')
            ->name('*.' . $extension);

        return iterator_to_array($iterator);
    }
}