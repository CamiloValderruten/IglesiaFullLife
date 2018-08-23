<?php

namespace YOOtheme\Theme;

use YOOtheme\Controller;

class CacheController extends Controller
{
    public function index($request, $response)
    {
        return $response->withJson(['files' => iterator_count($this->getFiles())]);
    }

    public function clear($request, $response)
    {
        foreach ($this->getFiles() as $file) {
            if ($file->isFile()) {
                unlink($file->getRealPath());
            } else if ($file->isDir()) {
                rmdir($file->getRealPath());
            }
        }

        return $response->withJson(['message' => 'success']);
    }

    protected function getFiles()
    {
        return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this['path.cache'], \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS), \RecursiveIteratorIterator::CHILD_FIRST);
    }
}
