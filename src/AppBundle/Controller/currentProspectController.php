<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Prospect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class currentProspectController extends Controller
{

/**
*@Route("/current-prospect", name="current-prospect")
*/
public function currentProspectAction(){
    $prospectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prospect');
    $prospect = $prospectRepository->findAll();
    if(empty($prospect)){
        $empt=false;
      return $this->render('ajax/current_prospect.html.twig',array('empt'=>$empt));
    }else{
        $empt= true;
        return $this->render('ajax/current_prospect.html.twig', array('prospects'=>$prospect,'empt'=>$empt));
    }
}

/**
*@Route("/current-prospect-form", name="current-prospect-form")
*/
 public function currentProspectFormAction(Request $request){
      $prospect = new Prospect();

      $form = $this->createFormBuilder($prospect)
              ->add('prospectName', TextType::class)
              ->add('prospectEmail', EmailType::class)
              ->add('prospectPhoneNo', TextType::class)
              ->add('save',SubmitType::class,array('label'=>'Add Prospect'))
              ->getForm();

              $form->handleRequest($request);
               if($form->isSubmitted() && $form->isValid()){
                   $prospect = $form->getData();

                   $entityManager = $this->getDoctrine()->getManager();
                   $entityManager->persist($prospect);
                   $entityManager->flush();

                   return $this->redirectToRoute('current-prospect');
               }
              return $this->render('ajax/current_prospect_form.html.twig', array('form' => $form->createView()));
                
    }
}