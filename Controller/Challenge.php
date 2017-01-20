<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
use System\Debug;
use System\Image;
use System\Str;
use DateTime;

/**
 * connexion class.
 */
class Challenge extends Controller
{
	protected function __construct()
	{
		$this->styles[] = 'mikastrap';
		$this->styles[] = 'reset';
		$this->styles[] = 'accueil';
		$this->styles[] = 'challenge';	
		$this->styles[] = FANCYBOX_CSS;		
		
		$this->javascript[] = FANCYBOX;
		$this->javascript[] = FANCYBOX_INIT;
	}
	
	public function index($id = null)
    {
	    if(empty($id) OR !$this->model('Challenge')->doesExist($id))
	    	$this->go(PREVIOUS);
	    
	    if(!empty($_SESSION['user'])) {
	    	$myParticipation = $this->model('Participation')->mineOfChallenge($id);
	    		
			$participationForm = new Form(['name' => 'participation']);
			$objectiveForm = new Form(['name' => 'objective']);
			$postForm = new Form(['name' => 'post']);
			
			if($participationForm->posted()){
				
				$action = $participationForm->datas('action');
				
				if(empty($myParticipation) && $action == 'participer') {
					$myParticipation = $this->join($id);
				}

				if(!empty($myParticipation) && $myParticipation->giveUp == 0 && $action == 'abandonner') {
					$myParticipation = $this->giveup($myParticipation);
				}
			
			} elseif($objectiveForm->posted()) {
			
				$objectiveId = key($objectiveForm->datas());

				$this->completeObjective($objectiveId, $objectiveForm);
				
				$myParticipation = $this->model('Participation')->mineOfChallenge($id);
			
			} elseif($postForm->posted()) {
				
				$post = $postForm->datas();
			    $postForm->verify(empty($post['content']), 'Ton post est vide.');
			    
			    if($postForm->noErrors()) {
				    $post['user'] = $_SESSION['user']->id;
				    $post['challenge'] = $id;
				    $this->model('Post')->save($post);
			    }
			    
		    }
		}
	    
	    $challenge		 = $this->model('Challenge')->getById($id);	    		    	    
	    $objectives      = $this->model('Objective')->ofChallenge($id);
	    $likes           = $this->model('Like')->ofChallenge($id);
	    $posts			 = $this->model('Post')->ofChallenge($id);
		$participation   = $this->model('Participation')->ofChallenge($id);
		$winners         = $this->model('Participation')->winnersOfChallenge($id);
		$badge           = $this->model('Achievement')->ofChallenge($id);
	    $nbParticipation = count($participation);
	    		
	    $challengeIsAvaiable = !empty($myParticipation) AND empty($myParticipation->giveUp) AND empty($myParticipation->dateSuccess) AND !empty($challenge->avaiable);
	    	    
	    $this->title = 'Le défi "'.$challenge->title.'" de '.$challenge->author;
	    $this->datas = compact(
	    	'challenge',
	    	'objectives',
	    	'likes',
	    	'participation',
	    	'myParticipation',
	    	'linkParticipation',
	    	'objectivesSucceed',
	    	'postForm',
	    	'posts',
	    	'nbParticipation',
	    	'participationForm',
	    	'objectiveForm',
	    	'challengeIsAvaiable',
	    	'challengeIsWon',
	    	'badge',
	    	'winners'
	    );
	    
	    $this->view();
    }
    
    private function join($id)
    {
		$newParticipation = ['user' => $_SESSION['user']->id, 'challenge' => $id];
	    $this->model('Participation')->save($newParticipation);
		    				    	
	    return $this->model('Participation')->mineOfChallenge($id);
    }
    
    private function giveup($myParticipation)
    {
	    $this->model('Participation')->giveup($myParticipation->id);
	    	
	    return $this->model('Participation')->mineOfChallenge($myParticipation->challenge);
    }
    
    private function completeObjective($id, $form)
    {
	    $objective = $this->model('Objective')->toComplete($id);	
	    
	    if(!empty($_SESSION['user']) AND !empty($objective)) {
		    		    
		    $this->model('ObjectiveSuccess')->complete($objective->id, $objective->user);
		    
		    $isChallengeCompleted = $this->model('Objective')->isChallengeCompleted($objective->challenge);
		   	
		   	$post = [];
		    $post['challenge'] = $objective->challenge;
		    $post['content'] = $_SESSION['user']->name.' a terminé l\'objectif "'.$objective->instruction.'" !';
		   	
		   	if($form->downloadable('evidence')) {
			   	
			   	$evidenceFolder = IMAGE.'evidence/'.$objective->challenge.'/'.$id.'/'.$_SESSION['user']->id.'/';
			   	$evidenceName = 'big.jpg';
			   	$evidenceThumb = 'small.jpg';
			   	
			   	$form->download('evidence', $evidenceFolder, $evidenceName);
			   	$image = new Image(ROOT.$evidenceFolder.$evidenceName);
			   	$image->resize(null, 800);
			   	$image->createThumb(200, 200, ROOT.$evidenceFolder.$evidenceThumb);
			   	
			   	$post['content'] .= " D'ailleurs, en voici <a href='".$evidenceFolder.$evidenceName."' class='evidence fancybox'>une preuve</a>.";
		   	}
		   	
		   	$this->model('Post')->save($post);
		   	
		    if($isChallengeCompleted) {
				$this->model('Participation')->succeed($objective->participation);
				$achievement = $this->model('ChallengeAchievement')->getAchievement($objective->challenge, $_SESSION['user']->id);
				
				if(!empty($achievement)) {
					$this->model('UserAchievement')->save(['achievement' => $achievement->id, 'user' => $_SESSION['user']->id]);
					$post['content'] .= ' Le badge "'.$achievement->title.'" a été obtenu !';
				}
			}
			
			$this->model('Post')->save($post);
	    }
    }
}
