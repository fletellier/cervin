<?php
namespace Admin\Model;

use DataTable\Model\DataTable;

/**
 * Extension de la classe Datatable pour gérer les logs
 */
class LogsDataTable extends DataTable
{
	/**
	 * Permet de compléter la configuration
	 *
	 * Permet de compléter la configuration de l'objet Datatable si
	 * elle est manquante et retourne cet objet au format JSON
	 *
	 * @return \DataTable\Model\json Objet au format JSON
	 */
	public function findAll()
	{
	    if (! $this->getConfiguration()) {
	        $configuration = array(
    				'action',
    				'loggedAt',
    				'objectClass',
    				'objectId',
    				'version',
    				'username'
	        );
	        $this->setConfiguration($configuration);
        }	        
		if (! $this->getAaData()) {
		    $aaData = array();
		    foreach ($this->getPaginator() as $log) {
			    $data = array(
                    $log->getAction(),
                    $log->getLoggedAt(),
                    $log->getObjectClass(),
                    $log->getObjectId(),
                    $log->getVersion(),
                    $log->getUsername()
			    );
			    $aaData[] = $data;
		    }
		    $this->setAaData($aaData);
		}
		return $this->getJson();
	}
	


	/**
	 * Effectue une recherche multi-critères
	 *
	 * Récupère les conditions passées en paramètres pour construire
	 * une requête permettant de récupérer les informations pour la
	 * Datatable. 
	 *
	 * @param array  $conditions Tableau de conditions
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator Résultats paginés
	 */
	public function getPaginator($conditions = null)
	{
		if (! $this->paginator) {
			$entityManager = $this->getEntityManager();
	
			$alias = 'entity';
				
			$query = $entityManager->createQueryBuilder($alias);

			if(isset($conditions)){
				
				//Tableau de types autorisés
				$allowedType = array("action", "loggedAt", "objectClass", "objectId", "username", "version");

				$arrayOfType = array();
				$arrayOfTe = array();

				//On traite les éléments passés en POST
				foreach ($conditions as $condition) {
					//Vérifie que le type est bien autorisé
					if(in_array($condition["type"], $allowedType)) {
						//On ajoute le type dans le tableau et on ajoute la valeur dans un sous tableau
						$arrayOfType[$condition["type"]][] = $condition["value"];
					}
				}

				$andX = $query->expr()->andX();

				//On traite chaque type
				foreach($arrayOfType as $key => $type){
					
					$requete = "eq";

					$key = $alias.'.'.$key;

					//Si il y a plus de 1 valeur pour un type, on les ajoute au tableau de OR
					if( count($type) > 1 ){

						$orX = $query->expr()->orX();
						
						foreach($type as $value){
							if($requete === "like"){ $value = '%'.$value.'%'; }
							
							$orX->add($query->expr()->$requete( $key,  $query->expr()->literal($value) ));
						}
						
						$andX->add($orX);
						
					//Sinon on les ajoute au tableau de AND
					} else {
						if($requete === "like"){ $type[0] = '%'.$type[0].'%'; }
						
						$andX->add($query->expr()->$requete( $key,  $query->expr()->literal($type[0]) ));
						
					}
				}

				//Si $andX est vide, il contient son initialisation
				if( $andX != $query->expr()->andX() ){
					$query->add('where', $andX);
				}

			}

			$query
			//->orderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  $this->sSortDir_0)
		    //->addOrderBy("{$alias}.{$this->configuration[$this->iSortCol_0]}",  strtoupper($this->sSortDir_0))
			//->add("orderBy", "{$alias}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}")
			->setFirstResult($this->getPage())
			->setMaxResults($this->getDisplayLength());

			$iSortCol_0 = !isset($this->iSortCol_0) ? 0 : $this->iSortCol_0;

			$query->add("orderBy", "{$alias}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}");

			//var_dump($query->getQuery()->getSQL());
			
			$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

			$this->setTotalRecords($paginator->count());
			$this->setTotalDisplayRecords($paginator->count());
	
			$this->paginator = $paginator;
		}
	
		return $this->paginator;
	}
	
}
