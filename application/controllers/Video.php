<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends KZ_Controller {
    
    private $module = 'video';
    private $url_route = array('id', 'source', 'type');
    private $path = 'app/upload';
    
    function __construct() {
        parent::__construct();
        $this->_creator_id();
    }
    function index($url = null) {
         if(empty($url)){
            redirect();
        }
        $detail = $this->db->from('m_video v')->join('m_creator c', 'v.creator_id = c.id_creator', 'inner')
                ->join('m_topik t', 'v.topik_id = t.id_topik', 'inner')
                ->where(array('v.slug_video' => $url, 'v.status_video' => '1', 'v.privasi_video !=' => '0'))->get()->row_array();
        if(empty($detail)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Video tidak tersedia untuk saat ini'));
            redirect();
        }
        $this->data['detail'] = $detail;
        $this->data['module'] = $this->module;
        $this->data['meta'] = array('title' => $detail['judul_video'], 'description' => $detail['deskripsi_video'],'thumbnail' => load_file($detail['img_video']));
        $this->load_home('home/video/h_index', $this->data);
    }
    function unggah() {
        if(empty($this->cid)){
            redirect();
        }
        $rs = $this->db->get_where('m_creator', array('id_creator' => $this->cid))->row_array();
        if($rs['status_creator'] == '0'){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 
            'Anda belum di izinkan untuk dapat mengunggah Video. Hubungi administrator dahulu'));
            redirect();
        }
        $this->data['topik'] = $this->db->get('m_topik')->result_array();
        
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_upload', $this->data);
    }
    function riwayat() {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_riwayat', $this->data);
    }
    function topik() {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik', $this->data);
    }
    function topik_detail($url = null) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik', $this->data);
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
    function _tes(){
        $cfg['file_name'] = random_string('unique');
        $cfg['upload_path'] = './'.$this->path.'/video/';
        $cfg['allowed_types'] = 'mp4';
        $cfg['max_size'] = 500000;
        $cfg['remove_spaces'] = true;
        $this->upload->initialize($cfg);
        //do upload
        if(!$this->upload->do_upload('file')) {
            jsonResponse(array('status' => false, 'msg' => 'Video '.strip_tags($this->upload->display_errors())));
        }
        $data['file_video']  = $this->path.'/video/' . $this->upload->data('file_name');
        jsonResponse(array('status' => true, 'msg' => 'Video telah berhasil diupload! '.$data['file_video']));
    }
    function _upload_video() {
        $this->load->library(array('upload'));
        
        if (empty($_FILES['file']['tmp_name'])) {
            jsonResponse(array('status' => false, 'msg' => 'Pilih Video terlebih dahulu'));
        }
        if (empty($_FILES['thumb']['tmp_name'])) {
            jsonResponse(array('status' => false, 'msg' => 'Pilih Thumbnail Video terlebih dahulu'));
        }
        if(!$this->_validation($this->rules, 1)){
            jsonResponse(array('status' => false, 'msg' => validation_errors()));
        }
        $data['topik_id'] = decode($this->input->post('topik'));
        $data['judul_video'] = ucwords(strtolower($this->input->post('judul')));
        $data['privasi_video'] = $this->input->post('privasi');
        $data['usia_video'] = $this->input->post('usia');
        $data['tag_video'] = $this->input->post('tag');
        $data['deskripsi_video'] = $this->input->post('deskripsi');
        
        $data['slug_video'] = url_title($data['judul_video'], 'dash', true);
        $data['creator_id'] = $this->cid;
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
            jsonResponse(array('status' => false, 'msg' => 'Thumbnail '.strip_tags($this->upload->display_errors())));
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
            jsonResponse(array('status' => false, 'msg' => 'Video '.strip_tags($this->upload->display_errors())));
        }
        $data['file_video']  = $this->path.'/video/' . $this->upload->data('file_name');
        //insert db
        $this->db->set('id_video', 'UUID()', FALSE);
        $this->db->insert('m_video', $data);
        if($this->db->affected_rows() > 0){
            jsonResponse(array('status' => true, 'msg' => 'Video telah berhasil di upload!'));
        }else{
            delete_file($thumb);delete_file($data['file_video']);
            jsonResponse(array('status' => false, 'msg' => 'Video gagal di upload!'));
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
