<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
use System\Debug;

/**
 * connexion class.
 */
class Challenge extends Controller
{
	protected function __construct()
	{
		$this->styles[] = 'mikastrap';		
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
	    $myParticipation = $this->model('Participation')->mineOfChallenge($id);
	    
	    if(!empty($_SESSION['user'])) {
	    	
		    $participate = 'Participer';
		    $giveUp = 'Abandonner';
		    
		    $participationForm = new Form(['name' => 'participation']);
		    $action = empty($myParticipation) ? $participate : $giveUp;
		    	    
		    if($participationForm->posted()) {
			    if($action == $participate) {
				    
				    $newParticipation = ['user' => $_SESSION['user']->id, 'challenge' => $id];
			    	if($this->model('Participation')->save($newParticipation)) {
			    		$action = $giveUp;
			    	}
			    	
			    } elseif($action == $giveUp) {
				    
			    	if($this->model('Participation')->remove($myParticipation->id)) {
			    		$action = $participate;
			    	}
			    	
			    }
			    
			    $participation = $this->model('Participation')->ofChallenge($id);
				$myParticipation = $this->model('Participation')->mineOfChallenge($id);
		    }
		
		}
	    	    
	    $this->datas = compact(
	    	'challenge',
	    	'objectives',
	    	'likes',
	    	'participation',
	    	'myParticipation',
	    	'objectivesSucceed',
	    	'participationForm',
	    	'action'
	    );
	    
	    $this->view();
	    Debug::show($this, CONTROLLER); Debug::session();
    }
}
