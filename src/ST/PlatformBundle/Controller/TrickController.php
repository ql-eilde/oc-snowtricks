<?php

namespace ST\PlatformBundle\Controller;

use ST\PlatformBundle\Entity\Comment;
use ST\PlatformBundle\Entity\Trick;
use ST\PlatformBundle\Form\CommentType;
use ST\PlatformBundle\Form\TrickType;
use ST\PlatformBundle\Form\TrickEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TrickController extends Controller
{
    public function indexAction(){

        $listTricks = $this->getDoctrine()->getManager()->getRepository('STPlatformBundle:Trick')->findAll();

        return $this->render('STPlatformBundle:Trick:index.html.twig', array('listTricks' => $listTricks));
    }

    public function viewAction(Request $request, $id, $slug){
        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository('STPlatformBundle:Trick')->find($id);

        $repo = $em->getRepository('STPlatformBundle:Comment');
        $comments = $repo->getListComments($trick);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            10
        );

        $listImages = $em->getRepository('STPlatformBundle:Image')->findBy(array('trick' => $trick));
        $listVideos = $em->getRepository('STPlatformBundle:Video')->findBy(array('trick' => $trick));

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if($request->isMethod('POST') && $comment->setTrick($trick) && $comment->setUser($this->getUser()) && $form->handleRequest($request)->isValid()){
            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Votre commentaire a bien été ajouté.');

            return $this->redirectToRoute('st_platform_view', array(
                'id' => $id,
                'slug' => $slug,
            ));
        }

        return $this->render('STPlatformBundle:Trick:view.html.twig', array(
            'trick' => $trick,
            'listImages' => $listImages,
            'listVideos' => $listVideos,
            'pagination' => $pagination,
            'form' => $form->createView(),
            ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request){
        $trick = new Trick();
        $user = $this->getUser();
        $trick->setUser($user);
        $form = $this->createForm(TrickType::class, $trick);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Votre nouveau trick a bien été enregistré');

            return $this->redirectToRoute('st_platform_homepage');
        }

        return $this->render('STPlatformBundle:Trick:add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, $id, $slug){
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('STPlatformBundle:Trick')->find($id);

        $repo = $em->getRepository('STPlatformBundle:Image');

        if(!$trick){
            throw $this->createNotFoundException("Pas de trick trouvé avec l'id".$id);
        }

        $form = $this->createForm(TrickEditType::class, $trick);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->flush();
            $repo->removeImagesWithoutName($trick);

            $request->getSession()->getFlashBag()->add('info', 'Votre trick a bien été modifié.');

            return $this->redirectToRoute('st_platform_view', array('id' => $id, 'slug' => $slug));
        }

        return $this->render('STPlatformBundle:Trick:edit.html.twig', array('form' => $form->createView(), 'trick' => $trick));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Trick $trick){
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->remove($trick);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le trick a bien été supprimé.");

            return $this->redirectToRoute('st_platform_homepage');
        }

        return $this->render('STPlatformBundle:Trick:delete.html.twig', array(
            'trick' => $trick,
            'form' => $form->createView(),
        ));
    }
}