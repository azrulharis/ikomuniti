<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Components\Pagination\Pagination;
 
	
class FindController extends ControllerBase {
 
    public $paginationUrl;
    
    public function initialize() { 
        $this->tag->setTitle('Find ads');
        parent::initialize();
    }

	public function indexAction() {
	    if(filter_input(INPUT_GET, 'region', FILTER_VALIDATE_INT) && filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT)) {
	        $region_id = filter_input(INPUT_GET, 'region', FILTER_VALIDATE_INT);
	        $category_id = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
	        $query = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_ENCODED);
			// Kalau region == neighbour / entire malaysia, return session
		    // kalau empty session region_id, return 5 (kuala lumpur)
	        if($region_id == 102 || $region_id == 112) { 
				if($this->session->has("region_id")) { 
					$id = $this->session->get("region_id");
				} else {
					$id = 5;
				}
			} else {
			    // Kalau region == data table, set session
			    $this->session->set("region_id", $region_id);
				$id = $region_id;
			}
	    	//Top albums
			$phql = 'SELECT
			id,
			name
			FROM JunMy\Models\Regions
			WHERE id = '.$id.'
			LIMIT 1';
			$regions = $this->modelsManager->executeQuery($phql);
	
			
			$phql = 'SELECT
			id,
			name
			FROM JunMy\Models\Regions
	        WHERE id != '.$id.'
			LIMIT 15';
			$bottoms = $this->modelsManager->executeQuery($phql);
			
			
	
			$phql = 'SELECT 
			id, name, type
			FROM JunMy\Models\Categories 
			LIMIT 50';
			$categories = $this->modelsManager->executeQuery($phql);
			
			// Validate found cat and region
			if($category_id != 986750) {
			    if(count($this->check_cat($category_id)) != 1) {
					$this->flashSession->error('Please select valid category.');
				    return $this->response->redirect('index');	
				}
				
			}
			if($region_id != 102 || $region_id != 112) {
				/*if(count($this->check_region($region_id)) != 1) {
					$this->flashSession->error('Please select valid region.');
					return $this->response->redirect('index');
				}	*/ 
			}
			
			// Set back url
		    $_SESSION['back_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  
			
			// Set view for top region
			$this->view->setVar('tops', $regions);
		    
		    // Set view for region
		    $this->view->setVar('regions', $bottoms);
		    
		    // Set view for categories
		    $this->view->setVar('categories', $categories);
		    
		    // Set view for selected option
		    $this->view->region_id = $region_id;
		    $this->view->cat_id = $category_id;
		    $this->view->query = $_GET['title'];
		    
		    // Ikomuniti dashboard
		    $this->view->ikomuniti_dir = $this->ikomuniti_dir();
		    
		    // Thumb dir
		    $this->view->imall_thumb_image_dir = $this->thumb_image_dir();
		    
		    // Sponsor ads
		    $this->view->setVar('sponsors', $this->sponsor_ads());
		    
		    // Thumb dir
		    $this->view->sponsor_image_dir = $this->imall_image_dir();
		    
		    // View ads
		    $this->view->setVar('posts', $this->view_ads());
		    
		} else {
			$this->flashSession->error('Please select valid region.');
			return $this->response->redirect('index');
		}
	    $this->view->paginationUrl = $this->paginationUrl;
	}
	


    /*
	*  Select ads listing on index
	*/
	private function view_ads() { 
		$records_per_page = 15;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		    p.id AS id, p.title AS title, SUBSTRING(p.description, 1, 120) AS body, 
			DATE_FORMAT(p.created, '%d %b %h:%i %p') AS created, p.location AS location, 
			p.url AS slug, p.price AS price,
		    c.name AS category, c.id AS cat_id,
		    r.name AS region, r.id AS reg_id,
		    i.image_name AS image
			FROM JunMy\Models\Posts AS p
			LEFT JOIN JunMy\Models\Postimages AS i ON(i.post_id = p.id) 
			LEFT JOIN JunMy\Models\Regions AS r ON(p.region_id = r.id)
			LEFT JOIN JunMy\Models\Categories AS c ON(p.category_id = c.id)
			WHERE p.status = '2' AND ".$this->getCategory(filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT))."
			". $this->get_query(filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING)). 
			$this->getRegion(filter_input(INPUT_GET, 'region', FILTER_VALIDATE_INT))."
			GROUP BY p.id ORDER BY p.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        
        $paginations->records_per_page($records_per_page); 
        $this->paginationUrl = $paginations->render();
         
        return $rows; 
	}
	
	    /*
	*  Select ads listing on index
	*/
	private function sponsor_ads() {  
	 
		$phql = "SELECT 
		    p.id AS id, p.title AS title, SUBSTRING(p.description, 1, 120) AS body, p.user_id AS user_id, 
			p.region_id AS region_id, p.category_id AS category_id, DATE_FORMAT(p.created, '%d %b %h:%i %p') AS created,
			p.url AS slug, p.price AS price,
		    c.name AS category, c.id AS cat_id,
		    r.name AS region, r.id AS reg_id,
		    i.image_name AS image
			FROM JunMy\Models\Posts AS p
			LEFT JOIN JunMy\Models\Postimages AS i ON(i.post_id = p.id) 
			LEFT JOIN JunMy\Models\Regions AS r ON(p.region_id = r.id)
			LEFT JOIN JunMy\Models\Categories AS c ON(p.category_id = c.id)
			WHERE ".$this->getCategory(filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT))."
			AND p.status = '1' GROUP BY p.id ORDER BY p.id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);	 
         
        return $rows; 
	}
	
	public function getRegion($id) {
	    		
		if($id == 102) {
			return " AND p.region_id > 0";
		} elseif($id == 112) {
		    $phql = "SELECT 
			neighbourhood
			FROM JunMy\Models\Regions 
			WHERE id = ".
			    ($this->session->has("region_id") ? $this->session->get("region_id") : '5')
				." LIMIT 1";
			$regions = $this->modelsManager->executeQuery($phql);
		    
		    foreach($regions as $in) {
				return " AND p.region_id IN (".$in['neighbourhood'].")";
			}
			
		} else {
			return " AND p.region_id = '$id'";
		}
	} 
	
	private function get_query($query) {
		if(!empty($query)) {
			return " AND p.title LIKE '%$query%' OR p.description LIKE '%$query%' ";
		}
	}
	
	public function getCategory($id) {
		if($id == 986750) {
			return "p.category_id > '0'";
		} elseif($id == '') {
			return "p.category_id > '0'";
		} else {
			return "p.category_id = '$id'";
		}
	}
    
    private function check_cat($id) {
		$phql = 'SELECT 
			id
			FROM JunMy\Models\Categories 
			WHERE id = :id: LIMIT 1';
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;
	}
	
	private function check_region($id) {
		$phql = 'SELECT 
			id
			FROM JunMy\Models\Regions 
			WHERE id = :id: LIMIT 1';
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;
	}

}

