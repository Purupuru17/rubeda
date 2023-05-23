<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends KZ_Controller {

    private $module = 'sistem/password';
    private $module_do = 'sistem/password_do';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_user'));        
    }
    function index(){
        $this->data['action'] = $this->module.'/edit';
        $this->data['title'] = array('Password','Ubah Password');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('sistem/user/v_password', $this->data);
    }
    function edit() {
        if($this->_validation($this->rules) == FALSE){
            redirect($this->module);
        }
        $passphp = $this->input->post('lama');
        $passdb = $this->m_user->getId($this->sessionid)['password'];
        if(password_verify($passphp, $passdb)){
            
            $data['password'] = password_hash($this->input->post('confirm'), PASSWORD_DEFAULT);
            $data['update_user'] = date('Y-m-d H:i:s');
            $data['log_user'] = $this->sessionname . ' mengubah Password';
            $data['ip_user'] = ip_agent();

            $result = $this->m_user->update($this->sessionid, $data,1);
            if ($result) {
                $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Password berhasil diubah'));
                redirect($this->module);
            } else {
                $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Password gagal diubah'));
                redirect($this->module);
            }
        }else{
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Password Lama anda salah'));
            redirect($this->module);
        }
    }
    private $rules = array(
       array(
            'field' => 'lama',
            'label' => 'Password Lama',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'baru',
            'label' => 'Password Baru',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'confirm',
            'label' => 'Konfirmasi Password',
            'rules' => 'trim|required|xss_clean|matches[baru]|min_length[5]'
        )
    );
}
