<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_do extends KZ_Controller {
    
    private $module = 'non_login/login';
    private $beranda = 'non_login/beranda';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_authentication', 'm_user'));
    }
    function auth() {
        if(!$this->_validation($this->rules)){
            redirect($this->module);
        } else {
            $data = $this->m_authentication->getAuth($this->input->post('username'));
            $this->session->set_userdata(array(
                'logged' => true, 'id' => $data['id_user'], 'name' => $data['fullname'],
                'usr' => $data['username'], 'groupid' => $data['id_group'],'level' => $data['level'], 'foto' => $data['foto_user']
            ));
            $usr['last_login'] = date('Y-m-d H:i:s');
            $usr['ip_user'] = ip_agent();
            $usr['log_user'] = $data['fullname'] . ' Login Sistem';
            $this->m_user->update($data['id_user'], $usr, 1);

            $this->session->set_flashdata('notif', notif('info', 'Selamat datang kembali', $data['fullname']));
            redirect($this->beranda);
        }
    }
    function forgot() {
        if(!$this->_validation($this->rules_forgot)){
            redirect($this->module);
        }
        $username = $this->input->post('fuser');
        $user = $this->m_authentication->getAuth($username);
        $newpass = random_string('alnum', 6);
        //Update Data
        $data['password'] = password_hash($newpass, PASSWORD_DEFAULT);
        $data['update_user'] = date('Y-m-d H:i:s');
        $data['log_user'] = $user['fullname'] . ' Reset Password';
        $data['ip_user'] = ip_agent();
        
        $result = $this->m_user->update($user['id_user'], $data, 1);
        if($result) {
            $this->session->set_flashdata('notif', notif('info', 'Informasi', 'Password anda berhasil di reset
                Password saat ini adalah : <span class="bigger-150 bolder red">'.$newpass.'</span>'));
        }else{
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Password anda gagal di reset'));
        }
        redirect($this->module);
    }
    function changed($id = NULL, $level = NULL) {
        if(empty(decode($id)) || empty($level)){
            redirect($this->beranda);
        }
        $this->load->model(array('m_group'));
        
        $role = $this->m_group->getRole(array('r.user_id' => $this->sessionid,'r.group_id' => decode($id)));
        if($role['rows'] > 0){
            
            $this->session->set_userdata(array(
                'logged' => true,
                'id' => $this->sessionid,
                'name' => $this->sessionname,
                'usr' => $this->sessionusr,
                'groupid' => decode($id),
                'level' => decode($level),
                'foto' => $this->sessionfoto
            ));
            $usr['last_login'] = date('Y-m-d H:i:s');
            $usr['ip_user'] = ip_agent();
            $usr['log_user'] = $this->sessionname . ' Login Sistem with Switch Account';
            $this->m_user->update($this->sessionid, $usr, 1);

            $this->session->set_flashdata('notif', notif('info', 'Selamat datang kembali', $this->sessionname));
            redirect($this->beranda);
        }else{
            redirect('home/err_module');
        }        
    }
    function override($id = NULL) {
        if(empty(decode($id))){
            redirect($this->beranda);
        }
        $this->load->model(array('m_user'));
        
        $rs = $this->m_user->getId(decode($id));
        if(!is_null($rs)){
            
            $this->session->set_userdata(array(
                'logged' => true,
                'id' => decode($id),
                'name' => $rs['fullname'],
                'usr' => $rs['username'],
                'groupid' => $rs['id_group'],
                'foto' => $rs['foto_user']
            ));
            $usr['last_login'] = date('Y-m-d H:i:s');
            $usr['ip_user'] = ip_agent();
            $usr['log_user'] = $this->sessionname . ' Login Sistem with Override Account';
            $this->m_user->update(decode($id), $usr, 1);

            $this->session->set_flashdata('notif', notif('info', 'Override Account ', $this->sessionname));
            redirect($this->beranda);
        }else{
            redirect($this->beranda.'/err_module');
        }        
    }
    //Callback Function
    function _validate() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $data = $this->m_authentication->getAuth($username);
        if (sizeof($data) < 1) {
            $this->form_validation->set_message("_validate", "Username anda belum terdaftar di sistem kami");
            return FALSE;
        }   
        if($data['status_user'] == '0') {
            $this->form_validation->set_message("_validate", "Mohon maaf untuk sementara Akun tidak aktif. Hubungi Administrator");
            return FALSE;
        }
        if(!password_verify($password, $data['password'])){
            $this->form_validation->set_message("_validate", "Password yang anda masukkan salah");
            return FALSE;
        }
        return TRUE;           
    }
    function _unique() {
        $this->load->model(array('m_authentication'));
        
        $val = ($this->input->post('fuser'));
        $data = $this->m_authentication->getAuth($val);
        if (sizeof($data) < 1) {
            $this->form_validation->set_message("_unique", "Username yang anda input belum terdaftar di sistem kami");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function _captcha_google($str){
        $this->load->library('recaptcha');
        $rs = $this->recaptcha->verifyResponse($str);
        if($rs['success']){
            return TRUE;
        }else{
            $this->form_validation->set_message('_captcha_google', 'Berikan tanda centang apabila anda bukan Robot');
            return FALSE;
        }
    }
    private $rules = array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|trim|xss_clean|min_length[5]|callback__validate'
        ),array(
            'field' => 'g-recaptcha-response',
            'label' => 'Pengecekan Keamanan',
            'rules' => 'required|trim|xss_clean|callback__captcha_google' 
        )
    );
    private $rules_forgot = array(
        array(
            'field' => 'fuser',
            'label' => 'Username',
            'rules' => 'required|trim|xss_clean|min_length[5]|callback__unique'
        )
    );
}
