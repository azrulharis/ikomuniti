<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Insurancerequests;
use JunMy\Models\Insuran;
use JunMy\Models\Notifications;
class ItakafulController extends ControllerBase {
	
	public $due;
	
	public function initialize() {
	    $this->view->setTemplateAfter('main');
		$this->tag->setTitle('iTakaful informations');
		parent::initialize();
	}
	
    public function indexAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('jun_user_auth'); 
		 
	    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		$this->view->setVar('insurances', $this->get_user_insuran($auth['id'])); 
	
		if($this->request->isPost()) {  
		    //print_r($_POST);
		    $id = $auth['id'];
		    $insuran = Insuran::findFirst("user_id = '$id'");
		    $cover = $insuran->cover;
		    $pic = $insuran->pic; 
			$minimum = $cover / 100 * 80;
			if($insuran->insurance == 0.00) {
			    if($this->request->getPost('sum') != 0.00) {
					$this->flash->error('You are not allow to modify. Please call iShare Takaful Department to update your Sum Insured value');
				} elseif($this->request->getPost('sum') != 0) {
					$this->flash->error('You are not allow to modify CRP. Please call iShare Takaful Department to update your Sum Insured value');
				} elseif($this->request->getPost('windscreen') < 300) {
					$this->flash->error('Minimum sum insured is RM300');
				} else {
				    $cover = 0.00;
				    $windscreen = $this->request->getPost('windscreen');
				    $pa = $this->request->getPost('pa');
				    $crp = 0.00;
				    $driver = $this->request->getPost('driver');
				    $second = $this->request->getPost('2driver');
				    $third = $this->request->getPost('3driver');
				    $fourth = $this->request->getPost('4driver');
				    $sec = ($driver != ''?$driver:'').($second!=''? ', '.$second:'').($third!=''? ', '.$third:'').($fourth!=''? ', '.$fourth:'');
					if(substr($sec, 0,1) == ',') {
					    $this->flash->error('Please add first field on additional driver');	
					} else {
					    $data = explode(",", $sec);
						$result = count($data);
						$total = $result - 1;
						$driver_total = $total * 10;
						
						if($this->update_insurance($id, $windscreen, $crp, $pa, $sec, $driver_total)) {
							if($this->insert_request($id, $windscreen, $crp, $sec, $cover)) {
							    $this->update_notification($auth['username'], $pic);
								$this->flashSession->success('Your request has been saved'); 
								return $this->response->redirect('itakaful/index');	
							}
						}	
					} 
				} 
			} else {
			    if($this->request->getPost('sum') < $minimum) {
					$this->flash->error('Amount is below Sum Insured regulation. Only 20% below vehicle market price permitted');
				} elseif($this->request->getPost('sum') > $cover) {
					$this->flash->error('Amount is above Sum Insured regulation. Only 20% below vehicle market price permitted');
				} elseif($this->request->getPost('windscreen') < 300) {
					$this->flash->error('Minimum sum insured is RM300');
				} else {
					$cover = $this->request->getPost('sum');
				    $windscreen = $this->request->getPost('windscreen');
				    $pa = $this->request->getPost('pa');
				    $crp = $this->request->getPost('crp');
				    $driver = $this->request->getPost('driver');
				    $second = $this->request->getPost('2driver');
				    $third = $this->request->getPost('3driver');
				    $fourth = $this->request->getPost('4driver');
				    $sec = ($driver != ''?$driver:'').($second!=''? ', '.$second:'').($third!=''? ', '.$third:'').($fourth!=''? ', '.$fourth:'');
				    if(substr($sec, 0,1) == ',') {
					    $this->flash->error('Please add first field on additional driver');	
					} else {
					    $data = explode(",", $sec);
						$result = count($data);
						$total = $result - 1;
						$driver_total = $total * 10;
						if($this->update_insurance($id, $windscreen, $crp, $pa, $sec, $driver_total)) {
						    if($this->insert_request($id, $windscreen, $crp, $sec, $cover)) {
						     
						        $this->update_notification($auth['username'], $pic);
						        
								$this->flashSession->success('Your request has been saved');
								return $this->response->redirect('itakaful/index');	
							} 
						}	
					}
					/*echo $sec;*/
					
				}  
			}
		    
		}
	}
	
	/*
	*  Send notification after UPDATEw, used on updateAction
	*/
	private function update_notification($username, $pic) {
		//Send SMS	& notification
	    $note = new Notifications();
	    $note->user_id = $pic; // Miza
	    $note->body = "$username has made change insurance amount. Please review this change. URGENT!";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 18;
	    return $note->save();
	}
	
	private function update_insurance($id, $windscreen, $crp, $pa, $driver, $driver_total) {
		$insuran = Insuran::findFirst("user_id = '$id'"); 
		$insuran->wind_screen = $windscreen;
		$insuran->crp = $crp;
		$insuran->pa = $pa;
		$insuran->second_driver = $driver;
		$insuran->driver_total = $driver_total;
		if($insuran->save()) {
			return true;
		} else {
		    foreach($insuran->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
		}
	}
	
	private function insert_request($user_id, $windscreen, $crp, $second, $cover) {
		$data = new Insurancerequests();
		$data->user_id = $user_id;
		$data->windscreen = $this->ternary($windscreen);
		$data->crp = $this->ternary($crp);
		$data->additional_driver = $this->ternary($second);
		$data->created = date('Y-m-d H:i:s');
		$data->status = 0;
		$data->cover = $cover;
		return $data->save();
	}
	
	private function ternary($data) {
		$data = ($data != '' ? $data : 0);
		return $data;
	}
	
    private function get_user_insuran($id) {
	    $phql = "SELECT * FROM JunMy\Models\Insuran WHERE user_id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
	 
		return $rows;
	}
	
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	private function count_user($id) {
	    $phql = "SELECT username FROM JunMy\Models\Users WHERE username = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		
		return count($rows);
	}
	
	 
}