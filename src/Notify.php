<?php

namespace Syaritech\Notify;

use Syaritech\Notify\Channels\AdapterInterface;
use Syaritech\Notify\Entities\Message;
use Syaritech\Notify\Exceptions\ChannelException;
use Syaritech\Notify\Exceptions\NotificationException;

/**
 *
 */
class Notify
{
    /**
     * @var array<string>
     */
    private array $channels = [];

    /**
     * @var array<string>
     */
    private array $recipients = [];

    /**
     * @var array<string|Message>
     */
    private array $messages = [];

    /**
     * @param string ...$channels
     *
     * @return $this
     * @throws ChannelException
     */
    public function via(string ...$channels): self
    {
        $this->validateChannels($channels);
        $this->channels = array_unique($channels);
        return $this;
    }

    /**
     * @param array<string> $channels
     *
     * @return void
     * @throws ChannelException
     */
    private function validateChannels(array $channels): void
    {
        if (empty($channels)) {
            throw new ChannelException('At least one channel must be specified');
        }

        if (!empty($this->channels)) {
            throw new ChannelException('Channels are already set');
        }
    }

    /**
     * @param string $number
     *
     * @return $this
     */
    public function to(string $number): self
    {
        $this->recipients[] = $number;
        return $this;
    }

    /**
     * @param string|Message $message
     *
     * @return $this
     * @throws NotificationException
     */
    public function message(string|Message $message): self
    {
        if ($message instanceof Message) {
            $this->handleMessageObject($message);
        } else {
            $this->messages[] = $message;
        }
        return $this;
    }

    /**
     * @param Message $message
     *
     * @return void
     * @throws NotificationException
     */
    private function handleMessageObject(Message $message): void
    {
        if (!empty($this->recipients)) {
            throw new NotificationException('You cannot use the "to" method with a message object');
        }
        $this->recipients[] = $message->getReceptor();
        $this->messages[] = $message->getContent();
    }

    /**
     * @return bool
     * @throws ChannelException
     */
    public function send(): bool
    {
        $response = false;
        foreach ($this->channels as $channel) {
            $channelInstance = $this->getFreshInstanceOfChannel($channel);
            if (!empty($this->recipients)) {
                foreach ($this->recipients as $recipient) {
                    $response = $channelInstance->send($recipient, $this->messages[0]);
                }
            } else {
                if (!empty($this->messages)) {
                    foreach ($this->messages as $message) {
                        $response = $channelInstance->send($message->getReceptor(), $message->getContent());
                    }
                }
            }
        }

        return $response;
    }

    /**
     * @param string $channel
     *
     * @return AdapterInterface
     * @throws ChannelException
     */
    private function getFreshInstanceOfChannel(string $channel): AdapterInterface
    {
        $class = config(sprintf('notify.channels.%s.class', $channel));
        if (!$class) {
            throw new ChannelException(sprintf('Channel class not found for %s', $channel));
        }
        return new $class;
    }
}