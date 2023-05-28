<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends KZ_Controller {
    
    private $module = 'channel';
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function index($url = null) {
        if(empty($url)){
            $this->data['title'] = 'Channels';
            $this->data['module'] = $this->module;
            $this->load_home('home/channel/h_index', $this->data);
            return;
        }
        $detail = $this->db->get_where('m_creator',array('slug_creator' => $url, 'status_creator' => '1'))->row_array();
        if(empty($detail)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Channel tidak tersedia untuk saat ini'));
            redirect();
        }
        $is_subs = $this->db->get_where('fk_subscribe', array('creator_id' => $detail['id_creator'], 'user_id' => $this->sessionid));
        $btn_status = ($is_subs->num_rows() > 0) ? '<button id="subs-btn" itemid="'.encode($detail['id_creator']).'"
            itemprop="'.encode(1).'" type="button" class="btn btn-success btn-sm border-none"><i class="fa fa-bell-slash"></i> Subscribed</button>' : 
            '<button id="subs-btn" itemid="'.encode($detail['id_creator']).'" itemprop="'.encode(2).'" type="button" class="btn btn-danger btn-sm"><strong><i class="fa fa-bell"></i> Subscribe</strong></button>';
        $this->data['detail'] = $detail;
        $this->data['button_subs'] = $btn_status;
        $this->data['module'] = $this->module;
        $this->data['meta'] = array('title' => $detail['nama_creator'], 'description' => $detail['nama_creator'],'thumbnail' => load_file($detail['img_creator']));
        
        $this->load_home('home/channel/h_detail', $this->data);
    }
    function subscribe() {
        $this->data['title'] = 'Subscriptions';
        $this->data['module'] = $this->module;
        $this->load_home('home/channel/h_index', $this->data);
    }
}
