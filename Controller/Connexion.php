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
class Connexion extends Controller
{
	protected function __construct()
	{
		$this->styles[] = 'reset';	
		$this->styles[] = 'mikastrap';		
	}
	
	private function sendValidationEmail($name, $email, $key)
	{
		$mail = new Mail(
			'Email de test',
			'<html><head>
					<title>Bienvenue '.$name.' chez GreenHand</title>
				</head>
				<body>
					<h1>Encore un petit effort et tu seras un GreenHand</h1>
					<p>Merci <b>'.$name.'</b> de t\'être inscrit sur <a href="'.PROTOCOL.DOMAIN.BASE.'">GreenHand</a>.</p>
					<p>Pour activer ton compte et ainsi pouvoir profiter pleinement de GreenHand, il faut que tu cliques sur le lien plus bas. Ton compte n\'a besoin d\'être activé qu\'une seule fois.</p>
					<div><a href="'.PROTOCOL.DOMAIN.BASE.'connexion/validate/'.$key.'">ACTIVATION<a></div>
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
	    if(!empty($_SESSION['user']))
	    	$this->go(BASE.'accueil');

	    $this->title = "Rejoignez-nous et connectez-vous";
	    
	    $formRegister = new Form(['name' => 'register']);
		$formSignIn = new Form(['name' => 'signIn']);
	    	    
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

	    $errors = array_merge($formRegister->errors(), $formSignIn->errors());
	    
	    $this->datas = compact('formRegister', 'formSignIn', 'errors', 'confirmation');
	    
	    $this->view();
	    
	    Debug::show($this, CONTROLLER); Debug::session();
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
}
