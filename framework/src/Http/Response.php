<?php

namespace Mohin\Framework\Http;

readonly class Response
{
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public function __construct(private ?string $content = null, private int $status = 200, private array $headers = [])
    {
    }

    public function send(): void
    {
        echo $this->content;
//        dd($this->content, $this->status, $this->headers);

    }
}