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

	//Pour sélectionner la table de la BDD
	public $table;
	
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
				
		$this->connexion = new PDO(
			"mysql:host=".$hebergeur.";dbname=".$bdd, $login, $mdp,
			array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
			)
		);
	}

	/**
     * Requêtes MySQL générales
     *
     * Cette méthode permet d'exécuter n'importe quelle requête MySQL.
     * La requête est automatiquement préparée puis exécutée.
     * @access public
     * @param $sql Requete SQL
     * @param $preparation données préparées
     * @return La rêquete exécutée
     */			
	public function query($sql, $preparation = array()){

		$this->connexion->requetes[] = $sql;
		
		$query = $this->connexion->prepare($sql);
		$query->execute($preparation);
		
		return $query;
	}



	public function read($field = null){
		if($field == null){$field = '*';}
		$req = $this->query("SELECT $field FROM ".$this->table." WHERE id=".$this->id);
		$result = $req->fetch();
		return $result;
	}

	//inclus le fichier dont on a besoin et l'instancie
	static function load($name){
		require_once("./model/$name.php");
		return new $name();
	}


    /**
     * save function.
     * 
     * @access public
     * @param array $data
     * @return void
     */
    public function save(array $data){
        if (!empty($data["id"])) {
			
			$keys = [];
			foreach (array_keys($data) as $index => $key)
				if ($key != "id")
					$keys[$index] = $key.'=:'.$key;
            $updates = implode(', ', $keys);
                               
            $sql = "UPDATE $this->table SET $updates WHERE id=:id";

            return $this->query($sql, $data);
            
        } else {
            
            $keys = implode(', ', array_keys($data));
            $values = ':'.implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $this->table ($keys) VALUES ($values)";
                        
            return $this->query($sql, $data) ? $this->connexion->lastInsertId() : false;
        
        }
    }

    public function find($data= array()){
    	$condition = "1=1";
    	$field = "*";
    	$limit = "";
    	$order = "id DESC";
    	if(!empty($data["condition"])){
    		$condition = $data["condition"];
    	}
    	if(!empty($data["field"])){
    		$field = $data["field"];
    	}
    	if(!empty($data["limit"])){
    		$limit = "LIMIT ".$data["limit"];
    	}
    	if(!empty($data["order"])){
    		$order = $data["order"];
    	}

    	$sql = "SELECT $field FROM ".$this->table." WHERE $condition ORDER BY $order $limit";

    	$result = $this->query($sql);

    	return $result->fetchAll();
    }

    public function delete($id){
    	$sql = "DELETE FROM " .$this->table. " WHERE id=:id";

    	echo $sql;
    	$this->query($sql, array('id'=>$id));

    }
}