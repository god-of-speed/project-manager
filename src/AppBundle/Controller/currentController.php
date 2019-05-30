<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class currentController extends Controller
{

/**
*@Route("/", name="current-staff")
*/
public function currentStaffAction(){
    $staffRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Staff');
    $staff = $staffRepository->findAll();
    if(empty($staff)){
        $empt = false;
        return $this->render('ajax/current_staff.html.twig',array('empt'=>$empt));
    }else{
        $empt = true;
        return $this->render('ajax/current_staff.html.twig', array('staffs'=>$staff,'empt'=>$empt));
    }
}

/**
*@Route("/current-staff-form", name="current-staff-form")
*/
 public function currentStaffFormAction(Request $request){
      $staff = new Staff();

      $form = $this->createFormBuilder($staff)
              ->add('name', TextType::class)
              ->add('email', EmailType::class)
              ->add('phoneNo', TextType::class)
              ->getForm();

              $form->handleRequest($request);
               if($form->isSubmitted() && $form->isValid()){
                   $staff = $form->getData();

                   $entityManager = $this->getDoctrine()->getManager();
                   $entityManager->persist($staff);
                   $entityManager->flush();

                   return $this->redirectToRoute('current-staff');
               }
              return $this->render('ajax/current_staff_form.html.twig', array('form' => $form->createView()));
                
    }

    /**
     * @Route("/test-staff", name="test-staff")
     */
    public function testStaffAction(
        Request $request
    ) {
        $staff = new Staff;

        $form = $this->createFormBuilder($staff)
            ->add('name', TextType::class)
            ->add('phoneNo', TextType::class)
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            dump($staff);
        }

        return $this->render('test.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
