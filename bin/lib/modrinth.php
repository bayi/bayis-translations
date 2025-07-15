<?php

class Modrinth
{

  // private const BASE_URL = 'localhost:3333';
  private const BASE_URL = 'https://api.modrinth.com/v2';
  // private const BASE_URL = 'https://staging-api.modrinth.com/v2';
  private $token = null;

  public function __construct()
  {
    // Initialize Modrinth class
  }

  public function auth(string $token): void
  {
    $this->token = $token;
  }

  public function listVersions(string $projectId): array|object|null
  {
    return $this->request('GET', '/project/' . $projectId . '/version');
  }

  public function getVersion(string $versionId): array|object|null
  {
    return $this->request('GET', '/version/' . $versionId);
  }

  public function deleteVersion(string $versionId): array|object|null
  {
    return $this->request('DELETE', '/version/' . $versionId);
  }

  public function createVersion(array $versionData): array|object|null
  {
    return $this->multipartRequest('/version', $versionData);
  }

  public function search(string $query) : array|object|null
  {
    return $this->request('GET', '/search', ['query' => ['query' => $query]]);
  }

  public function getProject(string $projectId): array|object|null
  {
    return $this->request('GET', '/project/' . $projectId);
  }

  protected function multipartRequest(string $url, array $fields, ?array $headers = []): array|object|null
  {
    $ch = curl_init(self::BASE_URL . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_VERBOSE, true);
    // curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    // curl_setopt($ch, CURLOPT_HEADER, true);
    $headers[] = 'Content-Type: multipart/form-data';
    $headers[] = 'Accept: application/json';
    $headers[] = 'User-Agent: bayi/bayis-translations/1.0.0 (bayi@bayi.hu)';
    if ($this->token) {
      $headers[] = 'Authorization: Bearer ' . $this->token;
    }
    if (!empty($headers)) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    return json_decode($response);
  }

  protected function request(string $method, string $url, ?array $data = [], ?array $headers = []): array|object|null
  {
    $ch = curl_init(self::BASE_URL . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $headers[] = 'User-Agent: bayi/bayis-translations/1.0.0 (bayi@bayi.hu)';
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
