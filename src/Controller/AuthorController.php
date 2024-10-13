<?php
namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="author_index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $authors = $em->getRepository(Author::class)->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/authors/new", name="author_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/authors/edit/{id}", name="author_edit")
     */
    public function edit(Request $request, Author $author, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    /**
     * @Route("/authors/delete/{id}", name="author_delete")
     */
    public function delete(Author $author, EntityManagerInterface $em): Response
    {
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('author_index');
    }
}
