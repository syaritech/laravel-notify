<?php

namespace Syaritech\Notify\Channels;

/**
 *
 */
interface AdapterInterface
{
    /**
     * @param string $number
     * @param string $message
     *
     * @return bool
     */
    public function send(string $number, string $message): bool;
}