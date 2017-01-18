<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
Use System\Str;
Use System\Debug;

use DateTime;

/**
 * accueil class.
 */
class Accueil extends Controller
{
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    protected function __construct()
    {  
	    parent::__construct();
	    
        $this->styles[] = 'accueil';
         $this->styles[] = 'responsive';          
		$this->title = 'Tableau de bord - Liste des défis';
        /*if (
            empty($_SESSION['administrateur']) OR 
            $_SESSION['administrateur'] != true
        )
            $this->go(BASE);*/
    }

    /**
     * index function.
     * 
     * @access public
     * @return void
     */
    public function index()
    {	    	    
	    $challenges = $this->model('Challenge')->getAll();
		$profil = $this->model('Profil')->ofCurrentUser();
	    $notifications = $this->model('Notification')->ofCurrentUser();
	    
	    if(!empty($_SESSION['user'])) {
		    $profilForm = new Form(['name' => 'profil', 'datas' => (array)$profil]);
			    
		    if($profilForm->posted()) {
			    $datas = $profilForm->datas();
			    if(!empty($profil))
			    	$datas['id'] = $profil->id;
			    $datas['user'] = $_SESSION['user']->id;
			    $this->model('Profil')->save($datas);
		    }
		    
		    $myChallengeParticipations = $this->model('Participation')->myChallenges();
	    }
	    
	    if(!empty($profil)) {		    
		    $profil->birth = Str::date($profil->birth);
		}
	    	    
	    foreach($challenges as $row => $challenge) {		    
		    $challenges[$row]->slug = Str::simplify($challenges[$row]->title);
		    $challenges[$row]->dateCreation = Str::date($challenges[$row]->dateCreation);
		    
		    if(!empty($challenges[$row]->dateEnd)) {
			    $now = new DateTime();
			    $end = new DateTime($challenges[$row]->dateEnd);
			    $challenges[$row]->avaiable = $now < $end;
		    	$challenges[$row]->dateEnd = Str::date($challenges[$row]->dateEnd);
		    } else 
		    	$challenges[$row]->avaiable = true;
	    }
	    
	    $this->datas = compact('challenges', 'profil', 'notifications', 'profilForm', 'myChallengeParticipations');
	    
        $this->view();
        Debug::multi($this, $_SESSION);
    }
}
