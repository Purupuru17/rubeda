<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends KZ_Controller {
    
    private $module = 'master/mahasiswa';
    private $module_do = 'master/mahasiswa_do';
    private $url_route = array('id', 'source', 'type');    
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_mhs'));
        
        $this->_prodi_id();
    }
    function index() {
        $this->data['prodi'] = $this->m_prodi->getAll();
        $this->data['prodi_id'] = $this->pid;
        
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Mahasiswa','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->load_view('master/mhs/v_index', $this->data);
    }
    function add($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->data['detail'] = $this->m_mhs->getId(decode($id));
        if(!in_array($this->data['detail']['status_mhs'], array('AKTIF'))){
            $this->session->set_flashdata('notif', notif('warning', 'Informasi', 'Status Mahasiswa bermasalah, akun tidak dapat dibuat'));
            redirect($this->module);
        }
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Mahasiswa','Tambah Akun');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/mhs/v_add', $this->data);
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->session->set_userdata(array('mid' => decode($id)));
        $this->session->set_flashdata('notif', notif('success', 'Informasi', $this->sessionname.' terhubung akun mahasiswa'));
        redirect($this->module);
    }
    function detail($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->load->model(array('m_biaya','m_semester'));
        
        $this->data['is_admin'] = ($this->sessionlevel == '1') ? true : false;
        $this->data['semester'] = $this->m_semester->getAll();
        $this->data['detail'] = $this->m_mhs->getId(decode($id));
        $this->data['akun'] = $this->m_mhs->getTmp(array('mhs_id' => decode($id)));
        $this->data['pa'] = $this->m_mhs->getPA(array('mhs_id' => decode($id)),'row');
        $this->data['biaya'] = $this->m_biaya->getMulti(array('mhs_id' => decode($id)));
        
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Mahasiswa', $this->data['detail']['nama_mhs']);
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/mhs/v_detail', $this->data);
    }
    function delete($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $result = $this->m_mhs->delete(decode($id));
        if ($result) {
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil dihapus'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal dihapus'));
            redirect($this->module);
        }
    }
    function cetak($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $detail = $this->m_mhs->getId(decode($id));
        if(is_null($detail)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Mahasiswa tidak ditemukan'));
            redirect($this->module);
        }
        $this->load->model(array('m_prodi'));
        $this->load->library(array('feeder','fungsi'));
               
        $filter = "id_registrasi_mahasiswa='{$detail['id_mhs']}' AND id_semester='{$this->smtid}'";
        $rs = $this->feeder->get('GetDetailNilaiPerkuliahanKelas', array('filter' => $filter, 'order' => 'id_semester asc, kode_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0, 'semester' => null);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = doubleval($val['nilai_indeks']) < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = $val['nama_semester'];
                    $row[] = $val['kode_mata_kuliah'];
                    $row[] = ctk($val['nama_mata_kuliah']);
    $data['sks'] += $row[] = $val['sks_mata_kuliah'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf'].'</strong>';
                    $row[] = $val['nilai_indeks'];
 $data['indeks'] += $row[] = intval($val['sks_mata_kuliah']) * doubleval($val['nilai_indeks']);
                    
                    $data['table'][] = $row;
                    $data['semester'] = $val['nama_semester'];
                    $no++;
                }
                $data['ipk'] = ($data['sks'] > 0) ? round($data['indeks']/$data['sks'],2) : 0;
            }else{
                $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data KHS tidak ditemukan'));
                redirect($this->module);
            }
        }else{
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module);
        }
        $this->data['detail'] = $detail; 
        $this->data['khs_print'] = $data;
        $this->data['periode'] = $this->smtname; 
        $this->data['judul'] = array('KARTU HASIL STUDI (KHS)', 'IPS (Indeks Prestasi Semester)');
        $this->data['prodi'] = $this->m_prodi->getId($detail['prodi_id']);
        
        $html = $this->load->view('master/mhs/v_print_khs', $this->data, true);
        $title = url_title('KHS '.$detail['nim'].' '.$detail['nama_mhs'].' '.$this->data['periode'], '-');
        
        $this->fungsi->PdfGenerate($html, $title, 1);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'table') {
            //TABLE
            if($routing_module['source'] == 'mhs') {
                $this->_table_mhs();
            }else if($routing_module['source'] == 'bio') {
                $this->_get_mhs();
            }else if($routing_module['source'] == 'krs') {
                $this->_krs_mhs();
            }else if($routing_module['source'] == 'nilai') {
                $this->_nilai_mhs();
            }else if($routing_module['source'] == 'akm') {
                $this->_akm_mhs();
            }else if($routing_module['source'] == 'transkrip') {
                $this->_transkrip_mhs();
            }else if($routing_module['source'] == 'transfer') {
                $this->_transfer_mhs();
            }else if($routing_module['source'] == 'merdeka') {
                $this->_merdeka_mhs();
            }else if($routing_module['source'] == 'tmp') {
                $this->_get_tmp();
            }
        }
    }
    //function
    function _table_mhs() {
        $prodi = decode($this->input->post('prodi'));
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');
        $akm = $this->input->post('akm');
        
        $where = null;
        if ($prodi != '') {
            $where['prodi_id'] = $prodi;
        }
        if(!is_null($this->pid)){
            $where['prodi_id'] = $this->pid;
        }
        if ($tahun != '') {
            $where['angkatan'] = $tahun;
        }
        if ($status != '') {
            $where['status_mhs'] = $status;
        }
        if ($akm != '') {
            $where['akm_mhs'] = ($akm == '1') ? null:$this->smtid;
        }
        $list = $this->m_mhs->get_datatables($where);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $items) {
            $no++;
            $row = array();
            
            $st_hide = in_array($items['status_mhs'], array('AKTIF')) ? '' : 'hide';
            $btn_delete = $this->sessionlevel != '1' || $items['status_mhs'] == 'AKTIF' ? '' : '<a href="#" itemid="'. encode($items['id_mhs']) .'" itemname="'. $items['nama_mhs'] .'" id="delete-btn" 
                    class="tooltip-error btn btn-white btn-danger btn-mini btn-round" data-rel="tooltip" title="Hapus Data">
                    <span class="red"><i class="ace-icon fa fa-trash-o"></i></span>
                </a>'; 
            $aksi = '<div class="action-buttons">
                        <a href="'. site_url($this->module .'/detail/'. encode($items['id_mhs'])) .'" 
                            class="tooltip-info btn btn-white btn-info btn-sm btn-round" data-rel="tooltip" title="Lihat Data">
                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                        </a>
                        <a href="'. site_url($this->module .'/add/'. encode($items['id_mhs'])) .'" 
                            class="'.$st_hide.' tooltip-success btn btn-white btn-success btn-sm btn-round" data-rel="tooltip" title="Tambah Data">
                            <span class="green"><i class="ace-icon fa fa-user-plus bigger-120"></i></span>
                        </a>
                        <a target="_blank" href="'. site_url($this->module .'/cetak/'. encode($items['id_mhs'])) .'" 
                            class="hide tooltip-default btn btn-white btn-default btn-mini btn-round" data-rel="tooltip" title="Cetak KHS">
                            <span class="grey"><i class="ace-icon fa fa-print"></i></span>
                        </a>
                        '.$btn_delete.'
                    </div>';
            $is_akm = ($this->smtid == $items['akm_mhs']) ? ' <i class="fa fa-check-square-o blue hide"></i>' : '';
            
            $row[] = ctk($no);
            $row[] = '<strong class="blue">'.ctk($items['nim']).'</strong>';
            $row[] = '<strong class="">'.ctk($items['nama_mhs']).'</strong>';
            $row[] = ctk($items['nama_prodi']).' - '.ctk($items['angkatan']);
            $row[] = ctk($items['kelamin_mhs']);
            $row[] = st_mhs($items['status_mhs']).$is_akm;
            $row[] = $aksi;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_mhs->count_all($where),
            "recordsFiltered" => $this->m_mhs->count_filtered($where),
            "data" => $data,
        );
        jsonResponse($output);
    }
    function _krs_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $filter = "id_registrasi_mahasiswa='{$id}' AND id_semester='{$this->smtid}'";
        $rs = $this->feeder->get('GetDetailNilaiPerkuliahanKelas', array('filter' => $filter, 'order' => 'kode_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $row[] = $no;
                    $row[] = $val['nama_semester'];
                    $row[] = $val['kode_mata_kuliah'];
                    $row[] = '<strong>'.$val['nama_mata_kuliah'].'</strong>';
                    $row[] = '<strong class="blue">'.$val['nama_kelas_kuliah'].'</strong>';
     $data['sks']+= $row[] = $val['sks_mata_kuliah'];
                    
                    $data['table'][] = $row;
                    $no++;
                }
                jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _nilai_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        $smt = decode($this->input->post('smt'));
        
        $filter = (!empty($smt)) ? "id_registrasi_mahasiswa='{$id}' AND id_semester='{$smt}'" : "id_registrasi_mahasiswa='{$id}'";
        $rs = $this->feeder->get('GetDetailNilaiPerkuliahanKelas', array('filter' => $filter, 'order' => 'id_semester asc, kode_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = doubleval($val['nilai_indeks']) < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = $val['nama_semester'];
                    $row[] = $val['kode_mata_kuliah'];
                    $row[] = '<strong>'.ctk($val['nama_mata_kuliah']).' - <span class="blue">'.$val['nama_kelas_kuliah'].'</span></strong>';
    $data['sks'] += $row[] = $val['sks_mata_kuliah'];
                    $row[] = $val['nilai_angka'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf'].'</strong>';
                    $row[] = $val['nilai_indeks'];
 $data['indeks'] += $row[] = intval($val['sks_mata_kuliah']) * doubleval($val['nilai_indeks']);
                    
                    $data['table'][] = $row;
                    $no++;
                }
                $data['ipk'] = ($data['sks'] > 0) ? round($data['indeks']/$data['sks'],2) : 0;
                jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _akm_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetAktivitasKuliahMahasiswa', array(
            'filter' => "id_registrasi_mahasiswa='{$id}'",
            'order' => "id_semester asc"
        ));
        $data = array();
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $row[] = $no;
                    $row[] = $val['nama_semester'];
                    $row[] = $val['nama_status_mahasiswa'];
                    $row[] = $val['ips'];
                    $row[] = $val['ipk'];
                    $row[] = $val['sks_semester'];
                    $row[] = $val['sks_total'];
                    
                    $data[] = $row;
                    $no++;
                }
                jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _transkrip_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetTranskripMahasiswa', array('filter' => "id_registrasi_mahasiswa='{$id}'", 'order' => 'kode_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = $val['nilai_indeks'] < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = $val['kode_mata_kuliah'];
                    $row[] = '<strong>'.ctk($val['nama_mata_kuliah']).'</strong>';
      $data['sks']+=$row[] = $val['sks_mata_kuliah'];
                    $row[] = $val['nilai_angka'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf'].'</strong>';
                    $row[] = $val['nilai_indeks'];
   $data['indeks']+=$row[] = $val['sks_mata_kuliah']*$val['nilai_indeks'];
                    
                    $data['table'][] = $row;
                    $no++;
                }
                $data['ipk'] = ($data['sks'] > 0) ? round($data['indeks']/$data['sks'],2) : 0;
                jsonResponse(array('data' => $data ,'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _transfer_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetNilaiTransferPendidikanMahasiswa', array('filter' => "id_registrasi_mahasiswa='{$id}'", 'order' => 'kode_matkul_diakui asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = $val['nilai_angka_diakui'] < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = $val['kode_mata_kuliah_asal'];
                    $row[] = '<strong>'.$val['nama_mata_kuliah_asal'].'</strong>';
                    $row[] = $val['sks_mata_kuliah_asal'];
                    $row[] = '<strong class="orange">'.$val['nilai_huruf_asal'].'</strong>';
                    
                    $row[] = $val['kode_matkul_diakui'];
                    $row[] = '<strong>'.$val['nama_mata_kuliah_diakui'].'</strong>';
      $data['sks']+=$row[] = $val['sks_mata_kuliah_diakui'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf_diakui'].'</strong>';
                    $row[] = $val['nilai_angka_diakui'];
                    
                    $data['table'][] = $row;
                    $no++;
                }
                jsonResponse(array('data' => $data ,'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _merdeka_mhs() {
        $this->load->library(array('feeder'));
        $id = decode($this->input->post('id'));
        
        $rs = $this->feeder->get('GetListKonversiKampusMerdeka', array('filter' => "nim='{$id}'", 'order' => 'nama_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = doubleval($val['nilai_indeks']) < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = $val['nama_semester'];
                    $row[] = '<small>'.ctk($val['judul']).'</small>';
                    $row[] = '<strong>'.ctk($val['nama_mata_kuliah']).'</strong>';
    $data['sks'] += $row[] = $val['sks_mata_kuliah'];
                    $row[] = $val['nilai_angka'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf'].'</strong>';
                    $row[] = $val['nilai_indeks'];
                    
                    $data['table'][] = $row;
                    $no++;
                }
                jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
            }else{
                jsonResponse(array('status' => false, 'msg' => 'Data tidak ditemukan'));
            }
        }else{
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
    }
    function _get_mhs() {
        $id = decode($this->input->post('id'));
        if(empty($id)) {
            jsonResponse(array('status' => FALSE, 'msg' => 'ID masih kosong'));
        }
        $this->load->library(array('feeder'));
        $rs = $this->feeder->get('GetListMahasiswa', array('limit' => 1, 'filter' => "id_registrasi_mahasiswa='{$id}'"));
        if (!$rs['status']) {
            jsonResponse(array('data' => NULL, 'status' => false, 'msg' => $rs['msg']));
        }
        if (count($rs['data']) < 1) {
            jsonResponse(array('data' => NULL, 'status' => false, 'msg' => 'Data tidak ditemukan'));
        }
        $row['id_mahasiswa'] = $rs['data'][0]['id_mahasiswa'];
        $row['prodi_id'] = $rs['data'][0]['id_prodi'];
        $row['nama_prodi'] = str_replace('S1 ','',$rs['data'][0]['nama_program_studi']);
        $row['nama_mhs'] = strtoupper($rs['data'][0]['nama_mahasiswa']);
        $row['nim'] = $rs['data'][0]['nim'];
        $row['angkatan'] = substr($rs['data'][0]['id_periode'],0,4);
        $row['kelamin_mhs'] = ($rs['data'][0]['jenis_kelamin'] == 'P') ? 'Perempuan' : 'Laki-Laki';
        $row['status_mhs'] = strtoupper($rs['data'][0]['nama_status_mahasiswa']);
        $row['lahir_mhs'] = date('Y-m-d',strtotime($rs['data'][0]['tanggal_lahir']));
        $row['agama_mhs'] = $rs['data'][0]['nama_agama'];

        $row['update_mhs'] = date('Y-m-d H:i:s');
        $row['log_mhs'] = $this->sessionname.' memperbarui data dari Feeder';
        
        $update = $this->m_mhs->update($id, $row);
        if($update){
            jsonResponse(array('data' => $rs['data'][0], 'status' => true, 'msg' => 'Data ditemukan dan diperbarui'));
        }
    }
    function _get_tmp() {
        $id = ($this->input->post('id'));
        if(empty(decode($id))) {
            jsonResponse(array('status' => FALSE, 'msg' => 'Tidak ada data mahasiswa terpilih'));
        }
        $user = $this->m_mhs->getTmp(array('mhs_id' => decode($id)));
        $data = array();
        if(!is_null($user)){
            $data['Nama Lengkap'] = $user['fullname'];
            $data['Username'] = '<span class="bigger-120 blue">'.$user['username'].'</span>';
            $data['Password'] = '<span class="bigger-120 red">'.$user['pass_mhs'].'</span>';
            $data['**'] = '';
            $data['Dibuat Pada'] = format_date($user['buat_user'],2);
            $data['Terakhir Ubah'] = format_date($user['update_user'],2);
            $data['Terakhir Login'] = selisih_wkt($user['last_login']);
            $data['Log Akun'] = $user['log_user'];
        }
        if(count($data) > 0){
            jsonResponse(array('data' => $data, 'status' => true, 'msg' => 'Data ditemukan'));
        }else{
            jsonResponse(array('data' => $data, 'status' => false, 'msg' => 'Akun tidak ditemukan'));
        }
    }
    function export() {
        if(!$this->_validation($this->rules_export)){
            redirect($this->module);
        }
        $prodi = decode($this->input->post('prodi'));
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');
        
        if ($prodi != '') {
            $where['prodi_id'] = $prodi;
        }
        if (!is_null($this->pid)){
            $where['prodi_id'] = $this->pid;
        }
        if ($tahun != '') {
            $where['angkatan'] = $tahun;
        }
        if ($status != '') {
            $where['status_mhs'] = $status;
        }
        $result = $this->m_mhs->getAll($where);
        
        if($result['rows'] < 1){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Mahasiswa tidak ditemukan'));
            redirect($this->module);
        }
        $title = $result['data'][0]['nama_prodi'];
        $title .= empty($tahun) ? '' : ' '.$tahun;
        $title .= empty($status) ? '' : ' '.$status;
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Mahasiswa');
        
        $fields = array('No', 'NIM', 'Nama Lengkap', 'Angkatan','Program Studi', 
            'Status', 'Tanggal Lahir', 'Jenis Kelamin', 'Agama' ,'Telepon', 'Alamat');
        $col = 1;
        foreach ($fields as $field) {
            $sheet->setCellValueByColumnAndRow($col, 1, $field);
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
            $col++;
        }
        $no = 1;
        $row = 2;
        $filename = url_title($title,'dash', TRUE).'.xls';
        foreach ($result['data'] as $val) {
            $sheet->setCellValue('A' . $row, $no)
                ->setCellValueExplicit('B' . $row, $val['nim'], 's')
                ->setCellValue('C' . $row, $val['nama_mhs'])
                ->setCellValue('D' . $row, $val['angkatan'])
                ->setCellValue('E' . $row, $val['nama_prodi'])
                ->setCellValue('F' . $row, $val['status_mhs'])
                ->setCellValue('G' . $row, format_date($val['lahir_mhs'],1))
                ->setCellValue('H' . $row, $val['kelamin_mhs'])
                ->setCellValue('I' . $row, $val['agama_mhs'])
                ->setCellValue('J' . $row, $val['telepon_mhs'])
                ->setCellValue('K' . $row, $val['alamat_mhs']);

            $no++;
            $row++;
        }
        $tableStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => array('horizontal' => 'center', 'vertical' => 'center', 'wrapText' => false)
        ];
        $boldStyle = array(
            'font' => array('size' => 12, 'bold' => true, 'color' => array('rgb' => '000000'))
        );
        $row--;
        $sheet->getStyle('A1:K' . $row)->applyFromArray($tableStyle);
        $sheet->getStyle('A1:K1')->applyFromArray($boldStyle);
        
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
    private $rules_export = array(
        array(
            'field' => 'prodi',
            'label' => 'Program Studi',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'tahun',
            'label' => 'Angkatan',
            'rules' => 'trim|xss_clean'
        )
    );
}