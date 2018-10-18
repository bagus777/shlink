<?php
declare(strict_types=1);

namespace Shlinkio\Shlink\Core\Model;

final class Visitor
{
    /**
     * @var string
     */
    private $userAgent;
    /**
     * @var string
     */
    private $referer;
    /**
     * @var string|null
     */
    private $remoteAddress;

    public function __construct(string $userAgent, string $referer, ?string $remoteAddress)
    {
        $this->userAgent = $userAgent;
        $this->referer = $referer;
        $this->remoteAddress = $remoteAddress;
    }

    public static function emptyInstance(): self
    {
        return new self('', '', null);
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getReferer(): string
    {
        return $this->referer;
    }

    public function getRemoteAddress(): ?string
    {
        return $this->remoteAddress;
    }
}
