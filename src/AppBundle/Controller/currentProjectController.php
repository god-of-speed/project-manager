<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Project;
use AppBundle\Entity\ProjectMem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentProjectController extends Controller
{
    /**
    *@Route("/current-project", name="current-project")
    */
    public function currentProject(Request $request){
        $projectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project');
        $project = $projectRepository->findAllOrdered();

        $arr = array();
        for($i = 0; $i<count($project); $i++){
            array_push($arr,array($project[$i]->getId(),$project[$i]->getName()));
        }
        if($request->isXmlHttpRequest()){
            return new Response(json_encode($arr));
        }
    }

    /**
    *@Route("/current-project/{id}", name="current-project-id")
    */
      public function currentProjectAction(Request $request,$id){
             $projectRepository= $this->getDoctrine()->getManager()->getRepository('AppBundle:Project');
             $project= $projectRepository->find($id);

             $projectMemRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:ProjectMem');
             $projectMem = $projectMemRepository->findBy(array(
                 'projectId' => $id
             ));
             $teamId = $project->getTeamId();
             $projectMemInj  = new ProjectMem();
     $form = $this->createFormBuilder($projectMemInj)
                   ->add('name', EntityType::class,array(
                       'class'=>'AppBundle:TeamMem',
                       'query_builder'=>function(EntityRepository $er)use($teamId){
                                return    $er->createQueryBuilder('st')
                                            ->andWhere('st.teamId= :searchTerm')
                                            ->setParameter('searchTerm',$teamId)
                                       ->orderBy('st.id','ASC');
                       },
                       'choice_label'=>'name',
                   ))
                   ->add('projectId', TextType::class, array('data'=>$id))
                   ->add('status', ChoiceType::class, array(
                       'choices'=>array('Leader'=>'leader','Member'=>'member')
                   ))
                   ->add('save',SubmitType::class,array('label'=>'Add Project Member'))
                   ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $projectMemInj = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projectMemInj);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }else{

     if($request->isXmlHttpRequest()){
         return $this->render('ajax/current_project.html.twig', array('project'=>$project,'projectMems'=>$projectMem,'form'=>$form->createView()));
     }else{
         return $this->render('ajax/current_project.html.twig', array('project'=>$project,'projectMems'=>$projectMem,'form'=>$form->createView()));
     }
        }
      }
    /**
    *@Route("/current-project-form", name="current-project-form")
    */
    public function currentProjectFormAction(Request $request){
        $project = new Project;
     $form = $this->createFormBuilder($project)
                  ->add('name',TextType::class)
                  ->add('description',TextareaType::class)
                  ->add('startDate',DateType::class,array('widget'=>'single_text'))
                  ->add('endDate',DateType::class,array('widget'=>'single_text'))
                  ->add('teamId',EntityType::class, array(
                      'class'=>'AppBundle:Team',
                      'query_builder'=>function(EntityRepository $er){
                                  return  $er->createQueryBuilder('st')
                                    ->orderBy('st.id');
                      },
                      'choice_label'=>'name',
                                      
                  ))  
                  ->add('save', SubmitType::class,array('label'=>'Add New Project'))
                  ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $project = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
              //dump($url);die;
            return $this->redirectToRoute('current-project-id',array('id'=>$project->getId()));
        } else{
            if($request->isXmlHttpRequest()){
                return $this->render('ajax/current_project_form.html.twig',array('form'=>$form->createView()));
            }else{
                return $this->render('ajax/current_project_form.html.twig',array('form'=>$form->createView()));
            }
        }
    }

    /**
 *@Route("/current-delete-project/{id}", name="current-delete-project")
 */
 public function currentDeleteProjectAction(Request $request,$id){
     $milestoneRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Milestone');
     $milestone = $milestoneRepository->findBy(array(
         "projectId"=>$id
     ));
     if(!empty($milestone)){
       $letter = 'p';
       return $this->render('ajax/failure.html.twig',array('letter'=>$letter,'milestones'=>$milestone));
     }else{
         $projectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project');
         $project = $projectRepository->findOneBy(array(
             'id'=>$id
         ));
          if(!empty($project)){
             $entityManager= $this->getDoctrine()->getManager();
         $entityManager->remove($project);
         $entityManager->flush();
          } 
         $msg = 'Youi have successfully deleted the selected project.';
        return $this->render('ajax/success.html.twig',array('msg'=>$msg));
     }
 }
}