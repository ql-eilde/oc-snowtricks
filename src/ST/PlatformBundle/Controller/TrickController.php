<?php

namespace ST\PlatformBundle\Controller;

use ST\PlatformBundle\Entity\Comment;
use ST\PlatformBundle\Entity\Trick;
use ST\PlatformBundle\Form\CommentType;
use ST\PlatformBundle\Form\TrickType;
use ST\PlatformBundle\Form\TrickEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $listComments = $em->getRepository('STPlatformBundle:Comment')->findBy(array('trick' => $trick));
        $listImages = $em->getRepository('STPlatformBundle:Image')->findBy(array('trick' => $trick));
        $listVideos = $em->getRepository('STPlatformBundle:Video')->findBy(array('trick' => $trick));

        // Ajout commentaire
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
            'listComments' => $listComments,
            'listImages' => $listImages,
            'listVideos' => $listVideos,
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

        if(!$trick){
            throw $this->createNotFoundException("Pas de trick trouvé avec l'id".$id);
        }

        $form = $this->createForm(TrickEditType::class, $trick);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Votre trick a bien été modifié.');

            return $this->redirectToRoute('st_platform_view', array('id' => $id, 'slug' => $slug));
        }

        return $this->render('STPlatformBundle:Trick:edit.html.twig', array('form' => $form->createView(), 'trick' => $trick));
    }
}