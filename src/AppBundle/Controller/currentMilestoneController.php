<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Milestone;
use AppBundle\Entity\MilestoneMem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentMilestoneController extends Controller
{
    /**
    *@Route("/current-milestone", name="current-milestone")
    */
    public function currentMilestone(Request $request){
        $milestoneRepository = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:Milestone');
        $milestone = $milestoneRepository->findAllOrdered();
        $arr = array();
        for($i = 0; $i<count($milestone); $i++){
            array_push($arr,array($milestone[$i]->getId(),$milestone[$i]->getName()));
        }
        if($request->isXmlHttpRequest()){
            return new Response(json_encode($arr));
        }
    }

    /**
    *@Route("/current-milestone/{id}", name="current-milestone-id")
    */
      public function currentMilestoneAction(Request $request,$id){
             $milestoneRepository= $this->getDoctrine()->getManager()->getRepository('AppBundle:Milestone');
             $milestone= $milestoneRepository->find($id);

             $milestoneMemRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:MilestoneMem');
             $milestoneMem = $milestoneMemRepository->findBy(array(
                 'milestoneId'=>$id
             ));
             $projectId = $milestone->getProjectId();

             $milestoneMemInj  = new MilestoneMem();
     $form = $this->createFormBuilder($milestoneMemInj)
                   ->add('name', EntityType::class,array(
                       'class'=>'AppBundle:ProjectMem',
                       'query_builder'=>function(EntityRepository $er)use($projectId){
                                return    $er->createQueryBuilder('st')
                                            ->andWhere('st.projectId= :searchTerm')
                                            ->setParameter('searchTerm',$projectId)
                                       ->orderBy('st.id','ASC');
                       },
                       'choice_label'=>'name',
                   ))
                   ->add('milestoneId', TextType::class, array('data'=>$id))
                   ->add('status', ChoiceType::class, array(
                       'choices'=>array('Leader'=>'leader','Member'=>'member')
                   ))
                   ->add('save',SubmitType::class,array('label'=>'Add milestone Member'))
                   ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $milestoneMemInj = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($milestoneMemInj);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }else{

     if($request->isXmlHttpRequest()){
         return $this->render('ajax/current_milestone.html.twig', array('milestone'=>$milestone,'milestoneMems'=>$milestoneMem,'form'=>$form->createView()));
     }else{
         return $this->render('ajax/current_milestone.html.twig', array('milestone'=>$milestone,'milestoneMems'=>$milestoneMem,'form'=>$form->createView()));
     }
        }
      }

    /**
    *@Route("/current-milestone-form", name="current-milestone-form")
    */
    public function currentmilestoneFormAction(Request $request){
        $milestone = new Milestone;
     $form = $this->createFormBuilder($milestone)
                  ->add('name',TextType::class)
                  ->add('description',TextareaType::class)
                  ->add('startDate',DateType::class,array('widget'=>'single_text'))
                  ->add('endDate',DateType::class,array('widget'=>'single_text'))
                  ->add('projectId',EntityType::class, array(
                      'class'=>'AppBundle:Project',
                      'query_builder'=>function(EntityRepository $er){
                                  return  $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                      },
                      'choice_label'=>'name',
                                      
                  ))  
                  ->add('save', SubmitType::class,array('label'=>'Add New milestone'))
                  ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $milestone = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($milestone);
            $entityManager->flush();
              //dump($url);die;
            return $this->redirectToRoute('current-milestone-id',array('id'=>$milestone->getId()));
        } else{
            if($request->isXmlHttpRequest()){
                return $this->render('ajax/current_milestone_form.html.twig',array('form'=>$form->createView()));
            }else{
                return $this->render('ajax/current_milestone_form.html.twig',array('form'=>$form->createView()));
            }
        }
    }

    /**
 *@Route("/current-delete-milestone/{id}", name="current-delete-milestone")
 */
 public function currentDeletemilestoneAction(Request $request,$id){
     $taskRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Task');
     $task = $taskRepository->findBy(array(
         "milestoneId"=>$id
     ));
     if(!empty($task)){
       $letter = 'm';
       return $this->render('ajax/failure.html.twig',array('letter'=>$letter,'tasks'=>$task));
     }else{
         $milestoneRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Milestone');
         $milestone = $milestoneRepository->findOneBy(array(
             'id'=>$id
         ));
         if(!empty($milestone)){
            $entityManager= $this->getDoctrine()->getManager();
         $entityManager->remove($milestone);
         $entityManager->flush();
         }
         $msg = 'Youi have successfully deleted the selected milestone.';
        return $this->render('ajax/success.html.twig',array('msg'=>$msg));
     }
 }
}