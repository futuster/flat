<?php

namespace App\Message;

final class SendPlagiat
{
    public function __construct(
        private string $postId
    ) {
    }

    public function getPostId(): string
    {
        return $this->postId;
    }
}
