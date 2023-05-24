<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends KZ_Controller {
    
    private $module = 'video';
    private $url_route = array('id', 'source', 'type');
    private $path = 'app/upload/video/';
    
    function __construct() {
        parent::__construct();
    }
    function index($url = null) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_index', $this->data);
    }
    function unggah() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/video/h_upload', $this->data);
    }
    function riwayat() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/video/h_riwayat', $this->data);
    }
    function topik($url = null) {
        if(!empty($url)){
            $this->_detail($url);
        }
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik', $this->data);
    }
    function _detail($url) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik_detail', $this->data);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(3, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'action') {
            if($routing_module['source'] == 'upload') {
                $this->_upload_video();
            }
        }
    }
    //function
    function _upload_video() {
        $this->load->library(array('upload'));
        
        if(!$this->_validation($this->rules)){
            jsonResponse(array('status' => false, 'msg' => validation_errors()));
        }
        $file = $_FILES['file']['tmp_name'];
        if(empty($file)){
            jsonResponse(array('status' => false, 'msg' => 'File tidak dapat ditemukan'));
        }
        $cfg['file_name'] = url_title($this->input->post('judul'), '-', true);
        $cfg['upload_path'] = './' . $this->path;
        $cfg['allowed_types'] = 'mp4|mkv|avi';
        $cfg['max_size'] = 500000;
        $cfg['remove_spaces'] = true;
        $this->upload->initialize($cfg);
        //upload file
        if(!$this->upload->do_upload('file')) {
            jsonResponse(array('status' => false, 'msg' => strip_tags($this->upload->display_errors())));
        }
        $upload = $this->upload->data('file_name');
        jsonResponse(array('data' => base_url($this->path . $upload), 'status' => true, 'msg' => 'Video telah berhasil diupload!'));
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
        )
    );
}
