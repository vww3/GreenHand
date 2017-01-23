<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
Use System\Str;
Use System\Crypt;
Use System\Debug;
Use System\Image;

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
	    
        $this->styles[] = 'base';
        $this->styles[] = 'reset';
        $this->styles[] = 'accueil';
        $this->styles[] = 'responsive';       
		$this->title = 'Tableau de bord - Liste des défis';
        /*if (
            empty($_SESSION['administrateur']) OR 
            $_SESSION['administrateur'] != true
        )
            $this->go(BASE);*/
    }
    
    private function sendValidationEmail($name, $email, $key)
	{
		$mail = new Mail(
			'Email de test',
			'<html>
				<head>
					<title>Bienvenue '.$name.' chez GreenHand</title>
				</head>
				<body>
					<h1>Encore un petit effort et tu seras un GreenHand</h1>
					<p>Merci <b>'.$name.'</b> de t\'être inscrit sur <a href="'.PROTOCOL.DOMAIN.BASE.'">GreenHand</a>.</p>
					<p>Pour activer ton compte et ainsi pouvoir profiter pleinement de GreenHand, il faut que tu cliques sur le lien plus bas. Ton compte n\'a besoin d\'être activé qu\'une seule fois.</p>
					<div><a href="'.PROTOCOL.DOMAIN.BASE.'validate/'.$key.'">ACTIVATION<a></div>
					<p>Amuse-toi bien et à bientôt sur notre site</p>
					<p><i>-- Emma Louviot & Mickaël Boidin, fondateurs de GreendHand</i></p>
				</body>
			</html>',
			'GreenHand <no-reply@greenhand.fr>'
		);
		$mail->send($name.' <'.$email.'>');
		
		//Debug::show($mail);
	}

    /**
     * index function.
     * 
     * @access public
     * @return void
     */
    public function index()
    {	   
	    $formSignIn = new Form(['name' => 'signIn']);
	    
	    if($formSignIn->posted()) {
		    
		    $datas = $formSignIn->datas();
		    
		    $formSignIn->verify(empty($datas['email'])		, 'Veuillez renseigner votre email pour vous identifier');
		    $formSignIn->verify(empty($datas['password'])	, 'Veuillez renseigner votre mot de passe pour vous identifier');
		    
		    if($formSignIn->noErrors()) {
			    $cryptedPass = Crypt::encrypt($datas['password']);
				$user = $this->model('Users')->connexion($datas['email'], $cryptedPass);
			    
			    $formSignIn->verify(empty($user)			, 'Identification impossible, essaie à nouveau.');
			    
			    if($formSignIn->noErrors())
			    	$formSignIn->verify($user->valid == 0	, 'Votre compte doit être activé');
			    
			    if($formSignIn->noErrors()) {
					$_SESSION['user'] = $user;
					
					$parameters = func_get_args();
					$redirection = empty($parameters) ? BASE.'accueil' : BASE.implode('/', $parameters);
					
					$this->go($redirection);
				}
		    }
	    }
	    
	    $formErrors = $formSignIn->errors();
	     	    
	    $challenges = $this->model('Challenge')->getAll();
		$profil = null;
	    $notifications = $this->model('Notification')->ofCurrentUser();
	    
	    if(!empty($_SESSION['user'])) {
		    $profil = $this->model('Profil')->ofUser($_SESSION['user']->id);
		    $profilForm = new Form(['name' => 'profil', 'datas' => (array)$profil]);
			    
		    if($profilForm->posted()) {
			    $datas = $profilForm->datas();
			    if(!empty($profil))
			    	$datas['id'] = $profil->id;
			    $datas['user'] = $_SESSION['user']->id;
			    $this->model('Profil')->save($datas);
			    
			    if($profilForm->downloadable('photo')) {
				    $profilImageFolder = IMAGE.'profil/';
				    $profilImageName = $_SESSION['user']->id.'.jpg';
				    
				    $profilForm->download('photo', $profilImageFolder, $profilImageName);
				    
				    $photo = new Image(ROOT.$profilImageFolder.$profilImageName);
				    $photo->createThumb(350, 350);
				    
				    $profil->photo = $profilImageFolder.$profilImageName;
			    }
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
	    
	    $this->datas = compact('challenges', 'profil', 'notifications', 'profilForm', 'myChallengeParticipations', 'formSignIn', 'formErrors');
	    
        $this->view();
    }
    
    public function inscription()
    {
	    if(!empty($_SESSION['user']))
	    	$this->go(BASE.'accueil');
	    
	    $formRegister = new Form(['name' => 'register']);
	    	    
	    if($formRegister->posted()) {
		    
		    $datas = $formRegister->datas('name', 'email', 'password');
		    $copyPassword = $formRegister->datas('verifyPassword');
		    $emailIsAvailable = $this->model('Users')->isAvailableEmail($datas['email']);
		    		    
		    $formRegister->verify(empty($datas['name'])								, 'Veuillez renseigner votre nom pour vous enregistrer');
		    $formRegister->verify(!Str::isEmail($datas['email'])					, 'Veuillez renseigner un email conforme');
		    $formRegister->verify(!$emailIsAvailable								, 'Cette adresse e-mail est déjà prise');
		    $formRegister->verify(Str::length($datas['password']) <= 5				, 'Veuillez renseigner votre mot de passe d\'au moins 6 caractères pour vous enregistrer');
		    $formRegister->verify(!Str::isSame($datas['password'], $copyPassword)	, 'Veuillez copier correctement votre mot de passe');
			
		    if($formRegister->noErrors()) {
			    $datas['password'] = Crypt::encrypt($datas['password']);
			    $datas['validationKey'] = md5(uniqid());
			    
				$this->model('Users')->save($datas);
				$this->sendValidationEmail($datas['name'], $datas['email'], $datas['validationKey']);
				
				$confirmation = 'Bienvenue à toi cher '.$datas['name'].', afin de confirmer ton inscription, un e-mail avec un lien d\'activation viens de t\être envoyé.';			
			}
	    }
	    
	    $formErrors = $formRegister->errors();
	    
	    $this->datas = compact('formRegister','formErrors');
	    
	    $this->view();
    }
    
    public function validate($key = null)
    {
	    if($key == null)
	    	$this->go(PREVIOUS);
	    	
	    $user = $this->model('Users')->whoHasKey($key);
	    
	    if(empty($user) OR $user->valid == 1)
	    	$this->go(PREVIOUS);
	    
	    $this->model('Users')->validate($user->id);
	    
	    $this->title = "Validation de votre compte $user->name";
	    
	    $this->view();
    }
        
    public function byebye()
    {
	    session_destroy();
	    $this->go(BASE);
    }

    public function presentation(){
    	$this->view();
    }
}
