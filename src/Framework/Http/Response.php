<?php 

namespace Framework\Http;

class Response
{
    private $headers = [];
    private $body;
    private $statusCode;
    private $reasonPhrase = '';

    private static $phrases = [
      200 => 'OK',
      301 => 'Moved Permanently',
      400 => 'Bad Request',
      403 => 'Forbidden',
      404 => 'Not Found',
      500 => 'Internal Server Error'
    ];

    public function __construct($body, $statusCode = 200)
    {
      $this->body = $body;
      $this->statusCode = $statusCode;
    }

    public function getBody()
    {
      return $this->body;
    }

    public function withBody($body): self
    {
      $new = clone $this;
      $new->body = $body;
      return $new;
    }

    public function getStatusCode() 
    {
      return $this->statusCode;
    }

    public function getReasonPhrase()
    {
      if(!$this->reasonPhrase && isset(self::$phrases[$this->statusCode]))
      {
        $this->reasonPhrase = self::$phrases[$this->statusCode];
      }

      return $this->reasonPhrase;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
      $new = clone $this;
      $new->statusCode = $code;
      $new->reasonPhrase = $reasonPhrase;
      return $new;
    }

    public function getHeaders()
    {
      return $this->headers;
    }

    public function hasHeader($header)
    {
      return isset($this->headers[$header]);
    }

    public function getHeader($header)
    {
      if(!$this->hasHeader($header)){
        return null;
      }

      return $this->headers[$header];
    }

    public function withHeader($header, $value)
    { 
      $new = clone $this;
      if($new->hasHeader($header)){
        unset($new->headers[$header]);
      }

      $new->headers[$header] = $value;
      return $new;
    }
}