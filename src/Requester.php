<?php

namespace Naneri\Lascraper;

use Goutte\Client;

class Requester {

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @param array $fields
     * @return array
     */
    public function simpleScrape(string $url, array $fields)
    {
        $result = [];

        $crawler = $this->client->request('GET', $url);
        foreach ($fields as $field){
            if($field['type'] == 'array'){
                $result[$field['key']] = [];
                $crawler->filter($field['selector'])->each(function ($node) use ($field, &$result){
                   $result[$field['name']][] = $node->text();
                });
            }elseif ($field['key'] == 'text'){
                $result[$field['name']] = $crawler->filter($field['selector'])->text();
            }
        }

        return $result;
    }
}