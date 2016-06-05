<?php

/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 4/6/16
 * Time: 1:49 AM
 *
 * This class provides different services like
 * connecting to external API and calling different function to get data from there.
 */
class Service
{

    private $apiKey;
    private $url;

    public function __construct()
    {
        $this->apiKey = 'e714199dc87762ff6ca283ce1cd16017';
        $this->url = 'http://ws.audioscrobbler.com/2.0/?';

    }

    /**
     * @param $url
     * @return mixed|null
     *
     * call the Url with specific method and retrieve the data.
     */
    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($retcode == 200) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * @param $tag
     * @param int $per_page
     * @param int $page
     * @return mixed
     *
     * search server data with country
     */
    public function search($tag, $per_page = 5, $page = 1)
    {
        $args = array(
            'method' => 'geo.getTopArtists',
            'api_key' => $this->apiKey,
            'country' => $tag,
            'limit' => $per_page,
            'page' => $page,
            'format' => 'json',
            'nojsoncallback' => 1
        );
        $search = $this->url . http_build_query($args);
        $results = $this->file_get_contents_curl($search);
        return json_decode($results);
    }

    /**
     * @param $artistName
     * @param $limit
     * @return mixed
     *
     * Get top-tracks by artist.
     */
    public function getTopTracks($artistName, $limit)
    {
        $args = array(
            'method' => 'artist.getTopTracks',
            'api_key' => $this->apiKey,
            'artist' => $artistName,
            'limit' => $limit,
            'format' => 'json',
            'nojsoncallback' => 1
        );
        $search = $this->url . http_build_query($args);
        $results = $this->file_get_contents_curl($search);
        return json_decode($results);
    }

    /**
     * @param $artistName
     * @return mixed
     *
     * Get artist info by artist.
     */
    public function getInfo($artistName)
    {
        $args = array(
            'method' => 'artist.getInfo',
            'api_key' => $this->apiKey,
            'artist' => $artistName,
            'format' => 'json',
            'nojsoncallback' => 1
        );
        $search = $this->url . http_build_query($args);
        $results = $this->file_get_contents_curl($search);
        return json_decode($results);
    }


}