<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
use System\Debug;
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
	    if(empty($id))
	    	$this->go(PREVIOUS);
	    
	    $challenge = $this->model('Challenge')->getById($id);
	    
	    if(empty($challenge))
	    	$this->go(PREVIOUS);
	    	
	    $this->title = 'Le défi "'.$challenge->title.'" de '.$challenge->author;
	    	    
	    $objectives      = $this->model('Objective')->ofChallenge($id);
	    $likes           = $this->model('Like')->ofChallenge($id);
	    $participation   = $this->model('Participation')->ofChallenge($id);
	    	    
	    if(!empty($_SESSION['user'])) {
	    	
	    	if(empty($participation->dateSuccess)) {
			    $myParticipation = $this->model('Participation')->mineOfChallenge($id);
			    $linkParticipation = [
				    'title' => empty($myParticipation) ? 'Participer' : 'Abandonner',
			    	'href' => empty($myParticipation) ? BASE.CONTROLLER.'/join/'.$id : BASE.CONTROLLER.'/giveup/'.$id
			    ];
			}
		    
		    $postForm = new Form(['name' => 'post']);
			
			if($postForm->posted()) {
				$post = $postForm->datas();
			    $postForm->verify(empty($post['content']), 'Ton post est vide.');
			    
			    if($postForm->noErrors()) {
				    $post['user'] = $_SESSION['user']->id;
				    $post['challenge'] = $id;
				    $this->model('Post')->save($post);
			    }
		    }
		}
		
		$posts = $this->model('Post')->ofChallenge($id);
	    	    
	    $this->datas = compact(
	    	'challenge',
	    	'objectives',
	    	'likes',
	    	'participation',
	    	'myParticipation',
	    	'linkParticipation',
	    	'objectivesSucceed',
	    	'postForm',
	    	'posts'
	    );
	    
	    $this->view();
	  
    }
    
    public function join($id = null)
    {
	    $challenge = $this->verifyChallenge($id);

	    $myParticipation = $this->model('Participation')->mineOfChallenge($id);
	    	    
	    if(!empty($myParticipation))
	    	$this->go(PREVIOUS);
	    	
	    $newParticipation = ['user' => $_SESSION['user']->id, 'challenge' => $id];
	    $this->model('Participation')->save($newParticipation);
	    	
	    $this->go(BASE.CONTROLLER.'/'.$id.'/'.$challenge->slug);
    }
    
    public function giveup($id = null)
    {
	    $challenge = $this->verifyChallenge($id);
	    	
	    $myParticipation = $this->model('Participation')->mineOfChallenge($id);
	    	    
	    if(empty($myParticipation))
	    	$this->go(PREVIOUS);
	    	
	    $this->model('Participation')->giveup($myParticipation->id);
	    	
	    $this->go(BASE.CONTROLLER.'/'.$id.'/'.$challenge->slug);
    }
    
    public function complete($id = null)
    {
	    $objective = $this->model('Objective')->toComplete($id);	
	    
	    if(!empty($objective)) {
		    $this->model('ObjectiveSuccess')->complete($objective->id, $objective->user);
		    		    
		    $challengeIsCompleted = true;
		   	
			foreach($this->model('Objective')->ofChallenge($objective->challenge) as $obj) {
				if($obj->completed == 0)
					$challengeIsCompleted = false;
			}
		   	
		    if($challengeIsCompleted) {
				$this->model('Participation')->succeed($objective->participation);
			}
	    }

	    $this->go(PREVIOUS);
    }
    
    private function verifyChallenge($id)
    {
	    if(empty($id) OR empty($_SESSION['user']))
	    	$this->go(PREVIOUS);
	    	
	    $challenge = $this->model('Challenge')->getById($id);
	    
	    if(empty($challenge))
	    	$this->go(PREVIOUS);
	    	
	    $now = new DateTime();
		$end = new DateTime($challenge->dateEnd);
		
		if($now > $end)
	    	$this->go(PREVIOUS);
	    	
	    return $challenge;
    }
}
