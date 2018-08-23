<?php

namespace YOOtheme\Wordpress;

use YOOtheme\Util\Collection;

class Option extends Collection
{
    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(json_decode(get_option($name), true) ?: []);

        add_action('shutdown', function () use ($name) {
            if ($data = $this->json()) {
                update_option($name, $data);
            }
        });
    }
}
