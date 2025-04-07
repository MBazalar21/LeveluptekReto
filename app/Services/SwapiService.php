<?php
namespace App\Services;

use App\Exceptions\MessageNotFoundException;
use Illuminate\Support\Facades\Http;

class SwapiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://swapi.dev/api/';
    }

    public function  getPeople($id)
    {
        $response = Http::get($this->baseUrl . "people/{$id}");
        if ($response->failed()) {
            throw new MessageNotFoundException('Personaje');
        }
        return $response->json();
    }

    public function getSwapiByUrl($url){
        $response = Http::get($url);
        return $response->json();
    }
}