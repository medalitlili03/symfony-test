<?php
namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="book_index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $books = $em->getRepository(Book::class)->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    // Méthodes pour ajouter, éditer et supprimer des livres similaires à celles de AuthorController...
}
