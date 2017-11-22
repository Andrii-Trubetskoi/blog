<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Author controller.
 *
 */
class AuthorController extends Controller
{
    /**
     * Lists all authors entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('AppBundle:Author')->findAuthorByName($request);
        $authors = $em->getRepository(Author::class)->findAll();

        return $this->render('author/index.html.twig', array(
            'authors' => $authors,
            'results' => $results
        ));
    }

    /**
     * Creates a new Author entity.
     */
    public function newAction(Request $request)
    {
        $author = new Author();
        $form = $this->createFormBuilder($author)
            ->add('firstname')
            ->add('surname')
            ->add('birthday')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('autors_new');
        }

        return $this->render('author/new.html.twig', array(
            'author' => $author,
            'form' => $form->createView(),
        ));
    }
}
