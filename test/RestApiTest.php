<?php
define('BASE_DIR', realpath(__DIR__));
require_once (BASE_DIR . '/../vendor/autoload.php');


class RestApiTest extends PHPUnit_Framework_TestCase
{
	protected $site_base_url = "http://localhost";
	protected $url;
	protected $client;
	
	protected function setUp()
	{
		$this->client = new GuzzleHttp\Client();
		$this->url =  $this->site_base_url . '/vagas/busca';
	}

	public function testGet_ValidInput_Texto()
	{
		$response = $this->client->request('GET', $this->url . '/texto/norte/asc', []);
		
		$this->assertEquals(200, $response->getStatusCode());

		$data = json_decode($response->getBody(), true);

		$this->assertArrayHasKey('title', $data["data"][0]);
		$this->assertArrayHasKey('description', $data["data"][0]);
		$this->assertArrayHasKey('cidade', $data["data"][0]);
		$this->assertEquals(1200, $data["data"][0]['salario']);
	}
	
	public function testGet_ValidInput_Cidade()
	{
		$response = $this->client->request('GET', $this->url . '/cidade/joinville/asc', []);
	
		$this->assertEquals(200, $response->getStatusCode());
	
		$data = json_decode($response->getBody(), true);
	
		$this->assertArrayHasKey('title', $data["data"][0]);
		$this->assertArrayHasKey('description', $data["data"][0]);
		$this->assertArrayHasKey('cidade', $data["data"][0]);
		$this->assertArrayHasKey('salario', $data["data"][0]);
		
		$this->assertEquals("Joinville", $data["data"][0]['cidade'][0]);
	}
}