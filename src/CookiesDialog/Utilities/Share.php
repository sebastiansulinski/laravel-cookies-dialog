<?php

namespace SSD\CookiesDialog\Utilities;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

class Share
{
    private static array $params = [];

    /**
     * Shares constructor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Config\Repository  $config
     */
    public function __construct(private readonly Request $request, private readonly Repository $config)
    {
    }

    /**
     * Set new share.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        static::$params[$key] = $value;
    }

    /**
     * Get share.
     *
     * @param  string  $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::$params[$key] ?? $default;
    }

    /**
     * Get shares.
     *
     * @return array
     */
    public function all(): array
    {
        $config = $this->config->get('cookies-dialog');

        return array_merge([
            $config['show'] => $doesNotHave = !$this->request->hasCookie($config['name']),
            $config['third_party'] => $doesNotHave || $this->request->cookie($config['name'], false),
        ], static::$params);
    }
}
