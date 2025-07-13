<?php

class Modrinth
{

  private const BASE_URL = 'https://api.modrinth.com/v2';
  private $token = null;

  public function __construct()
  {
    // Initialize Modrinth class
  }

  public function auth(string $token): void
  {
    $this->token = $token;
  }

  public function search(string $query) : array|object|null
  {
    return $this->request('GET', '/search', ['query' => ['query' => $query]]);
  }

  public function getProject(string $projectId): array|object|null
  {
    return $this->request('GET', '/project/' . $projectId);
  }

  protected function request(string $method, string $url, ?array $data = [], ?array $headers = []): array|object|null
  {
    $ch = curl_init(self::BASE_URL . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    if ($data)
    {
      if ($method === 'GET') {
        $url .= '?' . http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . $url);
      } else {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      }
    }
    if ($this->token) {
      $headers[] = 'Authorization: Bearer ' . $this->token;
    }
    if (!empty($headers)) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if ($method === 'POST') {
      curl_setopt($ch, CURLOPT_POST, true);
    } elseif ($method === 'PUT') {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    } elseif ($method === 'DELETE') {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    return json_decode($response);
  }
}
