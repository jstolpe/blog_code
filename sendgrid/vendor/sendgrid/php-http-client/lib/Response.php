<?php

/**
 * HTTP Client library
 */

namespace SendGrid;

/**
 * Holds the response from an API call.
 */
class Response
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers;

    /**
     * Setup the response data.
     *
     * @param int    $statusCode the status code
     * @param string $body       the response body
     * @param array  $headers    an array of response headers
     */
    public function __construct($statusCode = 200, $body = '', array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * The status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * The response body.
     *
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * The response headers.
     *
     * @param bool $assoc
     *
     * @return array
     */
    public function headers($assoc = false)
    {
        if (!$assoc) {
            return $this->headers;
        }

        return $this->prettifyHeaders($this->headers);
    }

    /**
     * Returns response headers as associative array.
     *
     * @param array $headers
     *
     * @return array
     */
    private function prettifyHeaders(array $headers)
    {
        return array_reduce(
            array_filter($headers),
            static function ($result, $header) {
                if (mb_strpos($header, ':') === false) {
                    $result['Status'] = trim($header);

                    return $result;
                }

                list($key, $value) = explode(':', $header, 2);
                $result[trim($key)] = trim($value);

                return $result;
            },
            []
        );
    }
}
