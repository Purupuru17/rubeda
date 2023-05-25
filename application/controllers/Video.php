<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends KZ_Controller {
    
    private $module = 'video';
    private $url_route = array('id', 'source', 'type');
    private $path = 'app/upload';
    
    function __construct() {
        parent::__construct();
    }
    function index($url = null) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_index', $this->data);
    }
    function unggah() {
        $this->data['topik'] = $this->db->get('m_topik')->result_array();
        
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
        
        if(!$this->_validation($this->rules, 1)){
            jsonResponse(array('status' => false, 'msg' => validation_errors()));
        }
        if (empty($_FILES['file']['tmp_name'])) {
            jsonResponse(array('status' => false, 'msg' => 'Pilih Video terlebih dahulu'));
        }
        if (empty($_FILES['thumb']['tmp_name'])) {
            jsonResponse(array('status' => false, 'msg' => 'Pilih Thumbnail Video terlebih dahulu'));
        }
        $data['topik_id'] = decode($this->input->post('topik'));
        $data['judul_video'] = ucwords(strtolower($this->input->post('judul')));
        $data['privasi_video'] = $this->input->post('privasi');
        $data['usia_video'] = $this->input->post('usia');
        $data['tag_video'] = $this->input->post('tag');
        $data['deskripsi_video'] = $this->input->post('deskripsi');
        
        $data['slug_video'] = url_title($data['judul_video'], 'dash', true);
        $data['creator_id'] = $this->sessionid;
        $data['status_video'] = '0';
        $data['create_video'] = date('Y-m-d H:i:s');
        $data['log_video'] = $this->sessionname.' menambahkan video baru';
        //check slug
        $check = $this->db->get_where('m_video', array('slug_video' => $data['slug_video']));
        if($check->num_rows() > 0){
            jsonResponse(array('status' => false, 'msg' => 'Gunakan Judul Video yang lainnya. Judul ini sudah ada sebelumnya'));
        }
        //upload thumbnail
        $thumb = $this->_upload_img('thumb', $data['slug_video'], $this->path.'/thumb/', 270, false, 169);
        if(empty($thumb)){
            jsonResponse(array('status' => false, 'msg' => strip_tags($this->upload->display_errors())));
        }
        $data['img_video'] = $thumb;
        //upload video
        $cfg['file_name'] = $data['slug_video'];
        $cfg['upload_path'] = './'.$this->path.'/video/';
        $cfg['allowed_types'] = 'mp4';
        $cfg['max_size'] = 500000;
        $cfg['remove_spaces'] = true;
        $this->upload->initialize($cfg);
        //do upload
        if(!$this->upload->do_upload('file')) {
            delete_file($thumb);
            jsonResponse(array('status' => false, 'msg' => strip_tags($this->upload->display_errors())));
        }
        $data['file_video']  = $this->path.'/video/' . $this->upload->data('file_name');
        //insert db
        $this->db->set('id_video', 'UUID()', FALSE);
        $this->db->insert('m_video', $data);
        if($this->db->affected_rows() > 0){
            jsonResponse(array('data' => base_url($data['file_video']), 'status' => true, 'msg' => 'Video telah berhasil diupload!'));
        }else{
            delete_file($thumb);delete_file($data['file_video']);
            jsonResponse(array('status' => false, 'msg' => 'Video gagal diupload!'));
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
            'field' => 'tag',
            'label' => 'Tag Video',
            'rules' => 'trim|xss_clean|min_length[5]'
        )
    );
}
