<?php
namespace Admin\Model;

use DataTable\Model\DataTable;

/**
 * UserDataTable
 *
 * Classe responsável por fazer com que seja possível trabalhar com o plugin 
 * DataTables junto com o ORM Doctrine para efetuar paginações.
 *
 * Neste caso, utilizando as regras específicas para a entidade Product.
 *
 * @author  Thiago Pelizoni <thiago.pelizoni@gmail.com>
 */
class UserDataTable extends DataTable
{
	public function findAll()
	{
	    if (! $this->getConfiguration()) {
	        // Este array deve ser na ordem das colunas da listagem
	        $configuration = array(
	            'id',
	            'username',
	            'displayName',
	            'email',
	            'roles',
	        );
	        $this->setConfiguration($configuration);
        }	        
	    
	    /**
	     * Irá montar os dados que serão exibidos no DataTable
	     *
	     * Neste tutorial, a sequencia da listagem está sendo: 'id', 'name', 'description'.
	     * Desta forma, o array que será atribuido a variável DataTable::aaData deve estar
	     * na mesma sequencia.
	     */  
		if (! $this->getAaData()) {
		    $aaData = array();
		    
		    foreach ($this->getPaginator() as $user) {
			    $data = array(
				    $user->id,
                    $user->username,
                    $user->displayName,
                    $user->email,
                    '<span class="label label-important">'.$user->roles['0']->getRoleId().'</span>',
                    '<a href="#" class="status" data-type="select" data-pk="1" data-url="/post" data-original-title="Select status">dd</a>',
			    );
			
			    $aaData[] = $data;
		    }
		
		    $this->setAaData($aaData);
		}
		
		return $this->getJson();
	}
	
	/**
	 * Récupère les données pour la Datatable
	 *
	 * Récupère les conditions présentes dans l'objet pour construire
	 * une requête permettant de récupérer les informations pour la
	 * Datatable.
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator Résultats paginés
	 */
	public function getPaginator()
	{
		if (! $this->paginator) {
			$entityManager = $this->getEntityManager();
	
			$alias = 'entity';
			$alias_type = 'r';
						
			$query = $entityManager->createQueryBuilder($alias)
			                       ->leftJoin($alias.'.roles', $alias_type)
			                       ->addSelect($alias_type)
								   ->setFirstResult($this->getPage())
								   ->setMaxResults($this->getDisplayLength());
			
			$iSortCol_0 = !isset($this->iSortCol_0) ? 0 : $this->iSortCol_0;
			
			if( $this->configuration[$iSortCol_0] == 'roleId' ){
				$query->add("orderBy", "{$alias_type}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}");
			} else {
				$query->add("orderBy", "{$alias}.{$this->configuration[$iSortCol_0]} {$this->sSortDir_0}");
			}
			
			if ($this->getSSearch() != null) {
				$sSearch = strtoupper($this->getSSearch());
				$sSearch = preg_replace('/[^[:ascii:]]/', '%', $sSearch);
				$sSearch = preg_replace('/[%]{1,}/', '%', $sSearch);
				$sSearch = '%'.$sSearch.'%';

				$this->setSSearch($sSearch);
				
				$orX = $query->expr()->orX();
				
				for ($i = 0; $i < 3; $i++) {

					$column = $this->configuration[$i];
					
					$al = $column != 'roleId' ? $alias : $alias_type;
					
					$orX->add($query->expr()->like( $query->expr()->upper("{$al}.{$column}"), $query->expr()->literal($this->getSSearch()) ));
					//$query
					//->orWhere("UPPER({$alias}.{$column}) LIKE {$query->expr()->literal($this->getSSearch())}");
					//->add("orWhere", "UPPER({$alias}.{$column}) LIKE {$query->expr()->literal($this->getSSearch())}")
					//->orWhere( $query->expr()->like( $query->expr()->upper("{$alias}.{$column}"), $query->expr()->literal($this->getSSearch()) ));
				}
				
				$query->add('where', $orX);
			}
	
			$paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
	
			$this->setTotalRecords($paginator->count());
			$this->setTotalDisplayRecords($paginator->count());
	
			$this->paginator = $paginator;
		}
	
		return $this->paginator;
	}
	
}
