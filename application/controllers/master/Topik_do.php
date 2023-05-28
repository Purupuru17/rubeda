<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topik_do extends KZ_Controller {
    
    private $module = 'master/topik';
    private $module_do = 'master/topik_do';
    private $path = 'app/upload/topik/';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_topik'));
    }
    function add() {
        if(!$this->_validation($this->rules)){
            redirect($this->module);
        }
        $data['judul_topik'] = ucwords(strtolower($this->input->post('judul')));
        $data['parent_topik'] = '0';
        
        if(!empty($_FILES['foto']['name'])){
            $upload = $this->_upload_img('foto', url_title($data['judul_topik'], 'dash', true), $this->path, 300, false, 300);
            if(empty($upload)){
                redirect($this->module.'/add');
            }
            $data['img_topik'] = $upload;
        }
        $result = $this->m_topik->insert($data);
        if ($result) {
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil disimpan'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal disimpan'));
            redirect($this->module.'/add');
        }
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/edit/'.$id);
        }
        $data['judul_topik'] = ucwords(strtolower($this->input->post('judul')));
        $data['parent_topik'] = '0';
        
        if(!empty($_FILES['foto']['name'])){
            $upload = $this->_upload_img('foto', url_title($data['judul_topik'], 'dash', true), $this->path, 300, false, 300);
            if(empty($upload)){
                redirect($this->module.'/edit/'.$id);
            }
            $data['img_topik'] = $upload;
            $old_img = $this->input->post('exfoto');
            delete_file($old_img);
        }
        $result = $this->m_topik->update(decode($id), $data);
        if ($result) {
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil diubah'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal diubah'));
            redirect($this->module.'/edit/'.$id);
        }
    }
    private $rules = array(
        array(
            'field' => 'judul',
            'label' => 'Judul Topik',
            'rules' => 'required|trim|xss_clean|min_length[3]'
        )
    );    
}
