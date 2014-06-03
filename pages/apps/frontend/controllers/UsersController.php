<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Hits; 
use JunMy\Models\Wallets;
use JunMy\Models\Insuran; 
use JunMy\Models\Passwordrequests; 

class UsersController extends ControllerBase {
	
	public $form;
	
	public $jun_error = array();
	
	public $due;
	
	public $salt_length = 9;
	
	public function initialize() { 
		$this->tag->setTitle('iShare Registration');
		parent::initialize();
	}
	 
    public function successAction() {
        $this->flashSession->output();
		$downline_id = $this->dispatcher->getParam('id');
		$param = $this->dispatcher->getParam('param');
		$ref = $this->dispatcher->getParam('ref'); 
		// Check if session has set and user_id is numeric
		if($this->session->has('TOKENREGISTER') && is_numeric($downline_id) && is_numeric($ref)) {
		    // Check if token same as session
			if($this->session->get('TOKENREGISTER') == $param) {
				if($ref == 1 && isset($_COOKIE['ref_key'])) {
					$ref_key = $_COOKIE['ref_key'];
					$referral_username = $_COOKIE['referral_username'];
					$ref_id = $_COOKIE['ref_id'];
					$user = Users::findFirst($downline_id);
					if($user->username_sponsor == $referral_username) { 
					    $hits = Hits::findFirst("ref_key = '$ref_key' AND username = '$referral_username'"); 
					    if($hits->status == 0 && $hits->downline_id == 0) {
							$hits->status = 1;
						    $hits->downline_id = $downline_id;
						    
						    if(!$hits->save()) { 
								foreach ($hits->getMessages() as $message) {
					                $this->flash->error((string) $message);
					            }
							}  	
						} 
					} 
				  } 
				
			} else {
				$this->flashSession->error('Token tidak sah');
				return $this->response->redirect('register');
			}
		} else {
			$this->flashSession->error('Token tidak sah');
			return $this->response->redirect('register');
		} 
		$this->flash->success('Pendaftaran telah berjaya, Sila hubungi iReseller kami untuk menaik taraf akaun.');
		unset($_SESSION['TOKENREGISTER']);
		
	}
	
	private function generate($length = 8) {
		$password = "";
		$possible = "N1CD4GHEQRST5FK2Z3JAW4XB7Y8LMP6U9VAFGY52RJEU73856U87T3YD64ET49RH65U79Y5W9U656UH5T65W";  
		$i = 0; 
		while ($i < $length) { 
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
			if (!strstr($password, $char)) { 
			  $password .= $char;
			  $i++;
			} 
		} 
		return $password; 
	}
	 
	 
	
	public function display($value) {
        if(isset($_POST['submit'])) {
		    if(isset($this->jun_error[$value])) {
			    echo '<span class="alert-dismissable alert-danger">'.$this->jun_error[$value].'</span>'; 
		    }			
		}
    }
	

    
    public function registerAction() { 
        $this->flashSession->output();  
        $this->view->ajax_username = $this->url->get('ajax/ajaxusername'); 
        $this->view->ajax_sponsor_username = $this->url->get('ajax/sponsorusername'); 
        if($this->session->has('jun_user_auth')) {
            $auth = $this->session->get('jun_user_auth'); 
		}
        if($this->request->isPost()) { 
         
            //echo $this->request->getPost('role');
            
			$this->rules(array(
				'username_sponsor' => array('check_upline' => array('table' => 'users', 'field' => 'username', 'error' => 'Username tidak wujud')),
				'role' => array('not_empty' => 'Sila pilih jenis akaun'),
				
				'username' => array('between' => array('min' => 6, 'max' => 18, 'error' => 'ID Pengguna 6 hingga 18 karakter'),
				                    'is_uniq' => array('table' => 'users', 'field' => 'username', 'error' => 'Username telah didaftarkan'),
									'alphanumeric' => 'ID Pengguna tidak sah A-Z, a-z, 0-9 sahaja'),
				'name' => array('not_empty' => 'Sila isi nama penuh'), 
				'password' => array('between' => array('min' => 5, 'max' => 18, 'error' => 'Kata laluan 5 hingga 18 aksara')), 
				'retype_password' => array('equal_to' => 'password', 'error' => 'Kata laluan tidak sepadan'),
				'nric_new' => array('alphanumeric' => 'Simbol tidak dibenarkan',
				                    'between' => array('min' => 6, 'max' => 13, 'error' => 'No K/P tidak sah')),
				'occupation' => array('not_empty' => 'Pekerjaan wajib diisi'),
				'kin_name' => array('not_empty' => 'Nama waris wajib diisi'),
				'relation' => array('not_empty' => 'Hubungan dengan waris wajib diisi'),
				'kin_phone' => array('numeric' => 'Nombor sahaja contoh: 0121234567',
				                    'between' => array('min' => 9, 'max' => 12, 'error' => 'Nombor telefon 10 - 12 digit')), 
				'nric_new_kin' => array('numeric' => 'No K/P tidak sah, Sila masukkan nombor sahaja',
				                 'between' => array('min' => 11, 'max' => 13, 'error' => 'No K/P tidak sah')), 
				'address' => array('not_empty' => 'Alamat wajib diisi'),
				'second_address' => array('not_empty' => 'Alamat kedua wajib diisi'), 
				
				'postcode' => array('numeric' => 'Sila masukkan nombor sahaja',
				                    'between' => array('min' => 4, 'max' => 6, 'error' => 'Poskod tidak sah')),
				'city' => array('not_empty' => 'Daerah wajib diisi'),
				'region' => array('is_select' => 'Sila pilih negeri'),
				'telephone' => array('numeric' => 'Nombor sahaja contoh: 0121234567',
				                    'between' => array('min' => 9, 'max' => 12, 'error' => 'Nombor telefon 10 - 12 karakter')), 
				'road_tax' => array('not_empty' => 'Sila isi amaun cukai jalan'),
				'insuran_due_date' => array('not_empty' => 'Sila isi tarikh tamat tempoh insuran',
				                            'valid_date' => 'Tarikh tamat insuran tidak sah'),
				'reg_number' => array('not_empty' => 'Sila isi nombor pendaftaran kenderaan',
				                      'is_uniq' => array('table' => 'users', 'field' => 'reg_number', 'error' => 'No pendaftaran telah didaftarkan')),
				'owner_name' => array('not_empty' => 'Sila isi pemilik pendaftaran kenderaan'),
				'owner_nric' => array('not_empty' => 'Sila isi No K/P atau No Syarikat'),
				
				'owner_dob' => array('not_empty' => 'Sila isi tarikh lahir pemilik kenderaan',
				                     'valid_date' => 'Tarikh lahir pemilik kenderaan tidak sah'),
				'model' => array('not_empty' => 'Sila isi model kenderaan'),
				'year_make' => array('not_empty' => 'Sila isi tahun kenderaan dibuat',
				                     'numeric' => 'Sila masukkan nombor sahaja',
									 'reg_year' => 'Kenderaan melebihi usia 20 tahun tidak layak'),
				'capacity' => array('not_empty' => 'Sila isi kapasiti enjin (CC)',
				                     'numeric' => 'Sila masukkan nombor sahaja (0-9)'),  
				'engine_number' => array('not_empty' => 'Sila isi nombor enjin kenderaan'), 
				'chasis_number' => array('not_empty' => 'Sila isi nombor chasis kenderaan') 
			));
		
			
		if(empty($this->jun_error)) { 
			$users = new Users();
			$users->username_sponsor = $this->request->getPost('username_sponsor'); 
			$users->username = $this->request->getPost('username'); 
			$users->name = $this->request->getPost('name'); 
			$users->password = md5($this->request->getPost('password')); 
			$users->nric_new = $this->request->getPost('nric_new'); 
			$users->occupation = $this->request->getPost('occupation'); 
			$users->kin_name = $this->request->getPost('kin_name'); 
			$users->relation = $this->request->getPost('relation'); 
			$users->kin_phone = $this->request->getPost('kin_phone');
			$users->nric_new_kin = $this->request->getPost('nric_new_kin'); 
			$users->bank_number = $this->request->getPost('bank_number'); 
			$users->bank_name = $this->request->getPost('bank_name'); 
			$users->address = $this->request->getPost('address'); 
			$users->second_address = $this->request->getPost('second_address'); 
			$users->city = $this->request->getPost('city'); 
			$users->region = $this->request->getPost('region'); 
			$users->postcode = $this->request->getPost('postcode'); 
			$users->telephone = $this->request->getPost('telephone'); 
			$users->email = $this->request->getPost('email'); 
			$users->previous_insuran_company = $this->request->getPost('previous_insuran_company'); 
			$users->cover_note = $this->request->getPost('cover_note'); 
			$users->insuran_ncb = $this->request->getPost('insuran_ncb');
			$users->insuran_due_date = $this->request->getPost('insuran_due_date'); 
			$users->reg_number = $this->request->getPost('reg_number'); 
			$users->owner_name = $this->request->getPost('owner_name'); 
			$users->owner_nric = $this->request->getPost('owner_nric'); 
			$users->owner_dob = $this->request->getPost('owner_dob'); 
			$users->model = $this->request->getPost('model'); 
			$users->year_make = $this->request->getPost('year_make'); 
			$users->capacity = $this->request->getPost('capacity'); 
			$users->created = date('Y-m-d H:i:s'); 
			$users->engine_number = $this->request->getPost('engine_number'); 
			$users->chasis_number = $this->request->getPost('chasis_number'); 
			$users->grant_serial_number = $this->request->getPost('grant_serial_number'); 
			$users->ip_address = $this->get_ip();  
			$users->payment = 0; 
			$users->verified = 0;
			$users->road_tax = $this->request->getPost('road_tax');
			//$users->email_verification = $this->passwordHash(date('Y-m-d H:i:s'));
			$users->ckey = $this->request->getPost('password'); 
			$users->profile_image = 'nophoto.jpg';
			$users->sms_setting = 1;
			$users->role = $this->request->getPost('role') == 11 ? 1 : 0;
			$users->master_key = $this->generateRandomString($length = 6);
			if($users->save()) {
			    $last_id = $users->id;
			    if($this->insert_wallet($last_id)) {
					if($this->insert_insuran($last_id, $this->request->getPost('road_tax'), $this->request->getPost('sec_driver'), $this->request->getPost('windscreen'), $this->request->getPost('insuran_due_date')), $this->request->getPost('insuran_ncb')) {
					    
					    // Set token for validate next page
					    $token = $this->generateRandomString($length = 12);
					    $_SESSION['TOKENREGISTER'] = $token;
					    // Redirect to confirmation page
						
					    return $this->response->redirect('success/'.$last_id.'/'.$token.'/'.$this->request->getPost('md_ref'));
					} else {
						$this->flash->error("Error to create insurance EI23525");
					}
				} else {
					$this->flash->error("Error to create wallet EW23525");
				}
			    
	            
	        } else {
	            foreach ($users->getMessages() as $message) {
	                $this->flash->error((string) $message);
	            }
	        }
			
		}	 
			
        }
		$offset = mt_rand(0, 958695);
		$key = 'userregister'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->form = $this->register_form();
		}
		
		$this->view->cache(array("key" => $key));
	}
	
	private function generateRandomString($length = 6) {
	    $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	
	private function insert_wallet($id) {
		$wallet = new Wallets();
		$wallet->user_id = $id;
		$wallet->amount = 0.00; 
		return $wallet->save();
	}
 
	private function insert_insuran($id, $roadtax, $sec_driver, $windscreen, $due_date, $ncd) {
 
		$ins = new Insuran();
		$ins->user_id = $id; 
		$ins->insurance = 0.00; 
		$ins->wind_screen = $windscreen; 
		$ins->second_driver = $sec_driver = '' ? 'NA' : $sec_driver; 
		$ins->road_tax = $roadtax; 
		$ins->cover = 0.00;
		$ins->service_charge = 0.00; 
		$ins->total = 0.00;
		$ins->next_renewal = $due_date; 
		$ins->created = '2000-01-01 12:01:56'; 
		$ins->pic = 0; 
		$ins->type = 0; 
		$ins->tracking_code = 0; 
		$ins->delivery_method = 0; 
		$ins->crp = 0; 
		$ins->pa = 0;
		$ins->ncd = $ncd;	 
		return $ins->save();
	}
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
    
    public function get_ip() {
		$ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
 
        return $ipaddress;
	}
	
	private function select($data, $input) {
		if($data == $input) {
			return ' selected';
		}
	}
	
	private function register_form() {
	 
	   if(isset($_COOKIE['ref_key']) && isset($_COOKIE['referral_username']) && isset($_COOKIE['ref_id'])) {
		   $sponsor = filter_var($_COOKIE['referral_username'], FILTER_SANITIZE_STRING);
		   $md_ref = 1;
	   } else {
		   $sponsor = '';
		   $md_ref = 0;
	   }
		?>
<form id="defaultForm" action="" method="POST"> 	 	
	<fieldset>
		<legend>Maklumat Penaja</legend>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Introducer <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control col-lg-6" name="username_sponsor" id="username_sponsor" 
				value="<?=$sponsor?>">
				<?php $this->display('username_sponsor'); ?>
				<div id="username_sponsor_result"></div>
				<input type="hidden" name="md_ref" value="<?=$md_ref?>">
			</div>
			  
		</div> 
	
	</fieldset>


	<fieldset>
		<legend>Maklumat Peribadi</legend>
        
        <div class="form-group"> 
        <label class="col-md-6 col-lg-6 col-sm12 col-xs-12"></label>
        <div class="col-md-6">
            <?php $radio = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT); ?>
			<input type="radio" name="role" value="11"<?=$radio == 11 ? 'checked' : ''?>> iKomuniti &nbsp; &nbsp; &nbsp; &nbsp;
			<input type="radio" name="role" value="12"<?=$radio == 12 ? 'checked' : ''?>> iSahabat  &nbsp; &nbsp; &nbsp; &nbsp;
			<a href="http://ishare.com.my/kelebihan.html" target="_blank">Lihat Perbandingan</a><br/>
			<?php $this->display('role'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">ID Pilihan <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="username" id="username" placeholder="A-Z, a-z, 0-9" 
				value="<?=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)?>"> <?php $this->display('username'); ?>
				<div id="username_result"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Nama <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="name" placeholder="Ali Bin Abu" 
				value="<?=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('name'); ?>
			</div>
		</div>
			
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Kata Laluan <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="password" class="form-control" name="password" value="<?=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('password'); ?>
			</div>
		</div>	

		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Ulang Kata Laluan <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="password" class="form-control" name="retype_password" 
				value="<?=filter_input(INPUT_POST, 'retype_password', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('retype_password'); ?>
			</div>
		</div>	
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No. K/P / Tentera<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="nric_new" placeholder="801230106574 / T564568" 
				value="<?=filter_input(INPUT_POST, 'nric_new', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('nric_new'); ?>
			</div>
		</div>	
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Pekerjaan<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="occupation" placeholder="Guru / Berniaga" 
				value="<?=filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('occupation'); ?>
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Nama Waris <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="kin_name" placeholder="Nama Isteri/Anak" 
				value="<?=filter_input(INPUT_POST, 'kin_name', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('kin_name'); ?>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No. Tel. Waris <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="kin_phone" placeholder="0123456789" 
				value="<?=filter_input(INPUT_POST, 'kin_phone', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('kin_phone'); ?>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Hubungan <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="relation" placeholder="Isteri/Anak" 
				value="<?=filter_input(INPUT_POST, 'relation', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('relation'); ?>
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No K/P Waris (Baru) <b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="nric_new_kin" placeholder="801230106574" 
				value="<?=filter_input(INPUT_POST, 'nric_new_kin', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('nric_new_kin'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Akaun Bank</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="bank_number" value="<?=filter_input(INPUT_POST, 'bank_number', FILTER_SANITIZE_STRING)?>" 
				placeholder="CIMB/Maybank/Dll">
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Nama Bank</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="bank_name" value="<?=filter_input(INPUT_POST, 'bank_name', FILTER_SANITIZE_STRING)?>" 
				placeholder="CIMB/Maybank/Dll">
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Maklumat Untuk Dihubungi</legend>
        <div class="col-md-12"><p>Alamat surat-menyurat hendaklah diisi dengan betul bagi tujuan penghantaran Cukai Jalan dan Polisi Perlindungan Insuran. Penghantaran dilakukan pada waktu bekerja oleh Poslaju. Anda boleh menggunakan alamat tempat bekerja jika tiada orang di rumah bagi mengelakkan kelewatan penerimaan Cukai Jalan.</p></div>
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Alamat baris 1<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="address" value="<?=filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING)?>" placeholder="No 38-1, Jalan 7/7B"> 
				<?php $this->display('address'); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Alamat baris 2<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="second_address" value="<?=filter_input(INPUT_POST, 'second_address', FILTER_SANITIZE_STRING)?>" placeholder="Seksyen 7"> 
				<?php $this->display('second_address'); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Poskod<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="postcode" placeholder="43020" 
				value="<?=filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('postcode'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Daerah<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="city" placeholder="Bandar Baru Bangi" 
				value="<?=filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('city'); ?>
			</div>
		</div>
		<?php $region = filter_input(INPUT_POST, 'region', FILTER_SANITIZE_STRING); ?>
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Negeri<b class="required">*</b></label>
			<div class="col-md-6"> 
				<select name="region" class="form-control"> 
				<option value="">Pilih</option>
				<option value="Johor"<?=$this->select($region, 'Johor')?>>Johor</option>
				<option value="Melaka"<?=$this->select($region, 'Melaka')?>>Melaka</option>
				<option value="Negeri Sembilan"<?=$this->select($region, 'Negeri Sembilan')?>>Negeri Sembilan</option>
				<option value="Selangor"<?=$this->select($region, 'Selangor')?>>Selangor</option>
				<option value="Kuala Lumpur"<?=$this->select($region, 'Kuala Lumpur')?>>Kuala Lumpur</option>
				<option value="Pahang"<?=$this->select($region, 'Pahang')?>>Pahang</option>
				<option value="Perak"<?=$this->select($region, 'Perak')?>>Perak</option>
				<option value="Kedah"<?=$this->select($region, 'Kedah')?>>Kedah</option>
				<option value="Pulau Pinang"<?=$this->select($region, 'Pulau Pinang')?>>Pulau Pinang</option>
				<option value="Perlis"<?=$this->select($region, 'Perlis')?>>Perlis</option>
				<option value="Terengganu"<?=$this->select($region, 'Terengganu')?>>Terengganu</option>
				<option value="Kelantan"<?=$this->select($region, 'Kelantan')?>>Kelantan</option>
				<option value="Sabah"<?=$this->select($region, 'Sabah')?>>Sabah</option>
				<option value="Sarawak"<?=$this->select($region, 'Sarawak')?>>Sarawak</option>
				</select>
				<?php $this->display('region'); ?>
			</div>
		</div>

		<div class="form-group">	
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Telefon Pemilik Akaun<b class="required">*</b></label> 
			<div class="col-md-6">
				<input type="text" class="form-control" name="telephone" 
				placeholder="0123456789" value="<?=filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('telephone'); ?>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Email</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="email" placeholder="nama@email.com" 
				value="<?=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)?>">
				 
			</div>
		</div>
	</fieldset>




	<fieldset>
		<legend>Maklumat Insuran Terdahulu</legend>

		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Syarikat Insuran Terdahulu</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="previous_insuran_company" 
				placeholder="Contoh: Takaful Ikhlas" value="<?=filter_input(INPUT_POST, 'previous_insuran_company', FILTER_SANITIZE_STRING)?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No. Nota Perlindungan / Polisi</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="cover_note" 
				value="<?=filter_input(INPUT_POST, 'cover_note', FILTER_SANITIZE_STRING)?>"> 
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">NCD</label>
			<div class="col-md-6">
				<select class="form-control" name="insuran_ncb">
					<option value="">Pilih</option>
					<option value="0">0%</option>
					<option value="25">25%</option>
					<option value="30">30%</option>
					<option value="38.33">38.33%</option>
					<option value="45">45%</option>
					<option value="55">55%</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Cukai Jalan (RM)<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="road_tax" placeholder="Contoh: 120.90" 
				value="<?=filter_input(INPUT_POST, 'road_tax', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('road_tax'); ?>
			</div>
		</div>
       <div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Windscreen (Minima RM300)</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="windscreen" placeholder="500"
				value="<?=filter_input(INPUT_POST, 'windscreen', FILTER_SANITIZE_STRING)?>"> 
			</div>
		</div>
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Tarikh tamat insuran<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="insuran_due_date" id="datepicker1" placeholder="YYYY-MM-DD"
				value="<?=filter_input(INPUT_POST, 'insuran_due_date', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('insuran_due_date'); ?>
			</div>
		</div>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Tambahan Pemandu (Nama Pertama (No K/P), Seterusnya (No K/P))</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="sec_driver" placeholder="Ali Bin Abu (800909108989), Ahmad Bin Ali (670115105449)"
				value="<?=filter_input(INPUT_POST, 'sec_driver', FILTER_SANITIZE_STRING)?>"> 
			</div>
		</div>
		
		
		
	</fieldset>
		
	<fieldset>
		<legend>Maklumat Kenderaan</legend>
			 
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Pendaftaran Kenderaan<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="reg_number" 
				placeholder="Contoh: WWW1234" value="<?=filter_input(INPUT_POST, 'reg_number', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('reg_number'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Nama Pemilik<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="owner_name" placeholder="Contoh: Ali Bin Kasim" 
				value="<?=filter_input(INPUT_POST, 'owner_name', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('owner_name'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No K/P Pemilik / No Syarikat<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="owner_nric" placeholder="Contoh: 801231105645 / 69869-T" 
				value="<?=filter_input(INPUT_POST, 'owner_nric', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('owner_nric'); ?>
			</div>
		</div>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Tarikh Lahir Pemilik<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="owner_dob" placeholder="YYYY-MM-DD" 
				value="<?=filter_input(INPUT_POST, 'owner_dob', FILTER_SANITIZE_STRING)?>" id="dob">
				<?php $this->display('owner_dob'); ?>
			</div>
		</div>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Buatan & Model<b class="required">*</b></label>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="model" placeholder="Perodua Alza 1.5 Ezi / Proton Persona 1.6 SV Auto?" 
				value="<?=filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('model'); ?>
			</div>
		</div>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Tahun Dibuat<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="year_make" placeholder="Contoh: 2010" 
				value="<?=filter_input(INPUT_POST, 'year_make', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('year_make'); ?>
			</div>
		</div>
		
		<div class="form-group"> 
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">Kapasiti Enjin<b class="required">*</b></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="capacity" placeholder="Contoh: 1989" 
				value="<?=filter_input(INPUT_POST, 'capacity', FILTER_SANITIZE_STRING)?>"><?php $this->display('capacity'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Enjin <b class="required">*</b><a href="#" id="no_engin"><img src="img/help_icon.png"></a></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="engine_number" 
				placeholder="K20A9487345" value="<?=filter_input(INPUT_POST, 'engine_number', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('engine_number'); ?> 
				<div class="no_engin" style="display:none; background-color:#4CF;width:240px;height:120px;"><img src="img/chasis.jpg"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Chasis <b class="required">*</b><a href="#" id="no_chasis"><img src="img/help_icon.png"></a></label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="chasis_number" placeholder="M8945U85957" 
				value="<?=filter_input(INPUT_POST, 'chasis_number', FILTER_SANITIZE_STRING)?>">
				<?php $this->display('chasis_number'); ?>
				
				<div class="no_chasis" style="display:none; background-color:#4CF;width:240px;height:120px;"><img src="img/chasis.jpg"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-6 col-lg-6 col-sm12 col-xs-12">No Siri Geran <a href="#" id="no_siri"><img src="img/help_icon.png"></a></label>
			
			<div class="col-md-6">
				<input type="text" class="form-control" name="grant_serial_number" placeholder="1234567" 
				value="<?=filter_input(INPUT_POST, 'grant_serial_number', FILTER_SANITIZE_STRING)?>"> 
				
				<div class="no_siri" style="display:none; background-color:#4CF;width:240px;height:120px;"><img src="img/no_siri.jpg"></div>
			</div>
		</div>
	</fieldset>
		
 
    <fieldset>
		<legend>Daftar</legend>
		<div class="form-group">
		<label class="col-md-12">Saya bersetuju dengan Terma & Syarat iShare</label> <br/> 
		<div class="col-md-12" style="margin-top: 10px; margin-bottom: 20px;">
		<input type="submit" class="btn btn-primary" name="submit" value="Daftar iShare">
		</div>  
		</div> 
	</fieldset>
		
		</form> 
		<?php
	}
	 
	
	public function rules($data) {
        if(isset($_POST)) {
			foreach($data as $key => $value) {
			//echo $_POST[$key] . $value;
				foreach($value as $rule => $error) {
					//echo $rule;
					switch($rule) {
						case 'not_empty':
						    if(empty($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						case 'numeric':
						    if(!is_numeric($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						case 'is_email':
						    if(!$this->validEmail($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						case 'alphanumeric':
						    if(!ctype_alnum($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						case 'between':
						    foreach($error as $between => $minmax) {
								//echo $between .  '<br/>';
								switch($between) {
									case 'min':
									    //echo $between . $minmax;
									    if(strlen($_POST[$key]) < $minmax) {
										    $this->jun_error[$key] = $error['error'];	
										}
									break;
									
									case 'max':
									    //echo $between . $minmax;
									    if(strlen($_POST[$key]) > $minmax) {
										    $this->jun_error[$key] = $error['error'];	
										}
									break;
									
								}
							}
						break;
						
						case 'is_uniq':
						    //echo $error['table']. '-' . $error['field'] . '-' . $_POST[$key];
						    if($this->doCount($error['field'], $_POST[$key]) > 0) {
							    $this->jun_error[$key] = $error['error'];	
							}
						break;
						
						case 'is_exist':
						    //echo $error['table']. '-' . $error['field'] . '-' . $_POST[$key]; check_upline
						    if($this->doCount($error['field'], $_POST[$key]) < 1) {
							    $this->jun_error[$key] = $error['error'];	
							} else {
								
							}
						break;
						
						case 'check_upline':
						    //echo $error['table']. '-' . $error['field'] . '-' . $_POST[$key]; check_upline
						    if($this->check_upline($error['field'], $_POST[$key]) < 1) {
							    $this->jun_error[$key] = $error['error'];	
							} else {
								
							}
						break;
						
						case 'equal_to':
	
						    if($_POST[$key] != $_POST[$value['equal_to']]) {
								$this->jun_error[$key] = $value['error'];
							}
						break;
						
					
						
						/**
	                    * return url
	                    */					
						case 'is_url':
						    if(!$this->is_url($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						/**
	                    * check or radio button
	                    */					
						case 'is_check':
						    if(empty($_POST[$key]) == $key) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						/**
	                    * select option form, make sure first value = empty or 0
	                    */
						case 'is_select':
						    if($_POST[$key] == '') {
								$this->jun_error[$key] = $error;
							}
						break;
						
						/**
	                    * select option form, make sure first value = empty or 0
	                    */
						case 'valid_date':
						    if($_POST[$key] == '0000-00-00') {
								$this->jun_error[$key] = $error;
							}
						break;
						
						/**
	                    * select car year
	                    */
						case 'reg_year':
						    if($_POST[$key] < 1994) {
								$this->jun_error[$key] = $error;
							}
						break;
						
						/**
	                    * select car year
	                    */
						case 'windscreen':
						    if($_POST[$key] < 300) {
								$this->jun_error[$key] = $error;
							}
						break;
					}
				}
			
			}
		}
	}
	
	public function check_upline($field, $value) {
		$user = Users::findFirst("$field = '$value' AND role > 0");
        if ($user != false) {
            return 1;
        } else {
			return 0;
		}
	}
	
	public function doCount($field, $value) {
		$user = Users::findFirst("$field = '$value'");
        if ($user != false) {
            return 1;
        } else {
			return 0;
		}
	}
	
	private function validEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	 
	 
}