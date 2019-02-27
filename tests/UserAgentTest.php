<?php
use PHPUnit\Framework\TestCase;

class UserAgentTest extends PHPUnit\Framework\TestCase
{
    private function makeRequest($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_PORT => "8080",
          CURLOPT_URL => "localhost/{$url}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: @token",
            "cache-control: no-cache"
          ),
        ));
        
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return null;
        }
        return $response;
    }
    public function testGet() {
        
        $response = $this->makeRequest('national.json');
        $this->assertEquals(36.91, $response['average']);
    }
}
