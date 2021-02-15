<?php

namespace SendGrid\Test;

use PHPUnit\Framework\TestCase;
use SendGrid\Client;
use SendGrid\Exception\InvalidRequest;

class ClientTest extends TestCase
{
    /** @var MockClient */
    private $client;
    /** @var string */
    private $host;
    /** @var array */
    private $headers;

    protected function setUp()
    {
        $this->host = 'https://localhost:4010';
        $this->headers = [
            'Content-Type: application/json',
            'Authorization: Bearer SG.XXXX'
        ];
        $this->client = new MockClient($this->host, $this->headers, '/v3');
    }

    public function testConstructor()
    {
        $this->assertAttributeEquals($this->host, 'host', $this->client);
        $this->assertAttributeEquals($this->headers, 'headers', $this->client);
        $this->assertAttributeEquals('/v3', 'version', $this->client);
        $this->assertAttributeEquals([], 'path', $this->client);
        $this->assertAttributeEquals([], 'curlOptions', $this->client);
        $this->assertAttributeEquals(false, 'retryOnLimit', $this->client);
        $this->assertAttributeEquals(['get', 'post', 'patch', 'put', 'delete'], 'methods', $this->client);
    }

    public function test_()
    {
        $client = new MockClient($this->host, $this->headers, '/v3');
        $client->setCurlOptions(['foo' => 'bar']);
        $client = $client->_('test');

        $this->assertAttributeEquals(['test'], 'path', $client);
        $this->assertAttributeEquals(['foo' => 'bar'], 'curlOptions', $client);
    }

    public function test__call()
    {
        $client = $this->client->get();
        $this->assertAttributeEquals('https://localhost:4010/v3/', 'url', $client);

        $queryParams = ['limit' => 100, 'offset' => 0];
        $client = $this->client->get(null, $queryParams);
        $this->assertAttributeEquals('https://localhost:4010/v3/?limit=100&offset=0', 'url', $client);

        $requestBody = ['name' => 'A New Hope'];
        $client = $this->client->get($requestBody);
        $this->assertAttributeEquals($requestBody, 'requestBody', $client);

        $requestHeaders = ['X-Mock: 200'];
        $client = $this->client->get(null, null, $requestHeaders);
        $this->assertAttributeEquals($requestHeaders, 'requestHeaders', $client);

        $client = $this->client->version('/v4');
        $this->assertAttributeEquals('/v4', 'version', $client);

        $client = $this->client->path_to_endpoint();
        $this->assertAttributeEquals(['path_to_endpoint'], 'path', $client);
        $client = $client->one_more_segment();
        $this->assertAttributeEquals(['path_to_endpoint', 'one_more_segment'], 'path', $client);
    }

    public function testGetHost()
    {
        $client = new Client('https://localhost:4010');
        $this->assertSame('https://localhost:4010', $client->getHost());
    }

    public function testGetHeaders()
    {
        $client = new Client(
            'https://localhost:4010',
            ['Content-Type: application/json', 'Authorization: Bearer SG.XXXX']
        );
        $this->assertSame(['Content-Type: application/json', 'Authorization: Bearer SG.XXXX'], $client->getHeaders());

        $client2 = new Client('https://localhost:4010');
        $this->assertSame([], $client2->getHeaders());
    }

    public function testGetVersion()
    {
        $client = new Client('https://localhost:4010', [], '/v3');
        $this->assertSame('/v3', $client->getVersion());

        $client = new Client('https://localhost:4010');
        $this->assertNull($client->getVersion());
    }

    public function testGetPath()
    {
        $client = new Client('https://localhost:4010', [], null, ['/foo/bar']);
        $this->assertSame(['/foo/bar'], $client->getPath());

        $client = new Client('https://localhost:4010');
        $this->assertSame([], $client->getPath());
    }

    public function testGetCurlOptions()
    {
        $client = new Client('https://localhost:4010');
        $client->setCurlOptions([CURLOPT_PROXY => '127.0.0.1:8080']);
        $this->assertSame([CURLOPT_PROXY => '127.0.0.1:8080'], $client->getCurlOptions());

        $client = new Client('https://localhost:4010');
        $this->assertSame([], $client->getCurlOptions());
    }

    public function testCurlMulti()
    {
        $client = new Client('https://localhost:4010');
        $client->setIsConcurrentRequest(true);
        $client->get(['name' => 'A New Hope']);
        $client->get(null, null, ['X-Mock: 200']);
        $client->get(null, ['limit' => 100, 'offset' => 0]);

        // returns 3 response object
        $this->assertCount(3, $client->send());
    }

    public function testCreateCurlOptionsWithMethodOnly()
    {
        $client = new Client('https://localhost:4010');

        $result = $this->callMethod($client, 'createCurlOptions', ['get']);

        $this->assertEquals([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FAILONERROR => false,
            CURLOPT_HTTPHEADER => []
        ], $result);
    }

    public function testCreateCurlOptionsWithBody()
    {
        $client = new Client('https://localhost:4010', ['User-Agent: Custom-Client 1.0']);
        $client->setCurlOptions([
            CURLOPT_ENCODING => 'utf-8'
        ]);

        $body = ['foo' => 'bar'];

        $result = $this->callMethod($client, 'createCurlOptions', ['post', $body]);

        $this->assertEquals([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FAILONERROR => false,
            CURLOPT_ENCODING => 'utf-8',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                'User-Agent: Custom-Client 1.0',
                'Content-Type: application/json'
            ]
        ], $result);
    }

    public function testCreateCurlOptionsWithBodyAndHeaders()
    {
        $client = new Client('https://localhost:4010', ['User-Agent: Custom-Client 1.0']);
        $client->setCurlOptions([
            CURLOPT_ENCODING => 'utf-8'
        ]);

        $body = ['foo' => 'bar'];
        $headers = ['Accept-Encoding: gzip'];

        $result = $this->callMethod($client, 'createCurlOptions', ['post', $body, $headers]);

        $this->assertEquals([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FAILONERROR => false,
            CURLOPT_ENCODING => 'utf-8',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                'User-Agent: Custom-Client 1.0',
                'Accept-Encoding: gzip',
                'Content-Type: application/json'
            ]
        ], $result);
    }


    public function testThrowExceptionOnInvalidCall()
    {
        $this->expectException(InvalidRequest::class);

        $client = new Client('invalid://url', ['User-Agent: Custom-Client 1.0']);
        $client->get();
    }

    public function testMakeRequestWithUntrustedRootCert()
    {
        $this->expectException(InvalidRequest::class);
        $this->expectExceptionMessageRegExp('/certificate/i');

        $client = new Client('https://untrusted-root.badssl.com/');
        $client->makeRequest('GET', 'https://untrusted-root.badssl.com/');
    }

    /**
     * @param object $obj
     * @param string $name
     * @param array $args
     * @return mixed
     */
    private function callMethod($obj, $name, $args = [])
    {
        try {
            $class = new \ReflectionClass($obj);
        } catch (\ReflectionException $e) {
            return null;
        }
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
