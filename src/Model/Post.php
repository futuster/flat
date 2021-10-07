<?php

namespace App\Model;

use JetBrains\PhpStorm\Pure;

class Post
{
    #[Pure] public static function create(string $title, string $author, string $body, ?string $id = null): self
    {
        $post = new self;
        if (null !== $id) {
            $post->id = $id;
        }
        $post->title = $title;
        $post->author = $author;
        $post->body = $body;

        return $post;
    }

    public string $id;
    public string $title;
    public string $author;
    public string $body;
}
