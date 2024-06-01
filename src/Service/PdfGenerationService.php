<?php

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PdfGenerationService
{
    private Client $client;

    public function __construct()
    {
    }

    /**
     * Convertit une URL en PDF en utilisant le service Gotenberg
     *
     * @param string $url L'URL à convertir en PDF
     * @return string Le contenu du PDF
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fromUrl(string $url): string
    {
        $this->client = new Client();

        $multipart = [
            [
                'name'     => 'url', // Le champ attendu par le service
                'contents' => $url
            ]
        ];

        $response = $this->client->request(
            'POST',
            $_ENV['SERVICE_URL'],
            [
                'multipart' => $multipart
            ]
        );
        // Envoie une requête POST au service Gotenberg pour convertir l'URL en PDF
        return $response->getBody()->getContents();
    }
}