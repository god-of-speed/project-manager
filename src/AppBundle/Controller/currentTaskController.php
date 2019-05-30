<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Task;
use AppBundle\Entity\TaskMem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentTaskController extends Controller
{
    /**
    *@Route("/current-task", name="current-task")
    */
    public function currentAction(Request $request){
        $taskRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Task');
        $task = $taskRepository->findAllOrdered();
        $arr = array();
        for($i = 0; $i<count($task); $i++){
            array_push($arr,array($task[$i]->getId(),$task[$i]->getName()));
        }
        if($request->isXmlHttpRequest()){
            return new Response(json_encode($arr));
        }
    }

    /**
    *@Route("/current-task/{id}", name="current-task-id")
    */
      public function currentTaskAction(Request $request,$id){
             $taskRepository= $this->getDoctrine()->getManager()->getRepository('AppBundle:Task');
             $task= $taskRepository->find($id);

             $taskMemRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:TaskMem');
             $taskMem = $taskMemRepository->findBy(array(
                 'taskId'=>$id
             ));
              $milestoneId = $task->getMilestoneId();
             $taskMemInj  = new TaskMem();
     $form = $this->createFormBuilder($taskMemInj)
                   ->add('name', EntityType::class,array(
                       'class'=>'AppBundle:MilestoneMem',
                       'query_builder'=>function(EntityRepository $er)use($milestoneId){
                                return    $er->createQueryBuilder('st')
                                             ->andWhere('st.milestoneId= :searchTerm')
                                             ->setParameter('searchTerm',$milestoneId)
                                       ->orderBy('st.id','ASC');
                       },
                       'choice_label'=>'name'
                   ))
                   ->add('taskId', TextType::class, array('data'=>$id))
                   ->add('status', ChoiceType::class, array(
                       'choices'=>array('Leader'=>'leader','Member'=>'member')
                   ))
                   ->add('save',SubmitType::class,array('label'=>'Add task Member'))
                   ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $taskMemInj = $form->getData();
            $taskMemInj->setName($taskMemInj->getName()->getName());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taskMemInj);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }else{

     if($request->isXmlHttpRequest()){
         return $this->render('ajax/current_task.html.twig', array('task'=>$task,'taskMems'=>$taskMem,'form'=>$form->createView()));
     }else{
         return $this->render('ajax/current_task.html.twig', array('task'=>$task,'taskMems'=>$taskMem,'form'=>$form->createView()));
     }
        }
      }

    /**
    *@Route("/current-task-form", name="current-task-form")
    */
    public function currentTaskFormAction(Request $request){
        $task = new Task;
     $form = $this->createFormBuilder($task)
                  ->add('name',TextType::class)
                  ->add('description',TextareaType::class)
                  ->add('startDate',DateType::class,array('widget'=>'single_text'))
                  ->add('endDate',DateType::class,array('widget'=>'single_text'))
                  ->add('milestoneId',EntityType::class, array(
                      'class'=>'AppBundle:Milestone',
                      'query_builder'=>function(EntityRepository $er){
                                  return  $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                      },
                      'choice_label'=>'name',
                                      
                  ))  
                  ->add('save', SubmitType::class,array('label'=>'Add New task'))
                  ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
              //dump($url);die;
            return $this->redirectToRoute('current-task-id',array('id'=>$task->getId()));
        } else{
            if($request->isXmlHttpRequest()){
                return $this->render('ajax/current_task_form.html.twig',array('form'=>$form->createView()));
            }else{
                return $this->render('ajax/current_task_form.html.twig',array('form'=>$form->createView()));
            }
        }
    }

    /**
 *@Route("/current-delete-task/{id}", name="current-delete-task")
 */
 public function currentDeletetaskAction(Request $request,$id){
         $taskRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Task');
         $task = $taskRepository->findOneBy(array(
             'id'=>$id
         ));
         if(!empty($task)){
             $entityManager= $this->getDoctrine()->getManager();
         $entityManager->remove($task);
         $entityManager->flush();
         }
          $msg = 'You have successfully deleted the selected task.';
        return $this->render('ajax/success.html.twig',array('msg'=>$msg));
 }
}