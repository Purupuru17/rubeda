<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends KZ_Controller {
    
    private $module = 'home';
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function index() {
        empty($this->sessionid) ? redirect('home/login') : null;
        
        $this->data['module'] = $this->module;
        $this->load_home('home/h_home', $this->data);
    }
    function login() {
        !empty($this->sessionid) ? redirect() : null;
        
        $this->data['app'] = $this->session->userdata('app');
        $this->data['theme'] = explode(",",$this->data['app']['tema']);
        $this->data['module'] = $this->module;
        
        $this->load->view('home/h_login', $this->data);
    }
    function daftar() {
        !empty($this->sessionid) ? redirect() : null;
        
        $this->data['app'] = $this->session->userdata('app');
        $this->data['theme'] = explode(",",$this->data['app']['tema']);
        $this->data['module'] = $this->module;
        
        $this->load->view('home/h_register', $this->data);
    }
    function auth() {
        $this->load->model(array('m_authentication', 'm_user'));
        
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/login');
        }
        $data = $this->m_authentication->getAuth($this->input->post('username'));
        $this->session->set_userdata(array(
            'logged' => true, 'id' => $data['id_user'], 
            'name' => $data['fullname'],
            'usr' => $data['username'], 'groupid' => $data['id_group'],
            'level' => $data['level'], 'foto' => $data['foto_user']
        ));
        $usr['last_login'] = date('Y-m-d H:i:s');
        $usr['ip_user'] = ip_agent();
        $usr['log_user'] = $data['fullname'] . ' Login Sistem';
        $this->m_user->update($data['id_user'], $usr, 1);

        $this->session->set_flashdata('notif', notif('info', 'Selamat datang kembali', $data['fullname']));
        redirect();
    }
    function register() {
        $this->load->model(array('m_authentication'));
        
        if(!$this->_validation($this->rules_add)){
            redirect($this->module.'/daftar');
        }
        $user['id_user'] = random_string('unique');
        $user['id_group'] = 4;
        $user['fullname'] = ucwords(strtolower($this->input->post('nama')));
        $user['username'] = $this->input->post('telepon');
        $user['password'] = password_hash(preg_replace('/\s/', '', $this->input->post('password')), PASSWORD_DEFAULT);
        $user['status_user'] = '1';
        $user['buat_user'] = date('Y-m-d H:i:s');
        $user['log_user'] = 'Pendaftaran Akun';
        $user['ip_user'] = ip_agent();
        
        $data['user_id'] = $user['id_user'];
        $data['id_creator'] = random_string('unique');
        $data['nama_creator'] = $user['fullname'];
        $data['usia_creator'] = $this->input->post('usia');
        $data['telepon_creator'] = $user['username'];
        $data['kerja_creator'] = $this->input->post('kerja');
        $data['lokasi_creator'] = $this->input->post('lokasi');
        $data['status_creator'] = '0';
        $data['create_creator'] = date('Y-m-d H:i:s');
        $data['slug_creator'] = url_title($user['fullname'], '-', true);
        //check
        $auth = $this->m_authentication->getAuth($user['username']);
        if (count($auth) > 0) {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Pendaftaran akun gagal. Nomor Telepon ini telah terdaftar sebelumnya'));
            redirect($this->module.'/daftar');
        }
        //insert
        $this->db->trans_start();
        $this->db->insert('yk_user', $user); $this->db->insert('m_creator', $data);
        $this->db->trans_complete();
        //check
        if ($this->db->trans_status()) {
            $this->session->set_userdata(array(
                'logged' => true, 'id' => $user['id_user'], 'name' => $user['fullname'],
                'usr' => $user['username'], 'groupid' => $user['id_group'], 'level' => 2, 'foto' => null
            ));
            $this->session->set_flashdata('notif', notif('info', 'Selamat datang ', $user['fullname']));
            redirect();
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Pendaftaran akun gagal. Mohon lengkapi data anda dengan baik!'));
            redirect($this->module.'/daftar');
        }
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
        $key = $this->input->post('key');
        
        $this->db->select('t.*,COUNT(v.id_video) as video');
        $this->db->from('m_topik t');
        $this->db->join('m_video v', 'v.topik_id = t.id_topik', 'left');
        if(!empty($key)){
            $this->db->like('t.judul_topik', trim($key), 'both');
        }
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
        $key = $this->input->post('key');
        
        $this->db->select('v.*, t.*, COUNT(l.video_id) as liked, COUNT(r.video_id) as viewed');
        $this->db->from('m_video v');
        $this->db->join('m_topik t', 'v.topik_id = t.id_topik', 'inner');
        $this->db->join('fk_like l', 'l.video_id = v.id_video', 'left');
        $this->db->join('fk_riwayat r', 'r.video_id = v.id_video', 'left');
        $this->db->where('v.status_video','1');
        if(!empty($key)){
            $this->db->like('v.judul_video', trim($key), 'both');
        }
        $this->db->limit(24);
        $this->db->group_by('v.id_video');
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
            $content .= '<div class="col-xl-3 col-sm-6 mb-3 video-item">
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
                            '.$item['viewed'].' Views &nbsp;<i class="fas fa-calendar-alt"></i> '.selisih_wkt($item['create_video']).'
                        </div>
                </div></div></div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_channel() {
        $sort = $this->input->post('sort');
        $key = $this->input->post('key');
        
        $this->db->select('c.*, COUNT(s.creator_id) as subscribed');
        $this->db->from('m_creator c');
        $this->db->join('fk_subscribe s', 's.creator_id = c.id_creator', 'left');
        $this->db->where('c.status_creator','1');
        if(!empty($key)){
            $this->db->like('c.nama_creator', trim($key), 'both');
        }
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
            $content .= '<div class="col-xl-3 col-sm-6 mb-3 channel-item">
                <div class="channels-card">
                    <div class="channels-card-image">
                        <a href="'.site_url('channel/'.$item['slug_creator']).'"><img class="img-fluid" src="'. load_file($item['img_creator']).'"></a>
                        <div class="channels-card-image-btn">
                        <button type="button" class="btn btn-outline-danger btn-sm"><strong>'.$item['subscribed'].' Subscribers</strong></button></div>
                    </div>
                    <div class="channels-card-body">
                        <div class="channels-title"><a href="'.site_url('channel/'.$item['slug_creator']).'">'.$item['nama_creator'].'</a></div>
                        <div class="channels-view"></div>
                    </div>
                </div></div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _validate() {
        $this->load->model(array('m_authentication'));
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $data = $this->m_authentication->getAuth($username);
        if (sizeof($data) < 1) {
            $this->form_validation->set_message("_validate", "Nomor Telepon anda belum terdaftar di sistem kami");
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
    private $rules = array(
        array(
            'field' => 'username',
            'label' => 'Nomor Telepon',
            'rules' => 'required|trim|xss_clean|min_length[5]|callback__validate'
        )
    );
    private $rules_add = array(
        array(
            'field' => 'nama',
            'label' => 'Nama Lengkap',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'telepon',
            'label' => 'Nomor Telepon',
            'rules' => 'required|trim|xss_clean|is_natural|min_length[11]|max_length[12]'
        ),array(
            'field' => 'usia',
            'label' => 'Usia',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'kerja',
            'label' => 'Pekerjaan',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'lokasi',
            'label' => 'Lokasi',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|xss_clean|min_length[5]'
        )
    );
}
