<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentPropertiesController extends Controller
{
    /**
    *@Route("/current-properties", name="current-properties")
    */
    public function currentPropertiesAction(Request $request)
    {
       $propertiesRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Properties');
       $properties= $propertiesRepository->findAll();
        
       if($properties){
           $empt=true;
           return $this->render('ajax/current_properties.html.twig',array('properties'=>$properties,'empt'=>$empt));
       }else{
           $empt=false;
           return $this->render('ajax/current_properties.html.twig',array('empt'=>$empt));
       }
    }

    /**
    *@Route("/current-properties-form", name="current-properties-form")
    */
    public function currentPropertiesFormAction(Request $request){
        $properties = new Properties();
        $form = $this->createFormBuilder($properties)
                     ->add('name',TextType::class,array('label'=>'Name'))
                     ->add('location',TextareaType::class,array('label'=>'Location'))
                     ->add('save',SubmitType::class,array('label'=>'Add Property'))
                     ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $properties=$form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($properties);
            $entityManager->flush();

            return $this->redirectToRoute('current-properties');
        }else{
            return $this->render('ajax/current_properties_form.html.twig',array('form'=>$form->createView())); 
        }
    }
}