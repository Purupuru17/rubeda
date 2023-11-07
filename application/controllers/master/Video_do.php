<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video_do extends KZ_Controller {
    
    private $module = 'master/video';
    private $module_do = 'master/video_do';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_video'));
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/edit/'.$id);
        }
        $data['topik_id'] = decode($this->input->post('topik'));
        $data['judul_video'] = ucwords(strtolower($this->input->post('judul')));
        $data['usia_video'] = $this->input->post('usia');
        $data['privasi_video'] = $this->input->post('privasi');
        $data['status_video'] = $this->input->post('status');
        $data['tag_video'] = $this->input->post('tag');
        $data['deskripsi_video'] = $this->input->post('deskripsi');
        
        $data['slug_video'] = url_title($data['judul_video'], 'dash', true);
        $data['update_video'] = date('Y-m-d H:i:s');
        $data['log_video'] = $this->sessionname.' mengubah video';
        
        $result = $this->m_video->update(decode($id), $data);
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
            'label' => 'Judul Video',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'deskripsi',
            'label' => 'Deskripsi Video',
            'rules' => 'required|trim|xss_clean|min_length[30]'
        ),array(
            'field' => 'topik',
            'label' => 'Topik Video',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'usia',
            'label' => 'Batasan Usia',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'privasi',
            'label' => 'Pengaturan Privasi',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'tag',
            'label' => 'Tag Video',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        )
    ); 
}
