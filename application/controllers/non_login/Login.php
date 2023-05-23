<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends KZ_Controller {

    function index() {
        if (!empty($this->sessionid) || ($this->sessionid != '')) {
            redirect('beranda');
        }
        $this->load->library(array('recaptcha'));
        
        $data['captcha'] = $this->recaptcha->getWidget();
        $data['script_captcha'] = $this->recaptcha->getScriptTag();
        $data['app'] = $this->session->userdata('app');
        $data['theme'] = explode(",",$data['app']['tema']);
        $data['action'] = 'non_login/login_do';

        $this->data['content'] = $this->load->view('non_login/v_login', $data, TRUE);
        $this->load->view('non_login/v_template', $this->data);
    }
    function logout() {
        session_destroy();
        redirect();
    }
}
