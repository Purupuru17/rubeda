<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends KZ_Controller {
    
    private $module = 'master/chat';
    private $module_do = 'master/chat_do';    
    private $url_route = array('id', 'source', 'type');
    private $path = 'app/upload/chat/';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_chat'));
    }
    function index() {
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Chat','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->load_view('master/chat/v_index', $this->data);
    }
    function add($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $detail = $this->db->get_where('m_room', array('id_room' => decode($id), 'status_room' => '1'))->row_array();
        if(is_null($detail)){
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Obrolan tidak ditemukan'));
            redirect($this->module);
        }
        $user_id = ($this->sessionid == $detail['send_by']) ? $detail['send_to']:$detail['send_by'];
        $user_chat = $this->db->get_where('yk_user', array('id_user' => $user_id))->row_array();
        
        $this->data['detail'] = $detail;
        $this->data['module'] = $this->module;
        $this->data['title'] = array($user_chat['fullname'],'Obrolan');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/chat/v_form', $this->data);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'list') {
            if($routing_module['source'] == 'room') {
                $this->_get_room();
            }else if($routing_module['source'] == 'chat') {
                $this->_get_chat();
            }else if($routing_module['source'] == 'user') {
                $this->_get_user();
            }
        }else if($routing_module['type'] == 'action') {
            if($routing_module['source'] == 'room') {
                $this->_add_room();
            }else if($routing_module['source'] == 'chat') {
                $this->_add_chat();
            }else if($routing_module['source'] == 'attach') {
                $this->_attach_chat();
            }
        }
    }
    //function
    function _get_room() {
        $this->db->select('r.*, by.fullname as byname, to.fullname as toname')->from('m_room r')
            ->join('yk_user by', 'r.send_by = by.id_user', 'left')->join('yk_user to', 'r.send_to = to.id_user', 'left')
            ->where(array('r.status_room' => '1','r.send_by' => $this->sessionid))->or_where(array('r.send_to' => $this->sessionid))
            ->order_by('r.create_room', 'DESC');
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $is_name = ($this->sessionid == $item['send_by']) ? $item['toname'] : $item['byname'];
            $is_msg = $this->db->get_where('m_chat', array('room_id' => $item['id_room'], 'user_id <>' => $this->sessionid, 'status_chat' => '0'))
                ->num_rows();
            $new_msg = $is_msg > 0 ? $is_msg. ' pesan baru':'Klik Chat';
            $content .= '<div class="itemdiv memberdiv room-item">
                <div class="user">
                    <img alt="Avatar" src="'.load_file('app/img/no-avatar.png').'">
                </div>
                <div class="body">
                    <div class="name bolder">
                        <a href="#">'.$is_name.'</a>
                    </div>
                    <div class="time">
                        <i class="ace-icon fa fa-clock-o"></i>
                        <span class="grey"> '.selisih_wkt($item['create_room']).'</span>
                    </div>
                    <div class="space-2"></div>
                    <div>
                        <button id="restart-btn" itemid="'. encode($item['id_room']) .'" 
                            class="tooltip-info btn btn-white btn-info btn-mini btn-round" data-rel="tooltip" title="Mulai Obrolan">
                            <span class="blue"><i class="ace-icon fa fa-comments"></i> '.$new_msg.' </span>
                        </button>
                    </div>
                </div>
            </div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_chat() {
        $id = decode($this->input->post('id'));
        
        $this->db->from('m_chat c')->join('yk_user u', 'c.user_id = u.id_user', 'inner')
            ->where(array('c.room_id' => $id))->order_by('c.create_chat', 'ASC');
        $get = $this->db->get();
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $is_send = '<strong class="blue">'.$item['fullname'].'</strong>'; 
            $is_chat = 'col-xs-7';
            $st_read = $st_send = $bg_send = '';
            
            $ext = substr($item['file_chat'], strrpos($item['file_chat'], '.') + 1);
            $file = substr($item['file_chat'], strrpos($item['file_chat'], '/') + 1);
            $is_file = in_array($ext, array('jpg','jpeg','png','JPG','PNG')) ? 
                '<img class="img-thumbnail lazyload blur-up" width="100%" src="'. base_url($item['file_chat']).'" >' 
                    : '<strong>'.$file.'</strong> '.st_file($item['file_chat'],1);
            $attach = empty($item['file_chat']) ? '' : $is_file;
            
            if($this->sessionid == $item['user_id']){
                $is_send = '<strong class="grey">Anda</strong>';
                $is_chat = 'col-xs-offset-5 col-xs-7';
                $bg_send = 'style="background: aliceblue;"';
                $st_send = ($item['status_chat'] == '1') ? 'fa-check-square-o green':'fa-check';
                $st_read = '<small>'.selisih_wkt($item['read_chat']).'</small>';
            }
            $content .= '<div class="itemdiv dialogdiv '.$is_chat.' chat-item">
                <div class="user">
                    <img alt="'.$item['fullname'].'" src="'.load_file('app/img/no-avatar.png').'">
                </div>
                <div class="body" '.$bg_send.'>
                    <div class="time">
                        <i class="ace-icon fa fa-clock-o"></i>
                        <span class="grey">'. selisih_wkt($item['create_chat']).'</span>
                    </div>
                    <div class="name"></div>
                    <div class="text">'.$item['isi_chat'].'</div>
                    <div class="space-6"></div>
                    '.$attach.'
                    <div class="tools">
                        <i class="icon-only ace-icon fa '.$st_send.'"></i> '.$st_read.'
                    </div>
                </div>
            </div>';
        }
        //update chat
        $this->m_chat->update(array('room_id' => $id, 'user_id <>' => $this->sessionid, 'status_chat' => '0'), 
            array('status_chat' => '1', 'read_chat' => date('Y-m-d H:i:s')));
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _get_user(){
        $this->db->from('m_creator c')
            ->join('yk_user u', 'c.user_id = u.id_user', 'inner')
            ->where(array('c.user_id <>' => $this->sessionid))->limit(10)->order_by('u.last_login', 'DESC');
        $get = $this->db->get();
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $content .= '<div class="itemdiv memberdiv user-item">
                <div class="inline pos-rel">
                    <div class="user">
                        <a href="#">
                            <img src="'.load_file('app/img/no-avatar.png').'" alt="'.$item['nama_creator'].'">
                        </a>
                    </div>
                    <div class="body">
                        <div class="name">
                            <span class="user-status status-online hide"></span> 
                            <button id="start-btn" itemid="'. encode($item['user_id']) .'" itemname="'. ctk($item['nama_creator']) .'" 
                                class="tooltip-success btn btn-white btn-success btn-mini btn-round" data-rel="tooltip" title="Mulai Obrolan">
                                <span class="green"><i class="ace-icon fa fa-comment"></i> Mulai Chat </span>
                            </button>
                        </div>
                    </div>
                    <div class="popover right">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            <div class="bolder">'.$item['nama_creator'].'</div>
                            <div class="time">
                                <i class="ace-icon fa fa-clock-o orange"></i>
                                <small>'.selisih_wkt($item['last_login']).'</small>
                            </div>
                            <div class="hr dotted hr-8"></div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        jsonResponse(array('data' => $content, 'status' => true, 'msg' => 'Data ditemukan'));
    }
    function _add_room() {
        $id = decode($this->input->post('id'));
        if(empty($id)){
            jsonResponse(array('status' => false, 'msg' => 'User tidak ditemukan'));
        }
        $send_by = $this->db->get_where('m_room', array('send_by' => $this->sessionid, 'send_to' => $id))->row_array();
        if(!is_null($send_by)){
            jsonResponse(array('data' => encode($send_by['id_room']), 'status' => true, 'msg' => 'Obrolan ini sdh ada sebelumnya'));
        }
        $send_to = $this->db->get_where('m_room', array('send_by' => $id, 'send_to' => $this->sessionid))->row_array();
        if(!is_null($send_to)){
            jsonResponse(array('data' => encode($send_to['id_room']), 'status' => true, 'msg' => 'Obrolan ini sdh ada sebelumnya'));
        }
        $data['id_room'] = random_string('unique');
        $data['send_by'] = $this->sessionid;
        $data['send_to'] = $id;
        $data['create_room'] = date('Y-m-d H:i:s');
        $data['status_room'] = '1';
        
        $result = $this->m_chat->insertRoom($data);
        if ($result){
            jsonResponse(array('data' => encode($data['id_room']), 'status' => true, 'msg' => 'Obrolan berhasil dibuat'));
        } else {
            jsonResponse(array('status' => false, 'msg' => 'Obrolan gagal di dibuat'));
        }
    }
    function _add_chat() {
        if(!$this->_validation($this->rules,'ajax')){
            jsonResponse(array('status' => false, 'msg' => validation_errors()));
        }
        $data['room_id'] = decode($this->input->post('id'));
        $data['user_id'] = $this->sessionid;
        $data['isi_chat'] = $this->input->post('message');
        $data['create_chat'] = date('Y-m-d H:i:s');
        $data['status_chat'] = '0';
        
        $result = $this->m_chat->insert($data);
        if ($result){
            jsonResponse(array('status' => true, 'msg' => 'Pesan berhasil dikirim'));
        } else {
            jsonResponse(array('status' => false, 'msg' => 'Pesan gagal dikirim'));
        }
    }
    function _attach_chat() {
        //jsonResponse(array('status' => false, 'msg' => json_encode($_FILES['attach'])));
        $id = decode($this->input->post('id'));
        if(empty($id)){
            jsonResponse(array('status' => false, 'msg' => 'Obrolan tidak ditemukan'));
        }
        if(empty($_FILES['attach']['tmp_name'])) {
            jsonResponse(array('status' => false, 'msg' => 'Pilih file terlebih dahulu'));
        }
        $data['room_id'] = $id;
        $data['user_id'] = $this->sessionid;
        $data['isi_chat'] = '';
        $data['create_chat'] = date('Y-m-d H:i:s');
        $data['status_chat'] = '0';
        //upload file
        $cfg['file_name'] = url_title($_FILES['attach']['name'], 'dash', true);
        $cfg['upload_path'] = './'.$this->path;
        $cfg['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|pdf|PDF';
        $cfg['max_size'] = 1100;
        $cfg['remove_spaces'] = true;
        
        $this->load->library(array('upload'));
        $this->upload->initialize($cfg);
        //do upload
        if(!$this->upload->do_upload('attach')) {
            jsonResponse(array('status' => false, 'msg' => 'File '.strip_tags($this->upload->display_errors())));
        }
        $data['file_chat'] = $this->path.$this->upload->data('file_name');
        
        $result = $this->m_chat->insert($data);
        if ($result){
            jsonResponse(array('status' => true, 'msg' => 'Pesan berhasil dikirim'));
        } else {
            jsonResponse(array('status' => false, 'msg' => 'Pesan gagal dikirim'));
        }
    }
    private $rules = array(
        array(
            'field' => 'id',
            'label' => 'Obrolan',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'message',
            'label' => 'Isi Pesan',
            'rules' => 'required|trim|xss_clean'
        )
    );
}
