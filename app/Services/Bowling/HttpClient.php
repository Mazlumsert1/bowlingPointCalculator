<?php

namespace App\Services\Bowling;

use App\Models\Frame;
use App\Models\Result;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClient
 * @package App\Services\Bowling
 */
class HttpClient
{
    /**
     * Bowling Service Endpoint
     */
    private const ENDPOINT = 'http://13.74.31.101/api/points';

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * BowlingService constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get(): array
    {
        return $this->getContents($this->httpClient->get(self::ENDPOINT));
    }

    /**
     * @param Result $result
     * @return array
     * @throws Exception
     */
    public function post(Result $result): array
    {
        $params = [
            'token' => $result->getToken(),
            'points' => array_map(function (Frame $frame) {
                return $frame->getResult();
            }, $result->getFrames())
        ];
        return $this->getContents($this->httpClient->post(self::ENDPOINT, ['json' => $params]));
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws Exception
     */
    private function getContents(ResponseInterface $response): array
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Unexpected error from Bowling Service!');
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
