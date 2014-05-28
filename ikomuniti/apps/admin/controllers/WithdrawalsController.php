<?php

namespace JunMy\Admin\Controllers;

use JunMy\Components\Pagination\Pagination;
use JunMy\Models\Users;
use JunMy\Models\Withdrawals;
use JunMy\Models\Notifications;

class WithdrawalsController extends ControllerBase {
	
	public $paginationUrl; 
    
    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('Withdrawals');
        parent::initialize();
    }
    
    public function indexAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_withdraw(0));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function viewAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_user_withdraw($this->dispatcher->getParam('slug'), 0));
		
		if($this->request->isPost()) {
			if($this->request->getPost('action') == 0) {
				$this->flash->error('Please select your action');
			} elseif($this->request->getPost('action') == 1) {
				// Proceed
				if($this->action($this->dispatcher->getParam('slug'), $this->request->getPost('action'), $auth['id'], '')) {
					// Send transaction
					if($this->notification($this->request->getPost('user_id'), $this->request->getPost('reason'), $this->request->getPost('action'))) {
						$this->flashSession->success('Your request has been save');
						return $this->response->redirect("gghadmin/withdrawals/index");
					}
				}
				
			} elseif($this->request->getPost('action') == 2) {
				// Reject
				if($this->action($this->dispatcher->getParam('slug'), $this->request->getPost('action'), $auth['id'], $this->request->getPost('reason'))) {
					// Send transaction
					if($this->notification($this->request->getPost('user_id'), $this->request->getPost('reason'), $this->request->getPost('action'))) {
						$this->flashSession->success('Your request has been save');
						return $this->response->redirect("gghadmin/withdrawals/index");
					}
				}
			} 
		}
	}
	
	public function proceedAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_withdraw(1));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function approveAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_user_withdraw($this->dispatcher->getParam('slug'), 1));
		if($this->request->isPost()) {
			if($this->request->getPost('action') == 0) {
				$this->flash->error('Please select your action');
			} elseif($this->request->getPost('action') == 1) {
				// Proceed
				if($this->action($this->dispatcher->getParam('slug'), $this->request->getPost('action'), $auth['id'], '')) {
					// Send transaction
					if($this->notification($this->request->getPost('user_id'), $this->request->getPost('reason'), $this->request->getPost('action'))) {
						$this->flashSession->success('Your request has been save');
						return $this->response->redirect("gghadmin/withdrawals/index");
					}
				}
				
			} elseif($this->request->getPost('action') == 2) {
				// Reject
				if($this->action($this->dispatcher->getParam('slug'), $this->request->getPost('action'), $auth['id'], $this->request->getPost('reason'))) {
					// Send transaction
					if($this->notification($this->request->getPost('user_id'), $this->request->getPost('reason'), $this->request->getPost('action'))) {
						$this->flashSession->success('Your request has been save');
						return $this->response->redirect("gghadmin/withdrawals/index");
					}
				}
			} 
		}
	}
	
	public function rejectedAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_withdraw(2));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function successAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('withdraws', $this->view_withdraw(3));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	private function view_user_withdraw($id, $status) { 
		$phql = "SELECT
		    w.id AS w_id, w.user_id AS user_id, w.bank AS bank, w.account AS account, 
			DATE_FORMAT(w.created,'%d %b %h:%i %p') AS created, w.status AS status, w.amount AS amount,
		    u.username AS username, u.id AS u_id,
		    b.amount AS balance,
		    i.total AS total, i.next_renewal AS next_renewal, DATE_FORMAT(i.created,'%d %b %h:%i %p') AS last_renewal
		    FROM JunMy\Models\Withdrawals AS w
			INNER JOIN JunMy\Models\Users AS u ON(u.id = w.user_id)
			LEFT JOIN JunMy\Models\Wallets AS b ON(b.user_id = w.user_id) 
			LEFT JOIN JunMy\Models\Insuran AS i ON(w.user_id = i.user_id) 
			WHERE w.status = '$status' AND w.id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);	 	 

		return $rows;
	}
	
	private function view_withdraw($status) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    w.id AS w_id, w.user_id AS user_id, w.bank AS bank, w.account AS account, 
			DATE_FORMAT(w.created,'%d %b %h:%i %p') AS created, w.status AS status, w.amount AS amount,
		    u.username AS username, u.id AS u_id, 
		    b.amount AS balance
		    FROM JunMy\Models\Withdrawals AS w
			INNER JOIN JunMy\Models\Users AS u ON(u.id = w.user_id)
			LEFT JOIN JunMy\Models\Wallets AS b ON(b.user_id = w.user_id) 
			WHERE w.status = '$status' ORDER BY w.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	private function action($id, $status, $pic, $reason = NULL) {
		$update = Withdrawals::findFirst($id);
		$update->status = $status;
		$update->first_pic = $pic;
		$update->reason = $reason;
		return $update->save();
	}
	
	private function notification($user_id, $reason, $status) {
	    if($status == 1) {
			$body = 'Your withdrawal request has been process by Administrator. It may take 2 working days.';
		} elseif($status == 2) {
			$body = 'Your withdrawal request has been rejected. Reason: '.$reason;
		} elseif($status == 3) {
			$body = 'Your withdrawal request has been done.';
		}
		$notification = new Notifications(); 
		$notification->user_id = $user_id;
		$notification->body = $body;
		$notification->created = date('Y-m-d H:i:s');
		$notification->read = 0;
		$notification->type	= 4;	
		return $notification->save();
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
}