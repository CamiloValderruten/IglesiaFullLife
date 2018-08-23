<?php

namespace YOOtheme\Wordpress;

class UrlGenerator extends \YOOtheme\UrlGenerator
{
    /**
     * {@inheritdoc}
     */
    public function route($pattern = '', array $parameters = [], $secure = null)
    {
        if ($pattern !== '') {

            $search = [];

            foreach ($parameters as $key => $value) {
                $search[] = '#:' . preg_quote($key, '#') . '(?!\w)#';
            }

            $pattern = preg_replace($search, $parameters, $pattern);
            $pattern = preg_replace('#\(/?:.+\)|\(|\)|\\\\#', '', $pattern);

            $parameters = array_merge(['p' => $pattern], $parameters);
        }

        return $this->to('wp-admin/admin-ajax.php?action=kernel', $parameters, $secure);
    }
}
