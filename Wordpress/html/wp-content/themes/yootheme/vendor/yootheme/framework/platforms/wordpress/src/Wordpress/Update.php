<?php

namespace YOOtheme\Wordpress;

class Update
{
    /**
     * @var array
     */
    public $plugins = [];

    /**
     * @var array
     */
    public $themes = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        foreach (['plugin', 'theme'] as $type) {

            $types = "{$type}s";

            add_filter("site_transient_update_{$types}", function ($transient) use ($types) {

                foreach ($this->{$types} as $name => $update) {
                    $this->prepare($transient, $update);
                }

                return $transient;
            });

            add_filter("pre_set_site_transient_update_{$types}", function ($transient) use ($types) {

                foreach ($this->{$types} as $name => $update) {
                    $this->check($transient, $update);
                }

                return $transient;
            });

            add_filter("{$types}_api", function ($result, $action, $args) use ($type, $types) {
                return $action == "{$type}_information" && isset($this->{$types}[$args->slug]) ? $this->fetchData($this->{$types}[$args->slug]) : false;
            }, 10, 3);

        }
    }

    /**
     * Register plugin/theme update.
     *
     * @param string $name
     * @param string $type
     * @param string $remote
     * @param array  $options
     */
    public function register($name, $type, $remote, array $options = [])
    {
        $options = array_merge(compact('name', 'type', 'remote'), $options);

        if (!isset($options['id'])) {
            $options['id'] = $type == 'plugin' ? "$name/$name.php" : $name;
        }

        $types = "{$type}s";

        $this->{$types}[$name] = $options;

        // check expiration
        if (isset($options['expiration'])
            and $transient = get_site_transient("update_{$types}")
            and isset($transient->response[$options['id']], $transient->last_checked)
            and (time() - $transient->last_checked) > $options['expiration']
        ) {
            delete_site_transient("update_{$types}");
        }
    }

    /**
     * Prepare update data.
     *
     * @param mixed $transient
     * @param array $update
     */
    public function prepare($transient, array $update)
    {
        if (isset($transient->response[$update['id']]) && $data = (object) $transient->response[$update['id']]) {

            if (isset($update['key'])) {
                $data->package = add_query_arg(['key' => $update['key']], $data->package);
            }

            $transient->response[$update['id']] = $update['type'] == 'plugin' ? $data : (array) $data;
        }
    }

    /**
     * Check if update is available.
     *
     * @param mixed $transient
     * @param array $update
     */
    public function check($transient, array $update)
    {
        if (isset($transient->checked[$update['id']]) and $data = $this->fetchData($update) and version_compare($transient->checked[$update['id']], $data->version, '<')) {
            $transient->response[$update['id']] = $update['type'] == 'plugin' ? $data : (array) $data;
        }
    }

    /**
     * Fetches the update data from remote server.
     *
     * @param  array $update
     * @return object|bool
     */
    public function fetchData(array $update)
    {
        $remote = add_query_arg(['user-agent' => true], $update['remote']);

        if ($response = wp_remote_retrieve_body(wp_remote_get($remote)) and $data = json_decode($response)) {

            $data->slug = $update['name'];
            $data->url = isset($update['url']) ? $update['url'] : '';
            $data->sections = isset($data->sections) ? (array) $data->sections : [];
            $data->banners = isset($data->banners) ? (array) $data->banners : [];
            $data->new_version = $data->version;

            return $data;
        }

        return false;
    }
}
