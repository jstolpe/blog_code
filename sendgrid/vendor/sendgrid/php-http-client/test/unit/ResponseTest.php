<?php

namespace SendGrid\Test;

use SendGrid\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testConstructor()
    {
        $response = new Response();

        $this->assertAttributeEquals(200, 'statusCode', $response);
        $this->assertAttributeEquals('', 'body', $response);
        $this->assertAttributeEquals([], 'headers', $response);

        $response = new Response(201, 'test', ['Content-Encoding: gzip']);

        $this->assertAttributeEquals(201, 'statusCode', $response);
        $this->assertAttributeEquals('test', 'body', $response);
        $this->assertAttributeEquals(['Content-Encoding: gzip'], 'headers', $response);
    }

    public function testStatusCode()
    {
        $response = new Response(404);

        $this->assertEquals(404, $response->statusCode());
    }

    public function testBody()
    {
        $response = new Response(null, 'foo');

        $this->assertEquals('foo', $response->body());
    }

    public function testHeaders()
    {
        $response = new Response(null, null, ['Content-Type: text/html']);

        $this->assertEquals(['Content-Type: text/html'], $response->headers());
    }

    public function testAssociativeHeaders()
    {
        $response = new Response(null, null, ['Content-Type: text/html', 'HTTP/1.1 200 OK']);

        $this->assertEquals(['Content-Type' => 'text/html', 'Status' => 'HTTP/1.1 200 OK'], $response->headers(true));
    }
}
