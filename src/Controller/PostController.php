<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\PostType;
use App\Message\SendPlagiat;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedHttpException();
        }

        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findPaginateWithOwner(),
        ]);
    }

    #[Route('/new', name: 'post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageBusInterface $bus): Response
    {
        $user = $this->getUser();
        $post = new Post();
        $post->setOwner($user);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $bus->dispatch(new SendPlagiat($post->getId()));

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/', name: 'post_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Post $post, CommentRepository $commentRepository): Response
    {
        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedHttpException();
        }

        $comment = new Comment();
        $comment->setOwner($user);
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/show.html.twig', [
            'post' => $post,
            'comments' => $commentRepository->findBy(['post' => $post]),
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $bus->dispatch(new SendPlagiat($post->getId()));

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/remove', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }
}
