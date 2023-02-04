<?php

/**
 * Created by PhpStorm.
 * User: PMTB
 * Date: 6/18/2018
 * Time: 4:48 PM
 */

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GptAPI extends Model
{
  private $url;
  private $key;

  public function __construct()
  {
    $this->url = getenv('GPT_SERVER_ADDRESS');
    $this->key = getenv("GPT_SERVER_AUTHORIZATION");
  }

  public function callCompletions($params)
  {
    try {
      $client = new Client();
      $url =  $this->url . '/completions';
      $headers = [
        'Authorization' => 'Bearer ' . $this->key,
        'Content-Type' => 'application/json'
      ];
      $response = $client->request('POST', $url, [
        'headers' => $headers,
        'body' => json_encode($params),
      ]);
      $data = json_decode($response->getBody()->getContents(), true);
      Log::info('GptAPI callCompletions exception', ['url' => $url, 'params' => $params, 'response' => $data]);
      return $data;
    } catch (RequestException $exception) {
      $data = json_decode($exception->getResponse()->getBody()->getContents(), true);
      Log::warning('GptAPI callCompletions exception', ['message' => $exception->getMessage(), 'url' => $url, 'params' => $params, 'data' => $data]);
      return $data;
    }
  }
}
