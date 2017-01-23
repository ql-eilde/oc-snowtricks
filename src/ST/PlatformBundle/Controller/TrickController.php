<?php
/**
 * Created by PhpStorm.
 * User: quentinleilde
 * Date: 1/15/17
 * Time: 2:19 PM
 */

namespace ST\PlatformBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use ST\PlatformBundle\Entity\Trick;
use ST\PlatformBundle\Form\TrickType;
use ST\PlatformBundle\Form\TrickEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrickController extends Controller
{
    public function indexAction(){

        $listTricks = $this->getDoctrine()->getManager()->getRepository('STPlatformBundle:Trick')->findAll();

        return $this->render('STPlatformBundle:Trick:index.html.twig', array('listTricks' => $listTricks));
    }

    public function viewAction($id){
        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository('STPlatformBundle:Trick')->find($id);

        $listComments = $em->getRepository('STPlatformBundle:Comment')->findBy(array('trick' => $trick));
        $listImages = $em->getRepository('STPlatformBundle:Image')->findBy(array('trick' => $trick));

        return $this->render('STPlatformBundle:Trick:view.html.twig', array(
            'trick' => $trick,
            'listComments' => $listComments,
            'listImages' => $listImages,
            ));
    }

    public function addAction(Request $request){
        $trick = new Trick();
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