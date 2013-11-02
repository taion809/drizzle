<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 12:08 PM
 */

namespace Johnsn\Drizzle\Providers;

class Container extends AbstractProvider
{
    public function __construct($client)
    {
        parent::__construct($client);
    }

    /**
     * List containers
     *
     * @param int $all
     * @param $limit
     * @param string $since
     * @param string $before
     * @param int $size
     * @return mixed
     */
    public function containers($all = 0, $limit = -1, $since = '', $before = '', $size = 1)
    {
        $uri = "containers/json";

        $query = array(
            "all" => $all,
            "limit" => $limit,
            "since" => $since,
            "before" => $before,
            "size" => $size
        );

        $data = $this->client->build($uri, $query)->sendRequest();

        return $data;
    }

    /**
     * Inspect container by container id
     *
     * @param $id
     * @return mixed
     */
    public function inspect($id)
    {
        $uri = "containers/{$id}/json";

        $data = $this->client->build($uri)->sendRequest();

        return $data;
    }

    /**
     * List processes running in the container by container id
     *
     * @param $id
     * @param null $args
     * @return mixed
     */
    public function top($id, $args = null)
    {
        $uri = "containers/{$id}/top";

        $query = array(
            'ps_args' => $args,
        );

        $data = $this->client->build($uri, $query)->sendRequest();

        return $data;
    }

    /**
     * List a container's filesystem changes by container id
     *
     * @param $id
     * @return mixed
     */
    public function changes($id)
    {
        $uri = "containers/{$id}/changes";

        $data = $this->client->build($uri)->sendRequest();

        return $data;
    }

    /**
     * Export container by container id
     * @param $id
     * @return mixed
     */
    public function export($id)
    {
        /**
        $uri = "containers/{$id}/export";

        $data = $this->client->build($uri)->sendRequest();

        return $data;
        */

        return "Not yet implemented";
    }

    /**
     * Start a container
     *
     * @param $id
     * @param array $config
     * @return mixed
     */
    public function start($id, array $config = array())
    {
        $uri = "containers/{$id}/start";

        $data = $this->client->buildJson($uri, $config)->sendRequest();

        return $data;
    }

    /**
     * Stop a container
     *
     * @param $id
     * @param int $timeout
     * @return mixed
     */
    public function stop($id, $timeout = 0)
    {
        $uri = "containers/{$id}/stop";

        if($timeout) {
            $uri .= "?t={$timeout}";
        }

        $data = $this->client->buildJson($uri)->sendRequest();

        return $data;
    }

    /**
     * Restart a container
     *
     * @param $id
     * @param int $timeout
     * @return mixed
     */
    public function restart($id, $timeout = 0)
    {
        $uri = "containers/{$id}/restart";

        if($timeout) {
            $uri .= "?t={$timeout}";
        }

        $data = $this->client->buildJson($uri)->sendRequest();

        return $data;
    }

    /**
     * Kill a container
     *
     * @param $id
     * @param int $signal
     * @return mixed
     */
    public function kill($id, $signal = 0)
    {
        $uri = "containers/{$id}/kill";

        if($signal) {
            $uri .= "?signal={$signal}";
        }

        $data = $this->client->buildJson($uri)->sendRequest();

        return $data;
    }

    /**
     * Attach to a container
     *
     * @return string
     */
    public function attach()
    {
        return "Not yet implemented";
    }

    /**
     * Block until container stops
     *
     * @param $id
     * @return mixed
     */
    public function wait($id)
    {
        $uri = "containers/{$id}/wait";

        $data = $this->client->buildJson($uri)->sendRequest();

        return $data;
    }

    /**
     * Remove a container by container id
     *
     * @param $id
     * @param int $volume
     * @return string
     */
    public function remove($id, $volume = 0)
    {
        return "Not yet implemented.";
    }

    /**
     * Copy files or folders from a container by container id
     *
     * @param $id
     * @return string
     */
    public function copy($id)
    {
        return "Not yet implemented";
    }

    /**
     * Create a container from an image
     *
     * @param string $image
     * @param array $config
     * @return mixed
     */
    public function create($image = 'base', array $config = array())
    {
        $containerConfig = array(
             "Image" => $image,
        );

        if(!empty($config)) {
            $containerConfig = array_merge($containerConfig, $config);
        }

        $data = $this->client->buildJson("containers/create", $containerConfig)->sendRequest();

        return $data;
    }


}
