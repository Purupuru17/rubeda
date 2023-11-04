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
    function profil($url = null) {
        $this->data['type'] = empty($url) ? 'profil' : $url;
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_profil', $this->data);
    }
    function topik($id = null) {
        if(empty($id)){
            $this->data['module'] = $this->module;
            $this->load_home('home/video/h_topik', $this->data);
            return;
        }
        $detail = $this->db->get_where('m_topik',array('id_topik' => decode($id)))->row_array();
        if(empty($detail)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Topik tidak tersedia untuk saat ini'));
            redirect();
        }
        $this->data['type'] = array($detail['judul_topik'],$id);
        $this->load_home('home/video/h_profil', $this->data);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(3, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'list') {
            if($routing_module['source'] == 'info') {
                $this->_get_info();
            }
        }else if($routing_module['type'] == 'action') {
            if($routing_module['source'] == 'upload') {
                $this->_upload_video();
            }else if($routing_module['source'] == 'liked') {
                $this->_liked_video();
            }
        }
    }
    //function
    function _get_info() {
        $id = $this->input->post('id');
        $cid = $this->input->post('cid');
        
        $st_subs = $this->db->get_where('fk_subscribe', array('creator_id' => decode($cid), 'user_id' => $this->sessionid))->num_rows();
        $st_like = $this->db->get_where('fk_like', array('video_id' => decode($id), 'user_id' => $this->sessionid))->row_array();
        $st_viewed = $this->db->get_where('fk_riwayat', array('video_id' => decode($id), 
            'user_id' => $this->sessionid, 'DATE(create_riwayat)' => date('Y-m-d')))->num_rows();
        $liked = $this->db->get_where('fk_like',array('video_id' => decode($id), 'status_like' => '1'))->num_rows();
        
        if($st_viewed < 1){
            $this->db->insert('fk_riwayat', array('video_id' => decode($id), 'user_id' => $this->sessionid, 'create_riwayat' => date('Y-m-d H:i:s')));
        }
        $data['btn_subs'] = ($st_subs > 0) ? '<button id="subs-btn" itemid="'.$cid.'"
            itemprop="'.encode(1).'" type="button" class="btn btn-success"><i class="fa fa-bell-slash"></i> Subscribed</button>' : 
            '<button id="subs-btn" itemid="'.$cid.'" itemprop="'.encode(2).'"
            type="button" class="btn btn-danger"><strong><i class="fa fa-bell"></i> Subscribe</strong></button>';
        
        if(empty($st_like)){
            $data['btn_like'] = '<button id="like-btn" itemprop="'.encode(2).'" class="btn btn-outline-danger" type="button"><i class="fa fa-thumbs-up"></i> '.$liked.'</button>
                <button id="unlike-btn" itemprop="'.encode(2).'" class="btn btn-outline-secondary" type="button"><i class="fa fa-thumbs-down"></i></button>';
        }else if($st_like['status_like'] == '1'){
            $data['btn_like'] = '<button id="like-btn" itemprop="'.encode(1).'" class="btn btn-success" type="button"><i class="fa fa-thumbs-up"></i> '.$liked.'</button>';
        }else if($st_like['status_like'] == '0'){
            $data['btn_like'] = '<button disable class="btn btn-outline-success" type="button">'.$liked.' Likes</button>
                <button id="unlike-btn" itemprop="'.encode(1).'" class="btn btn-secondary" type="button"><i class="fa fa-thumbs-down"></i> </button>';
        }
        $data['viewed'] = $this->db->get_where('fk_riwayat',array('video_id' => decode($id)))->num_rows();
        
        jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _liked_video() {
        $status = $this->input->post('status');
        $btn = $this->input->post('btn');
        
        $data['video_id'] = decode($this->input->post('id'));
        $data['user_id'] = $this->sessionid;
        $data['status_like'] = ($btn == 'unlike') ? '0' : '1';
        
        if(empty(decode($status))){
            jsonResponse(array('status' => false, 'msg' => 'Video tidak ditemukan'));
        }
        if(decode($status) == 1){
            $this->db->where($data)->delete('fk_like');
            $delete = $this->db->affected_rows();
            if($delete > 0){
                jsonResponse(array('status' => true, 'msg' => 'Batal '.ucwords($btn).' Video ini'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Gagal membatalkan masukan. Mohon ulangi kembali'));
            }
        }
        $this->db->insert('fk_like', $data);
        $insert = $this->db->affected_rows();
        if($insert > 0){
            jsonResponse(array('status' => true, 'msg' => 'Anda '.ucwords($btn).' Video ini'));
        }else{
            jsonResponse(array('status' => false, 'msg' => 'Gagal memberi masukan. Mohon ulangi kembali'));
        }
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
        $data['status_video'] = ($this->sessionlevel == '1') ? '1' : '0';
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
        $cfg['max_size'] = 2000000;
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
