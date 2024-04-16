<?php

declare(strict_types=1);

namespace SFC\Staticfilecache\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * RemoveService.
 */
class RemoveService extends AbstractService
{
    /**
     * Dirs that are created with "softRemoveDir" and dropped with "runRemoveDir".
     */
    protected array $removeDirs = [];

    /**
     * Finally remove the dirs.
     */
    public function __destruct()
    {
        $this->removeQueueDirectories();
    }

    public function removeQueueDirectories(): void
    {
        foreach ($this->removeDirs as $removeDir) {
            GeneralUtility::rmdir($removeDir, true);
        }
        $this->removeDirs = [];
    }

    /**
     * Remove the given file. If the file do not exists, the function return true.
     */
    public function file(string $absoulteFileName): bool
    {
        if (!is_file($absoulteFileName)) {
            return true;
        }

        return (bool) unlink($absoulteFileName);
    }

    /**
     * Add the subdirectories of the given folder to the remove function.
     */
    public function subdirectories(string $absoluteDirName): self
    {
        if (!is_dir($absoluteDirName)) {
            return $this;
        }

        foreach (new \DirectoryIterator($absoluteDirName) as $item) {
            /** @var \DirectoryIterator $item */
            if ($item->isDir() && !$item->isDot()) {
                $this->directory($item->getPathname() . '/');
            }
        }

        return $this;
    }

    /**
     * Rename the dir and mark them as "to remove".
     * Speed up the remove process.
     */
    public function directory(string $absoluteDirName): self
    {
        if (is_dir($absoluteDirName)) {
            $tempAbsoluteDir = rtrim($absoluteDirName, '/') . '_' . round(microtime(true) * 1000) . '/';
            rename($absoluteDirName, $tempAbsoluteDir);
            $this->removeDirs[] = $tempAbsoluteDir;
        }

        return $this;
    }
}
