<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends KZ_Controller {
    
    private $module = 'master/chat';
    private $module_do = 'master/chat_do';    
    private $url_route = array('id', 'source', 'type');
    
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
        }
    }
    //function
    function _get_room() {
        $this->db->select('r.*, by.fullname as byname, to.fullname as toname')->from('m_room r')
            ->join('yk_user by', 'r.send_by = by.id_user', 'left')->join('yk_user to', 'r.send_to = to.id_user', 'left')
            ->where(array('r.status_room' => '1','r.send_by' => $this->sessionid))->or_where(array('r.send_to' => $this->sessionid))->order_by('r.create_room', 'DESC');
        $get = $this->db->get();
        
        if($get->num_rows() < 1){
            jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $content = '';
        foreach ($get->result_array() as $item) {
            $name = ($this->sessionid == $item['send_by']) ? $item['toname'] : $item['byname']; 
            $content .= '<div class="itemdiv memberdiv room-item">
                <div class="user">
                    <img alt="Avatar" src="'.load_file('app/img/no-avatar.png').'">
                </div>
                <div class="body">
                    <div class="name bolder">
                        <a href="#">'.$name.'</a>
                    </div>
                    <div class="time">
                        <i class="ace-icon fa fa-clock-o"></i>
                        <span class="grey"> '.selisih_wkt($item['create_room']).'</span>
                    </div>
                    <div>
                        <button id="restart-btn" itemid="'. encode($item['id_room']) .'" 
                            class="tooltip-info btn btn-white btn-info btn-mini btn-round" data-rel="tooltip" title="Mulai Obrolan">
                            <span class="blue"><i class="ace-icon fa fa-comments"></i> Klik Chat </span>
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
            $is_send = ($this->sessionid == $item['user_id']) ? '<strong class="grey">Anda</strong>' : '<strong class="blue">'.$item['fullname'].'</strong>'; 
            $is_chat = ($this->sessionid == $item['user_id']) ? 'col-sm-offset-6 col-sm-6':'col-sm-6';
            $content .= '<div class="itemdiv dialogdiv '.$is_chat.' chat-item">
                <div class="user">
                    <img alt="'.$item['fullname'].'" src="'.load_file('app/img/no-avatar.png').'">
                </div>
                <div class="body">
                    <div class="time">
                        <i class="ace-icon fa fa-clock-o"></i>
                        <span class="grey">'. selisih_wkt($item['create_chat']).'</span>
                    </div>
                    <div class="name">'.$is_send.'</div>
                    <div class="text">'.$item['isi_chat'].'</div>
                    <div class="tools hide">
                        <a href="#" class="btn btn-minier btn-info">
                            <i class="icon-only ace-icon fa fa-share"></i>
                        </a>
                    </div>
                </div>
            </div>';
        }
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
                                <span class="green"><i class="ace-icon fa fa-comment"></i> Klik Chat </span>
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
}
