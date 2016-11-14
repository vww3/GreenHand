<?php

use \PDO;

/**
 * Modèle - Classe PHP de liaison entre le site et la base de données.
 *
 * Cette classe contient les fonctions basiques permettant aux modèles de gérer
 * l'accès à la base de données. Chaque modèle est dédiée à une table spécifique
 * Cette classe a été conçu pour être hérité par un mdoèle présent dans le dossier
 * MODELE (voir fichier de configuration à la racine du site).
 * Cette classe gère les connexions à plusieurs base de données (chaque modèle à sa connexion)
 * Le moyen le plus efficace pour instancier et utiliser les modèles est de passer par
 * la méthode modele() du controleur principale. Cette méthode gère automatiquement
 * l'existance et l'exploitation du modèle demandé.
 *
 * @package Iron
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 * @note Les propriétés et méthodes de cette classes doivent être privées (sauf le constructeur)
 * @see Controleur::modele()
 */

class Model{	
	//Objet PDO de connexion à la base de données.
	private $connexion;
	
	/**
     * Constructeur principal
     *
     * Se charge d'initialiser la connexion à la base de donnée en instanciant un objet PDO
     * qui est sauvegardé dans la propriété privée $connexion. Par soucis de compatibilité
     * et d'efficacité, la connexion se base sur l'encodage UTF-8 et utilise un mode de retour
     * par objet standard (classe Std). Un mode d'erreur par exception permet de stopper
     * toute manipulation illégale.
     * @access public
     * @param $bdd Base de donnée où se connecter
     * @param $login Login de connexion à la BDD
     * @param $mdp Mot de passe de connexion à la BDD
     * @param $hebergeur Adresse de l'hébergeur de la BDD
     */
	public function __construct($bdd, $login, $mdp, $hebergeur){
			
		try{
			
			$this->connexion = new PDO(
				"mysql:host=".$hebergeur.";dbname=".$bdd, $login, $mdp,
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
				)
			);
			
		}catch(Exception $erreur){
			
			die('ERREUR DE CONNEXION : '.$erreur->getMessage());
			
		}
		
	}
}