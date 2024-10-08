<?php

namespace Syaritech\Notify\Entities;

/**
 *
 */
class Message
{
    /**
     * @var string
     */
    private string $receptor;
    /**
     * @var string
     */
    private string $content;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function content(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getReceptor(): string
    {
        return $this->receptor;
    }

    /**
     * @param string $number
     *
     * @return void
     */
    public function to(string $number): void
    {
        $this->receptor = $number;
    }


}