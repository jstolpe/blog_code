<?php

/**
 * HTTP Client library
 */

namespace SendGrid;

use SendGrid\Exception\InvalidRequest;

/**
 * Class Client
 * @version 3.9.5
 *
 * Quickly and easily access any REST or REST-like API.
 *
 * @method Response get($body = null, $query = null, $headers = null, $retryOnLimit = null)
 * @method Response post($body = null, $query = null, $headers = null, $retryOnLimit = null)
 * @method Response patch($body = null, $query = null, $headers = null, $retryOnLimit = null)
 * @method Response put($body = null, $query = null, $headers = null, $retryOnLimit = null)
 * @method Response delete($body = null, $query = null, $headers = null, $retryOnLimit = null)
 *
 * @method Client version($value)
 * @method Client|Response send()
 *
 * Adding all the endpoints as a method so code completion works
 *
 * General
 * @method Client stats()
 * @method Client search()
 * @method Client monthly()
 * @method Client sums()
 * @method Client monitor()
 * @method Client test()
 *
 * Access settings
 * @method Client access_settings()
 * @method Client activity()
 * @method Client whitelist()
 *
 * Alerts
 * @method Client alerts()
 *
 * Api keys
 * @method Client api_keys()
 *
 * ASM
 * @method Client asm()
 * @method Client groups()
 * @method Client suppressions()
 *
 * Browsers
 * @method Client browsers()
 *
 * Campaigns
 * @method Client campaigns()
 * @method Client schedules()
 * @method Client now()
 *
 * Categories
 * @method Client categories()
 *
 * Clients
 * @method Client clients()
 *
 * Marketing
 * @method Client marketing()
 * @method Client contacts()
 * @method Client count()
 * @method Client exports()
 * @method Client imports()
 * @method Client lists()
 * @method Client field_definitions()
 * @method Client segments()
 * @method Client singlesends()
 *
 * Devices
 * @method Client devices()
 *
 * Geo
 * @method Client geo()
 *
 * Ips
 * @method Client ips()
 * @method Client assigned()
 * @method Client pools()
 * @method Client warmup()
 *
 * Mail
 * @method Client mail()
 * @method Client batch()
 *
 * Mailbox Providers
 * @method Client mailbox_providers()
 *
 * Mail settings
 * @method Client mail_settings()
 * @method Client address_whitelist()
 * @method Client bcc()
 * @method Client bounce_purge()
 * @method Client footer()
 * @method Client forward_bounce()
 * @method Client forward_spam()
 * @method Client plain_content()
 * @method Client spam_check()
 * @method Client template()
 *
 * Partner settings
 * @method Client partner_settings()
 * @method Client new_relic()
 *
 * Scopes
 * @method Client scopes()
 *
 * Senders
 * @method Client senders()
 * @method Client resend_verification()
 *
 * Sub Users
 * @method Client subusers()
 * @method Client reputations()
 *
 * Suppressions
 * @method Client suppression()
 * @method Client global()
 * @method Client blocks()
 * @method Client bounces()
 * @method Client invalid_emails()
 * @method Client spam_reports()
 * @method Client unsubscribes()
 *
 * Templates
 * @method Client templates()
 * @method Client versions()
 * @method Client activate()
 *
 * Tracking settings
 * @method Client tracking_settings()
 * @method Client click()
 * @method Client google_analytics()
 * @method Client open()
 * @method Client subscription()
 *
 * User
 * @method Client user()
 * @method Client account()
 * @method Client credits()
 * @method Client email()
 * @method Client password()
 * @method Client profile()
 * @method Client scheduled_sends()
 * @method Client enforced_tls()
 * @method Client settings()
 * @method Client username()
 * @method Client webhooks()
 * @method Client event()
 * @method Client parse()
 *
 * Missed any? Simply add them by doing: @method Client method()
 */
class Client
{
    const TOO_MANY_REQUESTS_HTTP_CODE = 429;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var array
     */
    protected $path;

    /**
     * @var array
     */
    protected $curlOptions;

    /**
     * @var bool
     */
    protected $isConcurrentRequest;

    /**
     * @var array
     */
    protected $savedRequests;

    /**
     * @var bool
     */
    protected $verifySSLCerts;
    
    /**
     * @var bool
     */
    protected $retryOnLimit;

    /**
     * Supported HTTP verbs.
     *
     * @var array
     */
    private $methods = ['get', 'post', 'patch', 'put', 'delete'];

    /**
     * Initialize the client.
     *
     * @param string $host           the base url (e.g. https://api.sendgrid.com)
     * @param array  $headers        global request headers
     * @param string $version        api version (configurable) - this is specific to the SendGrid API
     * @param array  $path           holds the segments of the url path
     * @param array  $curlOptions    extra options to set during curl initialization
     * @param bool   $retryOnLimit   set default retry on limit flag
     * @param bool   $verifySSLCerts set default verify certificates flag
     */
    public function __construct(
        $host,
        $headers = null,
        $version = null,
        $path = null,
        $curlOptions = null,
        $retryOnLimit = false,
        $verifySSLCerts = true
    ) {
        $this->host = $host;
        $this->headers = $headers ?: [];
        $this->version = $version;
        $this->path = $path ?: [];
        $this->curlOptions = $curlOptions ?: [];
        $this->retryOnLimit = $retryOnLimit;
        $this->verifySSLCerts = $verifySSLCerts;
        $this->isConcurrentRequest = false;
        $this->savedRequests = [];
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
     * Set extra options to set during curl initialization.
     *
     * @param array $options
     *
     * @return Client
     */
    public function setCurlOptions(array $options)
    {
        $this->curlOptions = $options;

        return $this;
    }

    /**
     * Set default retry on limit flag.
     *
     * @param bool $retry
     *
     * @return Client
     */
    public function setRetryOnLimit($retry)
    {
        $this->retryOnLimit = $retry;

        return $this;
    }

    /**
     * Set default verify certificates flag
     *
     * @param bool $verifySSLCerts
     *
     * @return Client
     */
    public function setVerifySSLCerts($verifySSLCerts)
    {
        $this->verifySSLCerts = $verifySSLCerts;

        return $this;
    }

    /**
     * Set concurrent request flag
     *
     * @param bool $isConcurrent
     *
     * @return Client
     */
    public function setIsConcurrentRequest($isConcurrent)
    {
        $this->isConcurrentRequest = $isConcurrent;

        return $this;
    }

    /**
     * Build the final URL to be passed.
     *
     * @param array $queryParams an array of all the query parameters
     *
     * @return string
     */
    private function buildUrl($queryParams = null)
    {
        $path = '/' . implode('/', $this->path);
        if (isset($queryParams)) {
            $path .= '?' . http_build_query($queryParams);
        }

        return sprintf('%s%s%s', $this->host, $this->version ?: '', $path);
    }

    /**
     * Creates curl options for a request
     * this function does not mutate any private variables.
     *
     * @param string $method
     * @param array  $body
     * @param array  $headers
     *
     * @return array
     */
    private function createCurlOptions($method, $body = null, $headers = null)
    {
        $options = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_CUSTOMREQUEST => strtoupper($method),
                CURLOPT_SSL_VERIFYPEER => $this->verifySSLCerts,
                CURLOPT_FAILONERROR => false,
            ] + $this->curlOptions;

        if (isset($headers)) {
            $headers = array_merge($this->headers, $headers);
        } else {
            $headers = $this->headers;
        }

        if (isset($body)) {
            $encodedBody = json_encode($body);
            $options[CURLOPT_POSTFIELDS] = $encodedBody;
            $headers = array_merge($headers, ['Content-Type: application/json']);
        }
        $options[CURLOPT_HTTPHEADER] = $headers;

        if (class_exists('\\Composer\\CaBundle\\CaBundle') && method_exists('\\Composer\\CaBundle\\CaBundle', 'getSystemCaRootBundlePath')) {
            $caPathOrFile = \Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
            if (is_dir($caPathOrFile) || (is_link($caPathOrFile) && is_dir(readlink($caPathOrFile)))) {
                $options[CURLOPT_CAPATH] = $caPathOrFile;
            } else {
                $options[CURLOPT_CAINFO] = $caPathOrFile;
            }
        }

        return $options;
    }

    /**
     * @param array $requestData  (method, url, body and headers)
     * @param bool  $retryOnLimit
     *
     * @return array
     */
    private function createSavedRequest(array $requestData, $retryOnLimit = false)
    {
        return array_merge($requestData, ['retryOnLimit' => $retryOnLimit]);
    }

    /**
     * @param array $requests
     *
     * @return array
     */
    private function createCurlMultiHandle(array $requests)
    {
        $channels = [];
        $multiHandle = curl_multi_init();

        foreach ($requests as $id => $data) {
            $channels[$id] = curl_init($data['url']);
            $curlOpts = $this->createCurlOptions($data['method'], $data['body'], $data['headers']);
            curl_setopt_array($channels[$id], $curlOpts);
            curl_multi_add_handle($multiHandle, $channels[$id]);
        }

        return [$channels, $multiHandle];
    }

    /**
     * Prepare response object.
     *
     * @param resource $channel the curl resource
     * @param string   $content
     *
     * @return Response object
     */
    private function parseResponse($channel, $content)
    {
        $headerSize = curl_getinfo($channel, CURLINFO_HEADER_SIZE);
        $statusCode = curl_getinfo($channel, CURLINFO_HTTP_CODE);

        $responseBody = mb_substr($content, $headerSize);

        $responseHeaders = mb_substr($content, 0, $headerSize);
        $responseHeaders = explode("\n", $responseHeaders);
        $responseHeaders = array_map('trim', $responseHeaders);

        return new Response($statusCode, $responseBody, $responseHeaders);
    }

    /**
     * Retry request.
     *
     * @param array  $responseHeaders headers from rate limited response
     * @param string $method          the HTTP verb
     * @param string $url             the final url to call
     * @param array  $body            request body
     * @param array  $headers         original headers
     *
     * @return Response response object
     *
     * @throws InvalidRequest
     */
    private function retryRequest(array $responseHeaders, $method, $url, $body, $headers)
    {
        $sleepDurations = $responseHeaders['X-Ratelimit-Reset'] - time();
        sleep($sleepDurations > 0 ? $sleepDurations : 0);

        return $this->makeRequest($method, $url, $body, $headers, false);
    }

    /**
     * Make the API call and return the response.
     * This is separated into it's own function, so we can mock it easily for testing.
     *
     * @param string $method       the HTTP verb
     * @param string $url          the final url to call
     * @param array  $body         request body
     * @param array  $headers      any additional request headers
     * @param bool   $retryOnLimit should retry if rate limit is reach?
     *
     * @return Response object
     *
     * @throws InvalidRequest
     */
    public function makeRequest($method, $url, $body = null, $headers = null, $retryOnLimit = false)
    {
        $channel = curl_init($url);

        $options = $this->createCurlOptions($method, $body, $headers);

        curl_setopt_array($channel, $options);
        $content = curl_exec($channel);

        if ($content === false) {
            throw new InvalidRequest(curl_error($channel), curl_errno($channel));
        }

        $response = $this->parseResponse($channel, $content);

        if ($retryOnLimit && $response->statusCode() === self::TOO_MANY_REQUESTS_HTTP_CODE) {
            $responseHeaders = $response->headers(true);

            return $this->retryRequest($responseHeaders, $method, $url, $body, $headers);
        }

        curl_close($channel);

        return $response;
    }

    /**
     * Send all saved requests at once.
     *
     * @param array $requests
     *
     * @return Response[]
     *
     * @throws InvalidRequest
     */
    public function makeAllRequests(array $requests = [])
    {
        if (empty($requests)) {
            $requests = $this->savedRequests;
        }
        list($channels, $multiHandle) = $this->createCurlMultiHandle($requests);

        // running all requests
        $isRunning = null;
        do {
            curl_multi_exec($multiHandle, $isRunning);
        } while ($isRunning);

        // get response and close all handles
        $retryRequests = [];
        $responses = [];
        $sleepDurations = 0;
        foreach ($channels as $id => $channel) {
            $content = curl_multi_getcontent($channel);

            if ($content === false) {
                throw new InvalidRequest(curl_error($channel), curl_errno($channel));
            }

            $response = $this->parseResponse($channel, $content);

            if ($requests[$id]['retryOnLimit'] && $response->statusCode() === self::TOO_MANY_REQUESTS_HTTP_CODE) {
                $headers = $response->headers(true);
                $sleepDurations = max($sleepDurations, $headers['X-Ratelimit-Reset'] - time());
                $requestData = [
                    'method' => $requests[$id]['method'],
                    'url' => $requests[$id]['url'],
                    'body' => $requests[$id]['body'],
                    'headers' => $headers,
                ];
                $retryRequests[] = $this->createSavedRequest($requestData, false);
            } else {
                $responses[] = $response;
            }

            curl_multi_remove_handle($multiHandle, $channel);
        }
        curl_multi_close($multiHandle);

        // retry requests
        if (!empty($retryRequests)) {
            sleep($sleepDurations > 0 ? $sleepDurations : 0);
            $responses = array_merge($responses, $this->makeAllRequests($retryRequests));
        }

        return $responses;
    }

    /**
     * Add variable values to the url. (e.g. /your/api/{variable_value}/call)
     * Another example: if you have a PHP reserved word, such as and, in your url, you must use this method.
     *
     * @param string $name name of the url segment
     *
     * @return Client object
     */
    public function _($name = null)
    {
        if (isset($name)) {
            $this->path[] = $name;
        }
        $client = new static($this->host, $this->headers, $this->version, $this->path);
        $client->setCurlOptions($this->curlOptions);
        $client->setVerifySSLCerts($this->verifySSLCerts);
        $client->setRetryOnLimit($this->retryOnLimit);
        $this->path = [];

        return $client;
    }

    /**
     * Dynamically add method calls to the url, then call a method.
     * (e.g. client.name.name.method()).
     *
     * @param string $name name of the dynamic method call or HTTP verb
     * @param array  $args parameters passed with the method call
     *
     * @return Client|Response|Response[]|null object
     *
     * @throws InvalidRequest
     */
    public function __call($name, $args)
    {
        $name = mb_strtolower($name);

        if ($name === 'version') {
            $this->version = $args[0];

            return $this->_();
        }

        // send all saved requests
        if (($name === 'send') && $this->isConcurrentRequest) {
            return $this->makeAllRequests();
        }

        if (\in_array($name, $this->methods, true)) {
            $body = isset($args[0]) ? $args[0] : null;
            $queryParams = isset($args[1]) ? $args[1] : null;
            $url = $this->buildUrl($queryParams);
            $headers = isset($args[2]) ? $args[2] : null;
            $retryOnLimit = isset($args[3]) ? $args[3] : $this->retryOnLimit;

            if ($this->isConcurrentRequest) {
                // save request to be sent later
                $requestData = ['method' => $name, 'url' => $url, 'body' => $body, 'headers' => $headers];
                $this->savedRequests[] = $this->createSavedRequest($requestData, $retryOnLimit);

                return null;
            }

            return $this->makeRequest($name, $url, $body, $headers, $retryOnLimit);
        }

        return $this->_($name);
    }
}
