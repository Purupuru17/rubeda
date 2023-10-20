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
        $this->session->set_userdata(array('logged' => true, 'id' => $data['id_user'], 
            'name' => $data['fullname'], 'usr' => $data['username'], 'groupid' => $data['id_group'],
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
        $data['id_creator'] = $user['id_user'];//random_string('unique');
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
            if($routing_module['source'] == 'topik') {
                $this->_get_topik();
            }else if($routing_module['source'] == 'video') {
                $this->_get_video();
            }else if($routing_module['source'] == 'channel') {
                $this->_get_channel();
            }
        }else if($routing_module['type'] == 'action') {
            if($routing_module['source'] == 'subscribe') {
                $this->_subs_channel();
            }
        }
    }
    //fungsi
    function _get_topik() {
        $sort = $this->input->post('sort');
        $key = $this->input->post('key');
        $limit = $this->input->post('limit');
        
        $this->db->select('t.*,COUNT(v.id_video) as video')->from('m_topik t')->join('m_video v', 'v.topik_id = t.id_topik', 'left');
        if(!empty($key)){
            $this->db->like('t.judul_topik', trim($key), 'both');
        }
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $this->db->group_by('t.id_topik');
        if($sort == 'most'){
            $this->db->order_by('video', 'desc');
        }else if($sort == 'asc'){
            $this->db->order_by('t.judul_topik', 'asc');
        }else{
            $this->db->order_by('t.judul_topik', 'RANDOM');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $data = array();
        $content = '';
        foreach ($get->result_array() as $item) {
            $row = array();
            $row['judul'] = $item['judul_topik'];
            $row['image'] = load_file($item['img_topik']);
            $row['video'] = $item['video'];
            $row['link'] = site_url('topik/'.encode($item['id_topik']));
            
            $data[] = $row;
            $content .= '<div class="col-xl-3 col-sm-6 mb-3 topik-item">
                <div class="category-item mt-0 mb-0">
                    <a href="'.$row['link'].'">
                        <img class="img-fluid" src="'.$row['image'].'">
                        <h6>'.$row['judul'].'</h6>
                        <p>'.$row['video'].' Video</p>
                    </a>
                </div>
            </div>';
        }
        jsonResponse(array('data' => $data, 'content' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_video() {
        $sort = $this->input->post('sort');
        $key = $this->input->post('key');
        $limit = $this->input->post('limit');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        $progress = '';
            
        $this->db->select('v.*, t.*, COUNT(r.video_id) as viewed, COUNT(l.video_id) as liked')->from('m_video v')
            ->join('m_topik t', 'v.topik_id = t.id_topik', 'inner')->join('fk_like l', 'l.video_id = v.id_video', 'left')
            ->join('fk_riwayat r', 'r.video_id = v.id_video', 'left')->where(array('v.status_video' => '1', 'v.privasi_video' => '1'));
        if(!empty($type)){
            if($type == 'riwayat'){
                $this->db->where(array('r.user_id' => $this->sessionid));
            }else if($type == 'like'){
                $this->db->where(array('l.user_id' => $this->sessionid, 'l.status_like' => '1'));
            }else if($type == 'profil'){
                $this->_creator_id();
                $this->db->where(array('v.creator_id' => $this->cid));
            }else if($type == 'channel' || $type == 'video'){
                $this->db->where(array('v.creator_id' => decode($value)));
            }else{
                $this->db->where(array('v.topik_id' => decode($value)));
            }
        }
        if(!empty($key)){
            $this->db->like('v.judul_video', trim($key), 'both');
        }
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $this->db->group_by('v.id_video');
        if($sort == 'like'){
            $this->db->order_by('liked', 'desc');
        }else if($sort == 'view'){
            $this->db->order_by('viewed', 'desc');
        }else if($sort == 'baru'){
            $this->db->order_by('v.create_video', 'desc');
        }else{
            $this->db->order_by('v.judul_video', 'RANDOM');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $liked = $this->db->get_where('fk_like', array('video_id' => $item['id_video'], 'status_like' => '1'))->num_rows();
            $rand = (int) random_string('numeric',2);
            $progress = ($type == 'riwayat') ? '<div class="progress"><div class="progress-bar" role="progressbar" style="width: '.$rand.'%;">'.$rand.' %</div></div>' : '';
            
            $col = ($type == 'video') ? 'col-md-12' : 'col-xl-3 col-sm-6 mb-3';
            $card = ($type == 'video') ? 'video-card-list' : 'history-video';
            $content .= '<div class="'.$col.' video-item">
                <div class="video-card '.$card.'">
                    <div class="video-card-image">
                        <a class="play-icon" href="'.site_url('video/'.$item['slug_video']).'"><i class="fas fa-play-circle"></i></a>
                        <a href="'.site_url('video/'.$item['slug_video']).'"><img class="img-fluid" src="'. load_file($item['img_video']).'"></a>
                        <div class="time">'.$liked.' <i class="fa fa-thumbs-up"></i></div>
                    </div>
                    '.$progress.'
                    <div class="video-card-body">
                        <div class="video-title"><a href="'.site_url('video/'.$item['slug_video']).'">'.$item['judul_video'].'</a></div>
                        <div class="video-page text-success">'.$item['judul_topik'].'</div>
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
        $limit = $this->input->post('limit');
        $type = $this->input->post('type');
        
        $this->db->select('c.*, COUNT(s.creator_id) as subscribed')->from('m_creator c')
            ->join('fk_subscribe s', 's.creator_id = c.id_creator', 'left')->where('c.status_creator','1');
        if(!empty($type)){
            if($type == 'Subscriptions'){
                $this->db->where(array('s.user_id' => $this->sessionid));
            }
        }
        if(!empty($key)){
            $this->db->like('c.nama_creator', trim($key), 'both');
        }
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $this->db->group_by('c.id_creator');
        if($sort == 'populer'){
            $this->db->order_by('subscribed', 'desc');
        }else if($sort == 'baru'){
            $this->db->order_by('c.create_creator', 'desc');
        }else{
            $this->db->order_by('c.nama_creator', 'RANDOM');
        }
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $is_subs = $this->db->get_where('fk_subscribe', array('creator_id' => $item['id_creator'], 'user_id' => $this->sessionid));
            
            $btn_status = ($is_subs->num_rows() > 0) ? '<button id="subs-btn" itemid="'.encode($item['id_creator']).'"
                itemprop="'.encode(1).'" type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-bell-slash"></i> Subscribed</button>' : 
                '<button id="subs-btn" itemid="'.encode($item['id_creator']).'" itemprop="'.encode(2).'"
                type="button" class="btn btn-outline-danger btn-sm"><strong><i class="fa fa-bell"></i> Subscribe</strong></button>';
            
            $btn_subs = ($type != 'Subscriptions') ? $btn_status : '<button type="button" class="btn btn-success btn-sm border-none">
                <i class="fa fa-bell-slash"></i> <strong>Subscribed</strong></button> <button id="subs-btn" itemid="'.encode($item['id_creator']).'" itemprop="'.encode(1).'" type="button"
                class="btn btn-warning btn-sm border-none"><i class="fas fa-times-circle"></i></button>';
            
            $content .= '<div class="col-xl-3 col-sm-6 mb-3 channel-item">
                <div class="channels-card">
                    <div class="channels-card-image">
                        <a href="'.site_url('channel/'.$item['slug_creator']).'"><img class="img-fluid" src="'. load_file($item['img_creator']).'"></a>
                        <div class="channels-card-image-btn">'.$btn_subs.'</div>
                    </div>
                    <div class="channels-card-body">
                        <div class="channels-title"><a href="'.site_url('channel/'.$item['slug_creator']).'">'.$item['nama_creator'].'</a></div>
                        <div class="channels-view">'.$item['subscribed'].' subscribers</div>
                    </div>
                </div></div>';
            
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _subs_channel() {
        $status = $this->input->post('status');
        $data['creator_id'] = decode($this->input->post('id'));
        $data['user_id'] = $this->sessionid;
        
        if(empty(decode($status))){
            jsonResponse(array('status' => false, 'msg' => 'Channel tidak ditemukan'));
        }
        if(decode($status) == 1){
            $this->db->where($data)->delete('fk_subscribe');
            $delete = $this->db->affected_rows();
            if($delete > 0){
                jsonResponse(array('status' => true, 'msg' => 'Berhenti berlangganan Channel ini'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Gagal berhenti berlangganan Channel ini'));
            }
        }
        $this->db->insert('fk_subscribe', $data);
        $insert = $this->db->affected_rows();
        if($insert > 0){
            jsonResponse(array('status' => true, 'msg' => 'Berhasil berlangganan Channel ini'));
        }else{
            jsonResponse(array('status' => false, 'msg' => 'Gagal berlangganan Channel ini'));
        }
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
