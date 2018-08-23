<?php

namespace YOOtheme\Theme;

use YOOtheme\Controller;
use YOOtheme\Http\Exception\BadRequestException;
use YOOtheme\Util\File;

class StyleController extends Controller
{
    public function index($request, $response)
    {
        $styles = [];
        $imports = [];

        // add styles
        foreach ($this['locator']->findAll('@theme/less/theme.*.less') as $file) {
            $styles[substr(basename($file, '.less'), 6)] = [
                'filename' => $this['url']->to($file),
                'contents' => file_get_contents($file)
            ];
        }

        $resolve = function ($file) use (&$imports, &$resolve) {

            $imports[File::normalizePath($this['url']->to($file))] = $contents = @file_get_contents($file) ?: '';

            if (preg_match_all('/^@import.*"(.*)";/m', $contents, $matches)) {
                foreach ($matches[1] as $path) {
                    $resolve(dirname($file).'/'.$path);
                }
            }

        };

        // add imports
        if (isset($this['theme']->options['styles']['imports'])) {
            foreach ((array) $this['theme']->options['styles']['imports'] as $path) {
                foreach ($this['locator']->findAll("@theme/{$path}") as $file) {
                    $resolve($file);
                }
            }
        }

        return $response->withJson(compact('styles', 'imports'));
    }

    public function save($request, $response)
    {
        $upload = $request->getUploadedFile('files');

        if (!$upload || $upload->getError()) {
            throw new BadRequestException('Invalid file upload.');
        }

        if (!$contents = (string) $upload->getStream()) {
            throw new BadRequestException('Unable to read contents file.');
        }

        if (!$contents = @base64_decode($contents)) {
            throw new BadRequestException('Base64 Decode failed.');
        }

        if (!$files = @json_decode($contents, true)) {
            throw new BadRequestException('Unable to decode JSON from temporary file.');
        }

        foreach ($files as $file => $data) {

            $file = new File("@theme/$file");

            if (!$file->isFile()) {
                continue;
            }

            if ($file->putContents($data) === false) {
                throw new BadRequestException(sprintf('Unable to write file (%s).', (string) $file));
            }
        }

        return $response->withJson(['message' => 'success']);
    }
}
