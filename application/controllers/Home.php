<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends KZ_Controller {
    
    private $module = 'home';
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function index() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/h_home', $this->data);
    }
    function err_404() {
        $this->data['breadcrumb'] = array( 
            array('title' => 'Halaman Tidak Ditemukan', 'url' => '#')
        );
        $this->load_view('errors/html/error_404', $this->data);
    }
    function err_module() {
        $this->data['breadcrumb'] = array( 
            array('title'=>'Gagal Akses Module', 'url'=>'#')
        );
        $this->load_view('errors/html/error_module', $this->data);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(3, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'list') {
            if($routing_module['source'] == 'topic') {
                $this->_get_topic();
            }else if($routing_module['source'] == 'video') {
                $this->_get_video();
            }else if($routing_module['source'] == 'channel') {
                $this->_get_channel();
            }
        }
    }
    //fungsi
    function _get_topic() {
        $sort = $this->input->post('sort');
        
        $this->db->select('t.*,COUNT(v.id_video) as video');
        $this->db->from('m_topik t');
        $this->db->join('m_video v', 'v.topik_id = t.id_topik', 'left');
        $this->db->limit(24);
        $this->db->group_by('t.id_topik');
        if($sort == 'most'){
            $this->db->order_by('video', 'desc');
        }else{
            $this->db->order_by('t.judul_topik', 'asc');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $data = array();
        foreach ($get->result_array() as $item) {
            $row = array();
            $row['judul'] = $item['judul_topik'];
            $row['image'] = load_file($item['img_topik']);
            $row['video'] = $item['video'];
            $row['link'] = site_url('video/topik/'.encode($item['id_topik']));
            
            $data[] = $row;
        }
        jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_video() {
        $sort = $this->input->post('sort');
        
        $this->db->select('v.*, t.*, COUNT(l.video_id) as liked, COUNT(r.video_id) as viewed');
        $this->db->from('m_video v');
        $this->db->join('m_topik t', 'v.topik_id = t.id_topik', 'inner');
        $this->db->join('fk_like l', 'l.video_id = v.id_video', 'left');
        $this->db->join('fk_riwayat r', 'r.video_id = v.id_video', 'left');
        $this->db->where('v.status_video','1');
        $this->db->limit(24);$this->db->group_by('v.id_video');
        if($sort == 'like'){
            $this->db->order_by('liked', 'desc');
        }else if($sort == 'view'){
            $this->db->order_by('viewed', 'desc');
        }else{
            $this->db->order_by('v.create_video', 'desc');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $content .= '<div class="col-xl-3 col-sm-6 mb-3">
                <div class="video-card">
                    <div class="video-card-image">
                        <a class="play-icon" href="'.site_url('video/'.$item['slug_video']).'"><i class="fas fa-play-circle"></i></a>
                        <a href="'.site_url('video/'.$item['slug_video']).'"><img class="img-fluid" src="'. load_file($item['img_video']).'"></a>
                        <div class="time">'.$item['liked'].' Likes</div>
                    </div>
                    <div class="video-card-body">
                        <div class="video-title"><a href="'.site_url('video/'.$item['slug_video']).'">'.$item['judul_video'].'</a></div>
                        <div class="video-page text-danger">'.$item['judul_topik'].'</div>
                        <div class="video-view">
                            '.$item['liked'].' Views &nbsp;<i class="fas fa-calendar-alt"></i> '.selisih_wkt($item['create_video']).'
                        </div>
                </div></div></div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_channel() {
        $sort = $this->input->post('sort');
        
        $this->db->select('c.*, COUNT(s.creator_id) as subscribed');
        $this->db->from('m_creator c');
        $this->db->join('fk_subscribe s', 's.creator_id = c.id_creator', 'left');
        $this->db->where('c.status_creator','1');
        $this->db->limit(24);
        $this->db->group_by('c.id_creator');
        if($sort == 'populer'){
            $this->db->order_by('subscribed', 'desc');
        }else{
            $this->db->order_by('c.create_creator', 'desc');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $content .= '<div class="col-xl-3 col-sm-6 mb-3">
                <div class="channels-card">
                    <div class="channels-card-image">
                        <a href="'.site_url('channel/'.$item['slug_creator']).'"><img class="img-fluid" src="'. load_file($item['img_creator']).'"></a>
                        <div class="channels-card-image-btn">
                        <button type="button" class="btn btn-outline-danger btn-sm">Subscribe <strong>'.$item['subscribed'].'</strong></button></div>
                    </div>
                    <div class="channels-card-body">
                        <div class="channels-title"><a href="'.site_url('channel/'.$item['slug_creator']).'"><b>'.$item['nama_creator'].'</b></a></div>
                        <div class="channels-view">'.$item['subscribed'].' Subscribers</div>
                    </div>
                </div></div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
}
