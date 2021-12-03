<?php

namespace App\MessageHandler;

use App\Message\SendPlagiat;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SendPlagiatHandler implements MessageHandlerInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private PostRepository $postRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(SendPlagiat $message)
    {
        if (!$post = $this->postRepository->find($message->getPostId())) {
            return;
        }

        $key = 'xEWbsyCQf8s3JbL';

        $response = $this->client->request('POST', 'https://content-watch.ru/public/api/', [
            'body' => [
                'action' => 'CHECK_TEXT',
                'key' => $key,
                'text' => $post->getBody(),
                'test' => 0
            ],
        ]);

        $result = $response->toArray();

        if ($result['error_code'] === 0) {
            $post->setUniqueIndex($result['percent']);

            $this->entityManager->flush();
        }

    }
}
