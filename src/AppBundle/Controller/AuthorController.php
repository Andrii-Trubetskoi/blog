<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 */
class AuthorController extends Controller
{
    /**
     * Lists all authors entities.
     */
    public function indexAction(Request $request)
    {
        $q = $request->query->get('q');
        $q_date = $request->query->get('q_date');
        $birthday = null;

        if ($q_date) {
            $birthday = date_create_from_format('Y-m-d', $q_date);
        }


        $em = $this->getDoctrine()->getManager();

        if ($q && !$q_date) {
            $results = $em->getRepository(Author::class)->findBy(['firstname' => $q]);
        } elseif (!$q && $q_date) {
            $results = $em->getRepository(Author::class)->findBy(['birthday' => $birthday]);
        } elseif ($q && $q_date) {
            $results = $em->getRepository(Author::class)->findBy(['birthday' => $birthday, 'firstname' => $q]);
        } else {
            $results = [];
        }


        $authors = $em->getRepository(Author::class)->findAll();

        return $this->render('author/index.html.twig', array(
            'authors' => $authors,
            'results' => $results
        ));
    }

    /**
     * Creates a new article entity.
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

    /**
     * Finds and displays a article entity.
     */
//    public function showAction(Article $article)
//    {
//        $deleteForm = $this->createDeleteForm($article);
//
//        return $this->render('article/show.html.twig', array(
//            'article' => $article,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing article entity.
     */
//    public function editAction(Request $request, Article $article)
//    {
//        $deleteForm = $this->createDeleteForm($article);
//        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('articles_edit', array('id' => $article->getId()));
//        }
//
//        return $this->render('article/edit.html.twig', array(
//            'article' => $article,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Deletes a article entity.
     */
//    public function deleteAction(Request $request, Article $article)
//    {
//        $form = $this->createDeleteForm($article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($article);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('articles_index');
//    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createDeleteForm(Article $article)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('articles_delete', array('id' => $article->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//            ;
//    }
}
