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
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/show/{name}', name: 'show_author')]
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/author/list', name: 'list_authors')]
    public function listAuthors(EntityManagerInterface $entityManager): Response
    {
      
        $authors = $entityManager->getRepository(Author::class)->findAll();

        if (empty($authors)) {
            return $this->render('author/list.html.twig', [
                'authors' => null,
            ]);
        }

        // Optionally, if you have a 'nb_books' field in your Author entity
        // $totalBooks = array_sum(array_column($authors, 'nb_books')); // Si nécessaire

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
            // 'totalBooks' => $totalBooks,
        ]);
    }

    #[Route('/author/add', name: 'add_author')]
    public function addAuthor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('list_authors'); // Redirige vers la liste des auteurs
        }

        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/author/edit/{id}', name: 'edit_author')]
public function editAuthor(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    // Retrieve the author by ID
    $author = $entityManager->getRepository(Author::class)->find($id);

    // Check if the author exists
    if (!$author) {
        throw $this->createNotFoundException('Aucun auteur trouvé pour cet identifiant '.$id);
    }

    // Create the form for editing the author
    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush(); // Update the author in the database

        return $this->redirectToRoute('list_authors'); // Redirect to the authors list
    }

    return $this->render('author/edit.html.twig', [
        'form' => $form->createView(),
        'author' => $author,
    ]);
}
#[Route('/author/delete/{id}', name: 'delete_author')]
public function deleteAuthor(int $id, EntityManagerInterface $entityManager): Response
{
    // Retrieve the author by ID
    $author = $entityManager->getRepository(Author::class)->find($id);

    // Check if the author exists
    if (!$author) {
        throw $this->createNotFoundException('Aucun auteur trouvé pour cet identifiant '.$id);
    }

    $entityManager->remove($author); // Remove the author from the database
    $entityManager->flush(); // Apply the changes

    return $this->redirectToRoute('list_authors'); // Redirect to the authors list
}

}
