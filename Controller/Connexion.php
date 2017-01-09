<?php
namespace Controller;

use System\Core\Controller;
use System\Helper\Form;
use System\Crypt;
use System\Debug;
use System\Str;

/**
 * connexion class.
 */
class Connexion extends Controller
{
	protected function __construct()
	{
		$this->styles[] = 'mikastrap';		
	}
	
    /**
     * index function.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
	    $this->title = "Rejoignez-nous et connectez-vous";
	    
	    $formRegister = new Form(['name' => 'register']);
		$formSignIn = new Form(['name' => 'signIn']);
	    
	    if($formRegister->posted()) {
		    
		    $datas = $formRegister->datas('name', 'email', 'password');
		    $copyPassword = $formRegister->datas('verifyPassword');
		    
		    $formRegister->verify(empty($datas['name'])								, 'Veuillez renseigner votre nom pour vous enregistrer');
		    $formRegister->verify(!Str::isEmail($datas['email'])					, 'Veuillez renseigner un email conforme');
		    $formRegister->verify(!Str::length($datas['password']) > 5				, 'Veuillez renseigner votre mot de passe d\'au moins 6 caractères pour vous enregistrer');
		    $formRegister->verify(!Str::isSame($datas['password'], $copyPassword)	, 'Veuillez copier correctement votre mot de passe');

		    if($formRegister->noErrors()) {
			    $datas['password'] = Crypt::encrypt($datas['password']);
			    $datas['validationKey'] = md5(uniqid());
			    
				$this->model('Users')->save($datas);
			}
	    }
	    
	    if($formSignIn->posted()) {
		    
		    $datas = $formSignIn->datas();
		    
		    $formSignIn->verify(empty($datas['email'])		, 'Veuillez renseigner votre email pour vous identifier');
		    $formSignIn->verify(empty($datas['password'])	, 'Veuillez renseigner votre mot de passe pour vous identifier');
		    
		    if($formSignIn->noErrors()) {
				$user = $this->model('Users')->connexion(
			    	$datas['email'],
			    	Crypt::encrypt($datas['password'])
			    );
			    
			    $formSignIn->verify(empty($user)			, 'Le email ou le mot de passe est erroné');
			    
			    if($formSignIn->noErrors())
			    	$formSignIn->verify($user->valid == 0	, 'Votre compte doit être activé');
			    
			    if($formSignIn->noErrors()) {
					$_SESSION['user'] = $user;
					
					//$this->go(PREVIOUS);
				}
		    }
	    }
	    
	    $errors = array_merge($formRegister->errors(), $formSignIn->errors());
	    
	    $this->datas = compact('formRegister', 'formSignIn', 'errors');
	    
	    $this->view();
	    
	    Debug::session();
    }
    
    public function validate($key = null)
    {
	    if($key == null)
	    	$this->go(PREVIOUS);
	    	
	    $user = $this->model('Users')->whoHasKey($key);
	    
	    if(!empty($user)) {
		    $this->model('Users')->validate($user->id);
		    
		    $this->title = "Validation de votre compte $user->name";
		    
		    $this->view();
	    }	    
    }
    
    public function byebye()
    {
	    session_destroy();
	    $this->go(PREVIOUS);
    }
}
