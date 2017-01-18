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
		$this->styles[] = 'base';
		$this->styles[] = 'reset';
		$this->styles[] = 'accueil';
		$this->styles[] = 'challenge';		
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
	    $nbParticipation = count($participation);
	    
	    $challengeIsAvaiable = empty($_SESSION['user']) OR $myParticipation->giveUp OR !empty($myParticipation->dateSuccess) OR !$challenge->avaiable;
	    $challengeIsWon = !empty($_SESSION['user']) AND !empty($myParticipation->dateSuccess) AND !$myParticipation->giveUp;
	    
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
    
    private function completeObjective($id, $post)
    {
	    $objective = $this->model('Objective')->toComplete($id);	
	    
	    if(!empty($objective)) {
		    $this->model('ObjectiveSuccess')->complete($objective->id, $objective->user);
		    
		    $isChallengeCompleted = $this->model('Objective')->isChallengeCompleted($objective->challenge);
		   	
		   	if($post->downloadable('evidence')) {
			   	$evidenceFolder = IMAGE.'evidence/'.$objective->challenge.'/'.$id.'/'.$_SESSION['user']->id.'/';
			   	$evidenceName = 'big.jpg';
			   	$evidenceThumb = 'small.jpg';
			   	
			   	$post->download('evidence', $evidenceFolder, $evidenceName);
			   	$image = new Image(ROOT.$evidenceFolder.$evidenceName);
			   	$image->createThumb(200, 200, ROOT.$evidenceFolder.$evidenceThumb);
		   	}		   	
		   	
		    if($isChallengeCompleted) {
				$this->model('Participation')->succeed($objective->participation);
			}
	    }
    }
}
