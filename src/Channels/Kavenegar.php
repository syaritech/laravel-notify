<?php

namespace Syaritech\Notify\Channels;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Syaritech\Notify\Exceptions\ConfigurationException;

/**
 *
 */
class Kavenegar implements AdapterInterface
{
    /**
     * @var string
     */
    private string $url;
    /**
     * @var string
     */
    private string $key;
    /**
     * @var string
     */
    private string $sender;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $url = config('notify.channels.kavenegar.gateway');
        $key = config('notify.channels.kavenegar.key');
        $sender = config('notify.channels.kavenegar.sender');

        if (!$url) {
            throw new ConfigurationException('Kavenegar gateway URI is not set');
        }
        $this->url = $url;

        if (!$key) {
            throw new ConfigurationException('Kavenegar API key is not set');
        }
        $this->key = $key;

        if (!$sender) {
            throw new ConfigurationException('Kavenegar sender is not set');
        }
        $this->sender = $sender;
    }

    /**
     * @param string $number
     * @param string $message
     *
     * @return bool
     * @throws ConnectionException
     */
    public function send(string $number, string $message): bool
    {
        return Http::asForm()->post(sprintf("%s/v1/%s/sms/send.json", $this->url, $this->key), [
            'receptor' => $number,
            'message' => $message,
            'sender' => $this->sender,
        ])->successful();

    }
}