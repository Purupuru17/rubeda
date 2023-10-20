<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends KZ_Controller {
    
    private $module = 'master/video';
    private $module_do = 'master/video_do';
    private $url_route = array('id', 'source', 'type');   
                
    function __construct() {
        parent::__construct();
        
        $this->_creator_id();
        $this->load->model(array('m_video'));
    }
    function index() {
        $this->data['topik'] = $this->db->get('m_topik')->result_array();
        
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Video','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->load_view('master/video/v_index', $this->data);
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->data['edit'] = $this->m_video->getId(decode($id));
        $this->data['topik'] = $this->db->get('m_topik')->result_array();
        
        $this->data['module'] = $this->module;
        $this->data['action'] = $this->module_do.'/edit/'.$id;
        $this->data['title'] = array('Video','Ubah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/video/v_form', $this->data);
    }
    function delete($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $data = $this->m_video->getId(decode($id));
        //delete
        $result = $this->m_video->delete(decode($id));
        if ($result) {
            delete_file($data['img_video']);delete_file($data['file_video']);
            
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil dihapus'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal dihapus'));
            redirect($this->module);
        }
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'table') {
            //TABLE
            if($routing_module['source'] == 'data') {
                $this->_table_data();//index
            }
        }
    }
    //function
    function _table_data() {
        $status = $this->input->post('status');
        $topik = decode($this->input->post('topik'));
        $privasi = $this->input->post('privasi');
        
        $where = null;
        if(!empty($this->cid)){
            $where['creator_id'] = $this->cid;
        }
        if ($status != '') {
            $where['status_video'] = $status;
        }
        if ($topik != '') {
            $where['topik_id'] = $topik;
        }
        if ($privasi != '') {
            $where['privasi_video'] = $privasi;
        }
        $list = $this->m_video->get_datatables($where);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $items) {
            $no++;
            $row = array();
            
            $aksi = '<div class="action-buttons">
                        <a href="'. site_url($this->module .'/edit/'. encode($items['id_video'])) .'" 
                            class="tooltip-warning btn btn-white btn-warning btn-sm btn-round" data-rel="tooltip" title="Ubah Data">
                            <span class="orange"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                        </a>
                        <button itemid="'. encode($items['id_video']) .'" itemname="'. $items['judul_video'] .'" id="delete-btn" 
                            class="tooltip-error btn btn-white btn-danger btn-mini btn-round" data-rel="tooltip" title="Hapus Data">
                            <span class="red"><i class="ace-icon fa fa-trash-o"></i></span>
                        </button>
                    </div>';
            $row[] = ctk($no);
            $row[] = '<a class="bolder" href="'.site_url('video/'.$items['slug_video']).'" target="_blank">'
                    .ctk($items['judul_video']).'</a>';
            $row[] = ctk($items['judul_topik']);
            $row[] = st_privasi($items['privasi_video']);
            $row[] = '<strong>'.array_find($items['usia_video'], load_array('st_usia')).'</strong>';
            $row[] = '<strong>'.ctk($items['nama_creator']).'</strong>';
            $row[] = st_aktif($items['status_video']).'<div class="space-4"></div>
                    <img class="img-thumbnail lazyload blur-up" width="80" src="'.load_file($items['img_video']).'" />';
            $row[] = $aksi;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_video->count_all($where),
            "recordsFiltered" => $this->m_video->count_filtered($where),
            "data" => $data,
        );
        jsonResponse($output);
    }
}