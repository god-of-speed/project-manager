<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Inspector;
use AppBundle\Entity\Staff;
use AppBundle\Entity\Prospect;
use AppBundle\Entity\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentInspectionController extends Controller
{
    /**
    *@Route("/current-inspection", name="current-inspection")
    */
    public function currentInspectionAction(Request $request)
    {
        $prospectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prospect');
        $prospect = $prospectRepository->findAll();

        $staffRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Staff');
        $staff = $staffRepository->findAll();

        $propertiesRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Properties');
        $properties= $propertiesRepository->findAll();

        $inspectorRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Inspector');
        $inspector = $inspectorRepository->findAll();
        
        if(!empty($inspector)){
         $letter=true;

        $staffForm = new Staff();
        $prospectForm = new Prospect();
        $propertyForm = new Properties();
        $inspectForm = new Inspector();

        $form = $this->createFormBuilder($inspectForm)
                     ->add('date',DateType::class,array('widget'=>'single_text'))
                     ->add('prospect',EntityType::class,array(
                         'class'=>'AppBundle:Prospect',
                         'query_builder'=>function(EntityRepository $er){
                              return $er->createQueryBuilder('st')
                                        ->orderBy('st.id');
                         },
                         'choice_label'=>'prospectName',
                     ))
                     ->add('staff',EntityType::class,array(
                         'class'=>'AppBundle:Staff',
                         'query_builder'=>function(EntityRepository $er){
                             return $er->createQueryBuilder('st')
                                       ->orderBy('st.id');
                         },
                         'choice_label'=>'name',
                     ))
                     ->add('inProperty',EntityType::class,array(
                         'class'=>'AppBundle:Properties',
                         'query_builder'=>function(EntityRepository $er){
                             return $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                         },
                         'choice_label'=>'name',
                     ))
                     ->add('staffRemark',TextType::class)
                     ->add('prospectRemark',TextType::class)
                     ->add('save',SubmitType::class,array('label'=>'Save'))
                     ->getForm();
        $form->handleRequest($request);

        $form1 = $this->createFormBuilder($staffForm)
                    ->add('name',TextType::class,array('label'=>'Surname first'))
                    ->add('email',TextType::class)
                    ->add('phoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Staff'))
                    ->getForm();
        $form1->handleRequest($request);

        $form2 = $this->createFormBuilder($prospectForm)
                      ->add('prospectName',TextType::class,array('label'=>'Surname first'))
                    ->add('prospectEmail',TextType::class)
                    ->add('prospectPhoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Visitor'))
                    ->getForm();
        $form2->handleRequest($request);

        $form3 = $this->createFormBuilder($propertyForm)
                       ->add('name',TextType::class)
                    ->add('location',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Property'))
                    ->getForm();
        $form3->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $inspectForm = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inspectForm);
            $entityManager->flush();
             
             return $this->redirect($request->getUri());
     }
        if($form1->isSubmitted() && $form1->isValid()){
            $staffForm = $form1->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staffForm);
            $entityManager->flush();
            
             return $this->redirect($request->getUri());
    }
        if($form2->isSubmitted() && $form2->isValid()){
            $prospectForm = $form2->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospectForm);
            $entityManager->flush();
             
              return $this->redirect($request->getUri());
    }
        if($form3->isSubmitted() && $form3->isValid()){
            $propertiesForm = $form3->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propertiesForm);
            $entityManager->flush();
            
             return $this->redirect($request->getUri());
    }
        return $this->render("ajax/current_inspector.html.twig",array('form'=>$form->createView(),'form1'=>$form1->createView(),'form2'=>
        $form2->createView(),'form3'=>$form3->createView(),'inspector'=>$inspector,'letter'=>$letter));
    }else{
           $letter=false;

        $staffForm = new Staff();
        $prospectForm = new Prospect();
        $propertyForm = new Properties();
        $inspectForm = new Inspector();

        $form = $this->createFormBuilder($inspectForm)
                     ->add('date',DateType::class,array('widget'=>'single_text'))
                     ->add('prospect',EntityType::class,array(
                         'class'=>'AppBundle:Prospect',
                         'query_builder'=>function(EntityRepository $er){
                              return $er->createQueryBuilder('st')
                                        ->orderBy('st.id');
                         },
                         'choice_label'=>'prospectName',
                     ))
                     ->add('staff',EntityType::class,array(
                         'class'=>'AppBundle:Staff',
                         'query_builder'=>function(EntityRepository $er){
                             return $er->createQueryBuilder('st')
                                       ->orderBy('st.id');
                         },
                         'choice_label'=>'name',
                     ))
                     ->add('inProperty',EntityType::class,array(
                         'class'=>'AppBundle:Properties',
                         'query_builder'=>function(EntityRepository $er){
                             return $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                         },
                         'choice_label'=>'name',
                     ))
                     ->add('staffRemark',TextType::class)
                     ->add('prospectRemark',TextType::class)
                     ->add('save',SubmitType::class,array('label'=>'Save'))
                     ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $inspectForm = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inspectForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        $form1 = $this->createFormBuilder($staffForm)
                    ->add('name',TextType::class,array('label'=>'Surname first'))
                    ->add('email',TextType::class)
                    ->add('phoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Staff'))
                    ->getForm();
        $form1->handleRequest($request);
        if($form1->isSubmitted() && $form1->isValid()){
            $staffForm = $form1->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staffForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        $form2 = $this->createFormBuilder($prospectForm)
                      ->add('prospectName',TextType::class,array('label'=>'Surname first'))
                    ->add('prospectEmail',TextType::class)
                    ->add('prospectPhoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Visitor'))
                    ->getForm();
        $form2->handleRequest($request);
        if($form2->isSubmitted() && $form2->isValid()){
            $prospectForm = $form2->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospectForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        $form3 = $this->createFormBuilder($propertyForm)
                       ->add('name',TextType::class)
                    ->add('location',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Property'))
                    ->getForm();
        $form3->handleRequest($request);
        if($form3->isSubmitted() && $form3->isValid()){
            $propertiesForm = $form3->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propertiesForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render("ajax/current_inspector.html.twig",array('form'=>$form->createView(),'form1'=>$form1->createView(),'form2'=>
        $form2->createView(),'form3'=>$form3->createView(),'inspector'=>$inspector,'letter'=>$letter));
    }
    }

    /**
    *@Route("/current-inspector-view/{id}", name="current-inspector-view")
    */
    public function viewAction(Request $request,$id)
    {
        $inspectorRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Inspector');
        $inspector = $inspectorRepository->find($id);
       

        $staffRepository= $this->getDoctrine()->getManager()->getRepository('AppBundle:Staff');
        $staff = $staffRepository->findOneBy(array(
           'name'=>$inspector->getStaff()
        ));
        $prospectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Prospect');
        $prospect = $prospectRepository->findOneBy(array(
           'prospectName'=>$inspector->getProspect()
        ));
        $propertyRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Properties');
        $property = $propertyRepository->findOneBy(array(
           'name'=>$inspector->getInProperty()
        ));

        if($staff && $prospect && $property){
            return $this->render('ajax/current_inspector_view.html.twig',array('staff'=>$staff,'prospect'=>$prospect,'property'
            =>$property,'inspector'=>$inspector));
        }else{
            $msg = "Its looks like you have deleted the assigned staff or prospect or property from the database.";
            return $this->render('ajax/success.html.twig',array('msg'=>$msg));
        }
    }

    /**
    *@Route("/current-inspector-edit/{id}", name="current-inspector-edit")
    */
    public function editAction(Request $request,$id)
    {
        $inspectorRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Inspector');
        $inspector = $inspectorRepository->find($id);
        $srem=$inspector->getStaffRemark();
        $prem = $inspector->getProspectRemark();

        $staffForm = new Staff();
        $prospectForm = new Prospect();
        $propertyForm = new Properties();
        
        if(!empty($inspector)){
            $form = $this->createFormBuilder($inspector)
                         ->add('date',DateType::class,array('widget'=>'single_text','data'=>$inspector->getDate()))
                         ->add('staff',EntityType::class,array(
                             'class'=>'AppBundle:Staff',
                             'query_builder'=>function(EntityRepository $er){
                                 return $er->createQueryBuilder('st')
                                          ->orderBy('st.id');
                             },
                             'choice_label'=>'name',
                             'data'=>$inspector->getStaff(),
                         ))
                         ->add('prospect',EntityType::class,array(
                             'class'=>'AppBundle:Prospect',
                             'query_builder'=>function(EntityRepository $er){
                                 return $er->createQueryBuilder('st')
                                           ->orderBy('st.id');
                             },
                             'choice_label'=>'prospectName',
                             'data'=>$inspector->getProspect(),
                         ))
                          ->add('inProperty',EntityType::class,array(
                         'class'=>'AppBundle:Properties',
                         'query_builder'=>function(EntityRepository $er){
                             return $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                         },
                         'choice_label'=>'name',
                         'data'=>$inspector->getInProperty(),
                     ))
                     ->add('staffRemark',TextType::class, array('data'=>$srem))
                     ->add('prospectRemark',TextType::class,array('data'=>$prem))
                     ->add('save',SubmitType::class,array('label'=>'Save'))
                     ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute("current-inspection");
        }

       $form1 = $this->createFormBuilder($staffForm)
                    ->add('name',TextType::class,array('label'=>'Surname first'))
                    ->add('email',TextType::class)
                    ->add('phoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Staff'))
                    ->getForm();
        $form1->handleRequest($request);
        if($form1->isSubmitted() && $form1->isValid()){
            $staffForm = $form1->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staffForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        $form2 = $this->createFormBuilder($prospectForm)
                      ->add('prospectName',TextType::class,array('label'=>'Surname first'))
                    ->add('prospectEmail',TextType::class)
                    ->add('prospectPhoneNo',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Visitor'))
                    ->getForm();
        $form2->handleRequest($request);
        if($form2->isSubmitted() && $form2->isValid()){
            $prospectForm = $form2->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospectForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        $form3 = $this->createFormBuilder($propertyForm)
                       ->add('name',TextType::class)
                    ->add('location',TextType::class)
                    ->add('save',SubmitType::class,array('label'=>'Add a Property'))
                    ->getForm();
        $form3->handleRequest($request);
        if($form3->isSubmitted() && $form3->isValid()){
            $propertiesForm = $form3->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propertiesForm);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }


        return $this->render('ajax/current_inspector_edit.HTML.TWIG',array("form"=>$form->createView(),'form1'=>$form1->
        createView(),'form2'=>$form2->createView(),'form3'=>$form3->createView()));
        }else{
            $msg = "The selected file doesn't exist!";
            return $this->render('ajax/success.html.twig',array('msg'=>$msg));
        }
    }

    /**
    *@Route("/current-inspector-delete/{id}", name="current-inspector-delete")
    */
    public function delAction(Request $request,$id)
    {
        $inspectorRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Inspector');
        $inspector = $inspectorRepository->findOneBy(array(
            'id'=>$id
        ));

        if(!empty($inspector)){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inspector);
            $entityManager->flush();

            return $this->redirectToRoute("current-inspection");
        }else{
            $msg= 'The selected file no longer exists';
            return $this->render("ajax/success.html.twig",array('msg'=>$msg));
        }
    }
}

?>