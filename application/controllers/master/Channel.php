<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends KZ_Controller {
    
    private $module = 'master/channel';
    private $module_do = 'master/channel_do';
    private $url_route = array('id', 'source', 'type');   
                
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_creator'));
    }
    function index() {
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Channel','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->load_view('master/channel/v_index', $this->data);
    }
    function add($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->session->set_userdata(array('cid' => decode($id)));
        $this->session->set_flashdata('notif', notif('success', 'Informasi', $this->sessionname.' terhubung akun creator'));
        redirect($this->module);
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->data['edit'] = $this->m_creator->getId(decode($id));
        
        $this->data['module'] = $this->module;
        $this->data['action'] = $this->module_do.'/edit/'.$id;
        $this->data['title'] = array('Channel','Ubah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/channel/v_form', $this->data);
    }
    function delete($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $check = $this->db->get_where('m_video', array('creator_id' => decode($id)))->row_array();
        if(!is_null($check)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data gagal dihapus. 
                Data ini digunakan oleh data lainnya'));
            redirect($this->module);
        }
        $data = $this->m_creator->getId(decode($id));
        //delete
        $result = $this->m_creator->delete(decode($id));
        if ($result) {
            delete_file($data['img_creator']);
            
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
        }else if($routing_module['type'] == 'action') {
            if($routing_module['source'] == 'valid') {
                $this->_valid_data();
            }
        }
    }
    //function
    function _table_data() {
        $status = $this->input->post('status');
        $kerja = $this->input->post('kerja');
        $lokasi = $this->input->post('lokasi');
        
        $where = null;
        if ($status != '') {
            $where['status_creator'] = $status;
        }
        if ($kerja != '') {
            $where['kerja_creator'] = $kerja;
        }
        if ($lokasi != '') {
            $where['lokasi_creator'] = $lokasi;
        }
        $list = $this->m_creator->get_datatables($where);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $items) {
            $no++;
            $row = array();
            
            $is_valid = ($items['status_creator'] != '0') ? '<button id="reload-btn" itemid="'. encode($items['id_creator']) .'" itemname="'. ctk($items['nama_creator']) .'" 
                            class="tooltip-warning btn btn-white btn-warning btn-sm btn-round" data-rel="tooltip" title="Batalkan Validasi">
                            <span class="orange"><i class="ace-icon fa fa-times bigger-120"></i></span>
                        </button>' : '<button id="valid-btn" itemid="'. encode($items['id_creator']) .'" itemname="'. ctk($items['nama_creator']) .'" 
                            class="tooltip-success btn btn-white btn-success btn-sm btn-round" data-rel="tooltip" title="Validasi Data">
                            <span class="green"><i class="ace-icon fa fa-check-square-o bigger-120"></i></span>
                        </button>';
            $aksi = '<div class="action-buttons">
                        <a href="'. site_url($this->module .'/add/'. encode($items['id_creator'])) .'" 
                            class="tooltip-default btn btn-white btn-default btn-sm btn-round" data-rel="tooltip" title="Change Data">
                            <span class="grey"><i class="ace-icon fa fa-refresh bigger-120"></i></span>
                        </a>
                        '.$is_valid.'
                        <button itemid="'. encode($items['id_creator']) .'" itemname="'. $items['nama_creator'] .'" id="delete-btn" 
                            class="tooltip-error btn btn-white btn-danger btn-mini btn-round" data-rel="tooltip" title="Hapus Data">
                            <span class="red"><i class="ace-icon fa fa-trash-o"></i></span>
                        </button>
                    </div>';
            $row[] = ctk($no);
            $row[] = '<a class="bolder" href="'.site_url('channel/'.$items['slug_creator']).'" target="_blank">'
                    .ctk($items['nama_creator']).'</a>';
            $row[] = ctk($items['usia_creator']);
            $row[] = ctk($items['telepon_creator']);
            $row[] = ctk($items['kerja_creator']);
            $row[] = ctk($items['lokasi_creator']);
            $row[] = st_aktif($items['status_creator']).
                    '<div class="space-4"></div><img class="img-thumbnail img-circle lazyload blur-up" width="80" src="'.load_file($items['img_creator']).'" />';
            $row[] = $aksi;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_creator->count_all($where),
            "recordsFiltered" => $this->m_creator->count_filtered($where),
            "data" => $data,
        );
        jsonResponse($output);
    }
    function _valid_data() {
        $id = decode($this->input->post('id'));
        $status = $this->input->post('status');
        
        $data['status_creator'] = $status;
        $data['update_creator'] = date('Y-m-d H:i:s');
        $data['log_creator'] = $this->sessionname.' memvalidasi pendaftaran akun';
        
        $result = $this->m_creator->update($id, $data);
        if ($result){
            jsonResponse(array('status' => true, 
                'msg' => $status == '1' ? 'Data berhasil di validasi. Akun sudah di izinkan mengupload video':'Validasi telah berhasil di batalkan'));
        } else {
            jsonResponse(array('status' => false, 'msg' => 'Data gagal di ubah'));
        }
    }
}