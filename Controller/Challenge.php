<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
use System\Crypt;
use System\Debug;
use System\Str;
use System\Mail;

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
	    
	    $objectives = $this->model('Objective')->ofChallenge($id);
	    $likes = $this->model('Like')->ofChallenge($id);
	    $participation = $this->model('Participation')->ofChallenge($id);
	    
	    $this->datas = compact('challenge', 'objectives', 'likes', 'participation', 'objectivesSucceed');
	    
	    Debug::show($this, CONTROLLER); Debug::session();
    }
}
