<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends KZ_Controller {
    
    private $module = 'master/kelas';
    private $module_do = 'master/kelas_do';
    private $url_route = array('id', 'source', 'type');   
    private $lingkup = array(array('id' => 1, 'txt' => 'Internal'), array('id' => 2, 'txt' => 'External'),
            array('id' => 3, 'txt' => 'Campuran'));
    private $mode = array(array('id' => 'O', 'txt' => 'Online'), array('id' => 'F', 'txt' => 'Offline'),
            array('id' => 'M', 'txt' => 'Campuran'));
    private $evaluasi = array(array('id' => 1, 'txt' => 'Evaluasi Akademik'), array('id' => 2, 'txt' => 'Aktivitas Partisipatif'),
            array('id' => 3, 'txt' => 'Hasil Proyek'), array('id' => 4, 'txt' => 'Kognitif/ Pengetahuan')); 
                
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_kelas','m_prodi'));
    }
    function index() {
        $this->load->model(array('m_semester'));
        
        $this->data['prodi'] = $this->m_prodi->getAll();
        $this->data['semester'] = $this->m_semester->getAll();
        
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Kelas','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->load_view('master/kelas/v_index', $this->data);
    }
    function add() {
        $this->data['edit'] = $this->m_kelas->getEmpty();
        $this->data['prodi'] = $this->m_prodi->getAll();
        
        $this->data['lingkup'] = $this->lingkup;
        $this->data['mode'] = $this->mode;
        $this->data['module'] = $this->module;
        $this->data['action'] = $this->module_do.'/add';
        $this->data['title'] = array('Kelas','Tambah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/kelas/v_form', $this->data);
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->data['edit'] = $this->m_kelas->getId(decode($id));
        $this->data['prodi'] = $this->m_prodi->getAll();
        
        $this->data['lingkup'] = $this->lingkup;
        $this->data['mode'] = $this->mode;
        $this->data['module'] = $this->module;
        $this->data['action'] = $this->module_do.'/edit/'.$id;
        $this->data['title'] = array('Kelas','Ubah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/kelas/v_form', $this->data);
    }
    function detail($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $detail = $this->m_kelas->getId(decode($id));
        $this->data['prodi'] = $this->m_prodi->getId($detail['prodi_id']);
        
        $this->data['jenis_evaluasi'] = $this->evaluasi;
        $this->data['detail'] = $detail;
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Kelas',$detail['nama_matkul']);
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/kelas/v_detail', $this->data);
    }
    function delete($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->load->model(array('m_akm'));
        //check krs
        $check = $this->m_akm->checkKrs(array('kelas_id' => decode($id)));
        if (!is_null($check)) {
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Mahasiswa telah menkontrak kelas ini'));
            redirect($this->module);
        }
        $result = $this->m_kelas->delete(decode($id));
        if ($result) {
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
                $this->_table_kelas();//index
            }else if($routing_module['source'] == 'feeder') {
                $this->_peserta_feeder();//detail
            }else if($routing_module['source'] == 'lokal') {
                $this->_peserta_lokal();//detail
            }
        }else if($routing_module['type'] == 'list') {
            if($routing_module['source'] == 'kelas') {
                $this->_get_kelas_neo();//detail
            }else if($routing_module['source'] == 'matkul') {
                $this->_get_matkul();//add,edit
            }else if($routing_module['source'] == 'dosen') {
                $this->_get_dosen();//detail
            }else if($routing_module['source'] == 'check') {
                $this->_check_kelas();//detail
            }
        }
    }
    //function
    function _table_kelas() {
        $this->load->model(array('m_akm'));
        
        $periode = decode($this->input->post('periode'));
        $prodi = decode($this->input->post('prodi'));
        $semester = $this->input->post('semester');
        $praktisi = $this->input->post('praktisi');
        
        $where = null;
        if ($periode != '') {
            $where['id_semester'] = $periode;
        }
        if ($prodi != '') {
            $where['prodi_id'] = $prodi;
        }
        if ($semester != '') {
            $where['semester_kelas'] = $semester;
        }
        if ($praktisi != ''){
            $where['is_valid'] = $praktisi;
        }
        $list = $this->m_kelas->get_datatables($where);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $items) {
            $no++;
            $row = array();
            
            $is_delete = ($items['status_kelas'] == '0') ? '<a href="#" itemid="'. encode($items['id_kelas']) .'" itemname="'. $items['nama_matkul'] .'" id="delete-btn" 
                    class="tooltip-error btn btn-white btn-danger btn-mini btn-round" data-rel="tooltip" title="Hapus Data">
                    <span class="red"><i class="ace-icon fa fa-trash-o"></i></span>
                </a>' : '<a href="'. site_url($this->module .'/edit/'. encode($items['id_kelas'])) .'" 
                        class="tooltip-warning btn btn-white btn-warning btn-sm btn-round" data-rel="tooltip" title="Ubah Data">
                        <span class="orange"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                    </a>';
            $aksi = '<div class="action-buttons">
                        '.$is_delete.'
                        <a href="'. site_url($this->module .'/detail/'. encode($items['id_kelas'])) .'" 
                            class="tooltip-success btn btn-white btn-success btn-sm btn-round" data-rel="tooltip" title="Sinkron Kelas">
                            <span class="green"><i class="ace-icon fa fa-cloud-upload bigger-120"></i></span>
                        </a>
                        <button id="check-btn" itemid="'. encode($items['id_kelas']) .'" itemprop="'. ctk($items['nama_matkul']) .'" 
                            class="tooltip-info btn btn-white btn-info btn-mini btn-round" data-rel="tooltip" title="Check Data">
                            <span class="blue"><i class="ace-icon fa fa-refresh"></i></span>
                        </button>
                    </div>';
            $peserta = $this->m_akm->countKuota(array('kelas_id' => $items['id_kelas']));
            $is_nilai = $this->m_akm->countKuota(array('kelas_id' => $items['id_kelas'], 'nilai_huruf <>' => null));
            
            $is_jadwal = empty($items['jadwal_kelas']) ? '<i class="bigger-110 fa fa-times red"></i>' : '<i class="bigger-110 fa fa-check green"></i>';
            $is_dosen = $items['is_valid'] == '1' ? ' <i class="fa fa-check green"></i>' : '';
            
            $row[] = ctk($no);
            $row[] = '<strong>'.ctk($items['nama_prodi']).'</strong><br/>'.is_periode($items['id_semester'],1);
            $row[] = '<strong>'.ctk($items['kode_matkul']).'</strong>
                      <small>['.$items['jenis_matkul'].']</small><br/>'.ctk($items['nama_matkul']);
            $row[] = '<strong class="bigger-110 red">'.ctk($items['sks_matkul']).'</strong> sks';
            $row[] = '<strong class="bigger-110">'.ctk($items['nama_kelas']).'</strong> <small>['.$items['semester_kelas'].']';
            $row[] = ctk($items['nama_dosen']).$is_dosen;
            $row[] = '[<b>'.$is_nilai['qty_mhs'].'</b>] dari '.$peserta['qty_mhs']
                    .'<br/>'.ctk($items['jumlah_mhs']).' Feeder';
            $row[] = '<strong class="orange">'.$items['kuota_kelas'].'</strong><br/>'.st_aktif($items['status_kelas']).$is_jadwal;
            $row[] = $aksi;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_kelas->count_all($where),
            "recordsFiltered" => $this->m_kelas->count_filtered($where),
            "data" => $data,
        );
        jsonResponse($output);
    }
    function _peserta_lokal() {
        $this->load->model(array('m_akm','m_mhs'));
        $id = decode($this->input->post('id'));
        
        $data = array();
        $rs = $this->m_akm->getNilai(array('n.kelas_id' => $id));
        $no = 1;
        if(count($rs['data']) > 0){
            foreach ($rs['data'] as $items) {
                $row = array();
                
                $mhs = $this->m_mhs->getId($items['mhs_id']);
                $box = $box = !in_array($mhs['status_mhs'], array('AKTIF')) ? '' : ' <label class="pos-rel">
                        <input value="'. encode($items['mhs_id']).'" id="mid" name="mid[]" type="checkbox" class="ace bigger-130" />
                        <span class="lbl"></span></label>';
                
                $row[] = $no.$box;
                $row[] = '<strong>'.$items['nama_mhs'].'</strong> - '.$items['nim'].
                        '<small class="sp-log hide"><br/>'.$items['log_nilai'].'<br/>'.format_date($items['update_nilai'],2).'</small>';
                $row[] = '<strong class="red bigger-120">'. ctk($items['nilai_huruf']). '</strong>  
                    <strong>['. ctk($items['nilai_indeks']). ']</strong>';
                $row[] = st_sinkron($items['status_krs']).' | '.st_sinkron($items['status_nilai']);
                
                $data[][] = $row;
                $no++;
            }
            jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
        }else{
            jsonResponse(array('status' => false, 'msg' => 'Data lokal tidak ditemukan'));
        }
    }
    function _peserta_feeder() {
        $this->load->model(array('m_akm','m_mhs'));
        $this->load->library(array('feeder'));
        
        $id = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetDetailNilaiPerkuliahanKelas', array('filter' => "id_kelas_kuliah='{$id}'", 'order' => 'nim ASC'));
        $data = array();
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $items) {
                    $row = array();
                    
                    $check = $this->m_akm->checkKrs(array('kelas_id' => $id, 'mhs_id' => $items['id_registrasi_mahasiswa']));
                    $mhs = $this->m_mhs->getId($items['id_registrasi_mahasiswa']);
                    $box = !in_array($mhs['status_mhs'], array('AKTIF')) ? '' : ' <label class="pos-rel">
                        <input value="'. encode($items['id_registrasi_mahasiswa']).'" id="regid" name="regid[]" type="checkbox" class="ace bigger-130" />
                        <span class="lbl"></span></label>';
                    
                    $row[] = $no.$box;
                    $row[] = '<strong>'.$items['nama_mahasiswa'].'</strong> - '.$items['nim'];
                    $row[] = '<strong class="red bigger-120">'. ctk($items['nilai_huruf']). '</strong>  
                            <strong>['. ctk($items['nilai_indeks']). ']</strong>';
                    $row[] = is_null($check) ? '<i class="ace-icon fa fa-times red bigger-110"></i>' : '<i class="ace-icon fa fa-check green bigger-110"></i>';
                    
                    $data[] = $row;
                    $no++;
                }
                $this->m_kelas->update($id, array('jumlah_mhs' => count($rs['data']), 'update_kelas' => date('Y-m-d H:i:s')));
                jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data feeder tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _check_kelas() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $row['update_kelas'] = date('Y-m-d H:i:s');
        $row['log_kelas'] = $this->sessionname.' memperbarui data dari Feeder';
        
        $rs = $this->feeder->get('GetListKelasKuliah', array('filter' => "id_kelas_kuliah='{$id}'", 'order' => 'kode_mata_kuliah asc'));
        if(!$rs['status']){
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
        if(count($rs['data']) < 1){
            $row['status_kelas'] = '0';
            $this->m_kelas->update($id, $row);
            jsonResponse(array('status' => true, 'msg' => 'Data kelas tidak ditemukan. Kelas menjadi Tidak Aktif'));
        }
        if(!empty($rs['data'][0]['id_dosen'])){
            $row['id_dosen'] = $rs['data'][0]['id_dosen'];
            $row['nama_dosen'] = $rs['data'][0]['nama_dosen'];
        }
        $row['prodi_id'] = $rs['data'][0]['id_prodi'];
        $row['id_semester'] = $rs['data'][0]['id_semester'];
        $row['id_matkul'] = $rs['data'][0]['id_matkul'];
        $row['kode_matkul'] = $rs['data'][0]['kode_mata_kuliah'];
        $row['nama_matkul'] = $rs['data'][0]['nama_mata_kuliah'];
        $row['sks_matkul'] = $rs['data'][0]['sks'];
        $row['nama_kelas'] = $rs['data'][0]['nama_kelas_kuliah'];
        $row['jumlah_mhs'] = $rs['data'][0]['jumlah_mahasiswa'];
        $row['is_valid'] = empty($rs['data'][0]['id_dosen']) ? '0' : '1';
        $row['status_kelas'] = '1';
        $update = $this->m_kelas->update($id, $row);
        if($update){
            jsonResponse(array('data' => null, 'status' => true, 'msg' => 'Data Kelas berhasil diperbarui'));
        }
    }
    function _get_kelas_neo(){
        $this->load->library(array('feeder'));
        
        $term = $this->input->post('term');
        $rs = $this->feeder->get('GetListKelasKuliah', array('filter' => 
            "(LOWER(kode_mata_kuliah) LIKE LOWER('%{$term}%') OR LOWER(nama_mata_kuliah) LIKE LOWER('%{$term}%')) AND id_semester='{$this->smtid}'"
        ));
        $data = array();
        if($rs['status']){
            foreach ($rs['data'] as $val) {
                $view = $val['nama_program_studi'].' - '.$val['kode_mata_kuliah'].' - '.$val['nama_mata_kuliah'].
                    ' ('.intval($val['sks']).' sks) '.$val['nama_kelas_kuliah'].' - '.$val['nama_dosen'];
                
                $data[] = array('id' => encode($val['id_kelas_kuliah']), 'text' => $view, 'sks' => intval($val['sks']));
            }
        }
        jsonResponse($data);
    }
    function _get_matkul(){
        $this->load->library(array('feeder'));
        
        $term = $this->input->post('term');
        $prodi = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetMatkulKurikulum', array('filter' => 
            "(LOWER(kode_mata_kuliah) LIKE LOWER('%{$term}%') OR LOWER(nama_mata_kuliah) LIKE LOWER('%{$term}%')) AND id_prodi='{$prodi}'"
        ));
        $data = array();
        if($rs['status']){
            foreach ($rs['data'] as $val) {
                $view = $val['kode_mata_kuliah'].' - '.$val['nama_mata_kuliah']
                        .' ('.intval($val['sks_mata_kuliah']).' sks) '.$val['nama_kurikulum'];
                $data[] = array('id' => encode($val['id_matkul']), 'text' => $view, 
                    'kode' => $val['kode_mata_kuliah'], 'nama' => $val['nama_mata_kuliah'], 'sks' => intval($val['sks_mata_kuliah']));
            }
        }
        jsonResponse($data);
    }
    function _get_dosen(){
        $this->load->model(array('m_dosen'));
        
        $term = $this->input->post('term');
        $tipe = $this->input->post('tipe');
        
        $result = $this->m_dosen->getAll(array('status_dosen' => $tipe), $term);
        $data = array();
        foreach ($result['data'] as $val) {
            $send = encode($val['id_dosen']) . '|' . $val['nama_dosen'] . '|' . encode($val['id_reg_dosen']);
            $data[] = array("id" => $send, "text" => $val['nama_dosen']);
        }
        jsonResponse($data);
    }
}