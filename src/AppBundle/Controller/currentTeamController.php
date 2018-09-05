<?php
  namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Team;
use AppBundle\Entity\TeamMem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class currentTeamController extends Controller
{

/**
* @Route("/current-team", name="current-team")
*/
public function currentTeam(Request $request){
    $teamRepository = $this->getDoctrine()->getManager()->getRepository("AppBundle:Team");
    $team = $teamRepository->findAllOrdered();
    $arr = array();
    for($i=0; $i<count($team); $i++){
        array_push($arr,array($team[$i]->getId(),$team[$i]->getName()));
    }
    if($request->isXmlHttpRequest()) {
        $response = new Response(json_encode($arr));
        $response->headers->set('Content-Type', 'application/json');

         return $response;
    }
}

/**
*@Route("/current-team/{id}", name="current-team-id")
*/
public function currentTeamAction(Request $request,$id){
     $teamRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Team');
     $team = $teamRepository->find($id);

     $teamMemRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:TeamMem');
     $teamMem = $teamMemRepository->findBy(array(
         'teamId'=>$id
     ));

     $teamMemInj  = new TeamMem();
     $form = $this->createFormBuilder($teamMemInj)
                   ->add('name', EntityType::class,array(
                       'class'=>'AppBundle:Staff',
                       'query_builder'=>function(EntityRepository $er){
                                return    $er->createQueryBuilder('st')
                                       ->orderBy('st.id','ASC');
                       },
                       'choice_label'=>'name',
                   ))
                   ->add('teamId', TextType::class, array('data'=>$id))
                   ->add('status', ChoiceType::class, array(
                       'choices'=>array('Leader'=>'leader','Member'=>'member')
                   ))
                   ->add('save',SubmitType::class,array('label'=>'Add Team-Mate'))
                   ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $teamMemInj = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teamMemInj);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }else{

     if($request->isXmlHttpRequest()){
         //dump($team);die;
         $temp = $this->forward('ajax/current_team.html.twig', array('team'=>$team,'teamMems'=>$teamMem,'form'=>$form->createView()))->getContent();
         $json = json_encode($temp);
         $response = new Response($json,200);
         $response->headers->set('Content-Type','application/json');
         return $response;
     }else{
         return $this->render('ajax/current_team.html.twig', array('team'=>$team,'teamMems'=>$teamMem,'form'=>$form->createView()));
     }
        }
}

/**
*@Route("/current-team-form", name="current-team-form")
*/
public function currentTeamFormAction(Request $request){
    $team = new Team();
     $form = $this->createFormBuilder($team)
                    ->add('name', TextType::class)
                    ->add('description', TextareaType::class)
                    ->add('save', SubmitType::class, array('label' => 'Create Team'))
                    ->getForm();

            $form->handleRequest($request);
            if($form->isSubmitted() & $form->isValid()){
                $team = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($team);
                $entityManager->flush();
              //dump($url);die;
            return $this->redirectToRoute('current-team-id',array('id'=>$team->getId()));
            }else{
                if($request->isXmlHttpRequest()){
                    return $this->render('ajax/current_team_form.html.twig',array('form'=>$form->createView()));
                }else{
                    return $this->render('ajax/current_team_form.html.twig',array('form'=>$form->createView()));
                }
            }
}

 /**
 *@Route("/current-delete-team/{id}", name="current-delete-team")
 */
 public function currentDeleteTeamAction(Request $request,$id){
     $projectRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project');
     $project = $projectRepository->findBy(array(
         "teamId"=>$id
     ));
     if(!empty($project)){
         $letter = 't';
       return $this->render('ajax/failure.html.twig',array('letter'=>$letter,'projects'=>$project));
     }else{
         $teamRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Team');
         $team = $teamRepository->findOneBy(array(
             'id'=>$id
         ));
         if(!empty($team)){
            $entityManager= $this->getDoctrine()->getManager();
         $entityManager->remove($team);
         $entityManager->flush();
         }
          $msg = 'Youi have successfully deleted the selected team.';
        return $this->render('ajax/success.html.twig',array('msg'=>$msg));
     }
 }
}
?>