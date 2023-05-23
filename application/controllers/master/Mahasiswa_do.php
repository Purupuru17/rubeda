<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_do extends KZ_Controller {
    
    private $module = 'master/mahasiswa';
    private $module_do = 'master/mahasiswa_do';
    private $url_route = array('id', 'source', 'type');    
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_mhs'));
    }
    function cetak($id = NULL, $tipe = NULL, $smtid = NULL) {
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
               
        if(empty($tipe)){
            $this->_print_transkrip($detail);
        }
        if($tipe == 'akm'){
            $this->_print_akm($detail);
        }
        $this->_print_khs($detail, decode($smtid));
    }
    function export($id = NULL, $tipe = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $detail = $this->m_mhs->getId(decode($id));
        if(is_null($detail)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Mahasiswa tidak ditemukan'));
            redirect($this->module);
        }
        $this->load->model(array('m_prodi'));
        $this->load->library(array('feeder'));
        
        if(empty($tipe)){
            $this->_export_transkrip($detail);
        }
        $this->_export_khs($detail);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'table') {
            //TABLE
        }else if($routing_module['type'] == 'action') {
            //ACTION
            if($routing_module['source'] == 'tmp') {
                $this->_insert_tmp();
            }
        }
    }
    //function
    function _insert_tmp() {
        $id = ($this->input->post('id'));
        $pass = random_string('numeric', 5);
        
        if(empty(decode($id))) {
            jsonResponse(array('status' => FALSE, 'msg' => 'Tidak ada data mahasiswa terpilih'));
        }    
        $check = $this->m_mhs->getTmp(array('mhs_id' => decode($id)));
        if(is_null($check)){
            $mhs = $this->m_mhs->getId(decode($id));
            
            $data['fullname'] = $mhs['nama_mhs'];
            $data['username'] = $mhs['nim'];
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
            $data['status_user'] = '1';
            $data['id_group'] = 4;
            $data['id_user'] = random_string('unique');
            
            $data['buat_user'] = date('Y-m-d H:i:s');
            $data['ip_user'] = ip_agent();
            $data['log_user'] = $this->sessionname. ' membuat user baru';
            
            $insert = $this->m_mhs->insertTmp(decode($id), $data, $pass);
            if($insert) {
                jsonResponse(array('data' => NULL, 'status' => true, 'msg' => 'Akun untuk Mahasiswa ini berhasil dibuat'));
            }else {
                jsonResponse(array('data' => NULL, 'status' => false, 'msg' => 'Akun gagal dibuat'));
            }
        }else{
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
            $data['update_user'] = date('Y-m-d H:i:s');
            $data['ip_user'] = ip_agent();
            $data['log_user'] = $this->sessionname. ' mereset password user';
            
            $update = $this->m_mhs->updateTmp($check['user_id'], $data, array('pass_mhs' => $pass));
            if($update) {
                jsonResponse(array('data' => NULL, 'status' => true, 'msg' => 'RESET Password berhasil dilakukan'));
            }else {
                jsonResponse(array('data' => NULL, 'status' => false, 'msg' => 'Data gagal diubah'));
            }
        }
    }
    function _print_khs($detail, $smtid) {
        $id = $detail['id_mhs'];
        $filter = (!empty($smtid)) ? "id_registrasi_mahasiswa='{$id}' AND id_semester='{$smtid}'" : "id_registrasi_mahasiswa='{$id}'";
        
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
                redirect($this->module.'/detail/'.encode($id));
            }
        }else{
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module.'/detail/'.encode($id));
        }
        $this->data['detail'] = $detail; 
        $this->data['khs_print'] = $data;
        $this->data['periode'] = empty($smtid) ? 'Semua Periode' : $data['semester']; 
        $this->data['judul'] = array('KARTU HASIL STUDI (KHS)', 'IPS (Indeks Prestasi Semester)');
        $this->data['prodi'] = $this->m_prodi->getId($detail['prodi_id']);
        
        $html = $this->load->view('master/mhs/v_print_khs', $this->data, true);
        $this->fungsi->PdfGenerate($html, url_title('KHS '.$detail['nim'].' '.$detail['nama_mhs'].' '.$this->data['periode'], '-'));
    }
    function _print_akm($detail) {
        $id = $detail['id_mhs'];
        
        $rs = $this->feeder->get('GetAktivitasKuliahMahasiswa', array(
            'filter' => "id_registrasi_mahasiswa='{$detail['id_mhs']}'",
            'order' => "id_semester asc"
        ));
        if(!$rs['status']){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module.'/detail/'.encode($id));
        }
        if(count($rs['data']) < 1){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Aktivitas Kuliah tidak ditemukan'));
            redirect($this->module.'/detail/'.encode($id));
        }
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0, 'semester' => null);
        $no = 1;
        foreach ($rs['data'] as $val) {
            $row = array();

            $row[] = $no;
            $row[] = $val['nama_semester'];
            $row[] = $val['nama_status_mahasiswa'];
            $row[] = $val['ips'];
            $row[] = $val['ipk'];
            $row[] = $val['sks_semester'];
            $row[] = $val['sks_total'];
            $row[] = null;

            $data['table'][] = $row;
            
            $no++;
        }
        $this->data['detail'] = $detail; 
        $this->data['khs_print'] = $data; 
        $this->data['periode'] = '';
        $this->data['judul'] = array('AKTIVITAS PERKULIAHAN', null);
        $this->data['prodi'] = $this->m_prodi->getId($detail['prodi_id']);
        
        $html = $this->load->view('master/mhs/v_print_khs', $this->data, true);
        $this->fungsi->PdfGenerate($html,  url_title('AKM '.$detail['nim'].' '.$detail['nama_mhs'], '-'));
    }
    function _print_transkrip($detail) {
        $id = $detail['id_mhs'];
        
        $rs = $this->feeder->get('GetTranskripMahasiswa', array('filter' => "id_registrasi_mahasiswa='{$id}'", 'order' => 'kode_mata_kuliah asc'));
        $data = array('table' => array(), 'sks' => 0, 'indeks' => 0, 'ipk' => 0, 'semester' => null);
        $no = 1;
        if($rs['status']){
            if(count($rs['data']) > 0){
                foreach ($rs['data'] as $val) {
                    $row = array();
                    
                    $remidi = $val['nilai_indeks'] < 1.5 ? 'red' : 'blue';
                    
                    $row[] = $no;
                    $row[] = '';
                    $row[] = $val['kode_mata_kuliah'];
                    $row[] = ctk($val['nama_mata_kuliah']);
      $data['sks']+=$row[] = $val['sks_mata_kuliah'];
                    $row[] = '<strong class="bigger-110 '.$remidi.'">'.$val['nilai_huruf'].'</strong>';
                    $row[] = $val['nilai_indeks'];
   $data['indeks']+=$row[] = $val['sks_mata_kuliah']*$val['nilai_indeks'];
                    
                    $data['table'][] = $row;
                    $data['semester'] = '';
                    $no++;
                }
                $data['ipk'] = ($data['sks'] > 0) ? round($data['indeks']/$data['sks'],2) : 0;
            }else{
                $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Transkrip tidak ditemukan'));
                redirect($this->module.'/detail/'.encode($id));
            }
        }else{
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module.'/detail/'.encode($id));
        }
        $this->data['detail'] = $detail; 
        $this->data['khs_print'] = $data; 
        $this->data['periode'] = '';
        $this->data['judul'] = array('TRANSKRIP AKADEMIK', 'IPK (Indeks Prestasi Komulatif)');
        $this->data['prodi'] = $this->m_prodi->getId($detail['prodi_id']);
        
        $html = $this->load->view('master/mhs/v_print_khs', $this->data, true);
        $this->fungsi->PdfGenerate($html,  url_title('TRANSKRIP '.$detail['nim'].' '.$detail['nama_mhs'], '-'));
    
    }
    function _export_khs($detail) {
        $prodi = $this->m_prodi->getId($detail['prodi_id']);
        
        $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('app/img/khs.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->getProtection()->setSheet(true);
        
        $sheet->setCellValue('A2', "UNIVERSITAS PENDIDIKAN MUHAMMADIYAH (UNIMUDA) SORONG \n".strtoupper($prodi['fakultas']));
        $sheet->setCellValue('A4', 'TRANSKRIP AKADEMIK SEMENTARA');
        $sheet->setCellValue('A5', '-');
        $sheet->setCellValue('I7', $detail['nama_mhs']);
        $sheet->setCellValueExplicit('I8', $detail['nim'], 's');
        $sheet->setCellValue('I9', '-');
        $sheet->setCellValue('I10', $detail['nama_prodi']);
        $sheet->setCellValue('I11', 'Strata Satu (S1)');
        
        $rs = $this->feeder->get('GetDetailNilaiPerkuliahanKelas', array('filter' => "id_registrasi_mahasiswa='{$detail['id_mhs']}'", 'order' => 'id_semester asc, kode_mata_kuliah asc'));
        if(!$rs['status']){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module.'/detail/'.encode($detail['id_mhs']));
        }
        if(count($rs['data']) < 1){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Transkrip tidak ditemukan'));
            redirect($this->module.'/detail/'.encode($detail['id_mhs']));
        }
        $no = 1;
        $total_sks = 0;
        $total_indeks = 0;
        $row = 15;
        foreach ($rs['data'] as $key => $data) {
            if($row > 50) break;
            
            if(!empty($data['nilai_huruf']) && $key < 36){
                $total_indeks += $indeks = (int) $data['sks_mata_kuliah'] * (float) $data['nilai_indeks'];
                $total_sks += (int) $data['sks_mata_kuliah'];
                
                $sheet->setCellValue('A'.$row, $no);
                $sheet->setCellValue('B'.$row, $data['nama_mata_kuliah']);
                $sheet->setCellValue('C'.$row, $data['kode_mata_kuliah']);
                $sheet->setCellValue('D'.$row, $data['nilai_huruf']);
                $sheet->setCellValueExplicit('E'.$row, $data['nilai_indeks'] * 1,'n');
                $sheet->setCellValueExplicit('F'.$row, (int) $data['sks_mata_kuliah'],'n');
                $sheet->setCellValueExplicit('G'.$row, $indeks,'n');

                $no++;
                $row++;
            }
        }
        $row2 = 15;
        foreach ($rs['data'] as $key => $data) {
            if($row2 > 50) break;
            
            if(!empty($data['nilai_huruf']) && $key > 35){
                $total_indeks += $indeks = (int) $data['sks_mata_kuliah'] * (float) $data['nilai_indeks'];
                $total_sks += (int) $data['sks_mata_kuliah'];
                
                $sheet->setCellValue('I'.$row2, $no);
                $sheet->setCellValue('J'.$row2, $data['nama_mata_kuliah']);
                $sheet->setCellValue('L'.$row2, $data['kode_mata_kuliah']);
                $sheet->setCellValue('M'.$row2, $data['nilai_huruf']);
                $sheet->setCellValueExplicit('N'.$row2, $data['nilai_indeks'] * 1,'n');
                $sheet->setCellValueExplicit('O'.$row2, (int) $data['sks_mata_kuliah'],'n');
                $sheet->setCellValueExplicit('P'.$row2, $indeks,'n');

                $no++;
                $row2++;
            }
        }
//        $sheet->setCellValueExplicit('O51', $total_sks, 's');
//        $sheet->setCellValueExplicit('P51', $total_indeks, 's');
//        $sheet->setCellValueExplicit('L52', $total_sks, 's');
//        $sheet->setCellValueExplicit('L53', ($total_sks > 0) ? round($total_indeks/$total_sks,2) : 0, 's');
        $sheet->setCellValue('L54', '');
        $sheet->setCellValue('L55', '');
        $sheet->setCellValue('I57', '');
        $sheet->setCellValue('J63', 'Sorong, '.format_date(date('Y-m-d'),1));
        $sheet->setCellValue('J64', 'Ketua Program Studi');
        $sheet->setCellValue('J65', $detail['nama_prodi']);
        $sheet->setCellValue('J68', $prodi['ketua_prodi']);
        $sheet->setCellValue('J69', 'NIDN. '.$prodi['nidn_prodi']);
        
        $filename = url_title('Transkrip Sementara '.$detail['nim'].' '.$detail['nama_mhs'], '-', true).'.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    function _export_transkrip($detail) {
        $prodi = $this->m_prodi->getId($detail['prodi_id']);
        
        $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('app/img/khs.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->getProtection()->setSheet(true);
        
        $sheet->setCellValue('A2', "UNIVERSITAS PENDIDIKAN MUHAMMADIYAH (UNIMUDA) SORONG \n".strtoupper($prodi['fakultas']));
        $sheet->setCellValue('A4', 'TRANSKRIP AKADEMIK');
        $sheet->setCellValue('A5', 'NOMOR : PIN');
        $sheet->setCellValue('I7', $detail['nama_mhs']);
        $sheet->setCellValueExplicit('I8', $detail['nim'], 's');
        $sheet->setCellValue('I9', '-');
        $sheet->setCellValue('I10', $detail['nama_prodi']);
        $sheet->setCellValue('I11', 'Sarjana');
        
        $rs = $this->feeder->get('GetTranskripMahasiswa', array('filter' => "id_registrasi_mahasiswa='{$detail['id_mhs']}'", 'order' => 'kode_mata_kuliah asc'));
        if(!$rs['status']){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', $rs['msg']));
            redirect($this->module.'/detail/'.encode($detail['id_mhs']));
        }
        if(count($rs['data']) < 1){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data Transkrip tidak ditemukan'));
            redirect($this->module.'/detail/'.encode($detail['id_mhs']));
        }
        $no = 1;
        $total_sks = 0;
        $total_indeks = 0;
        $row = 15;
        foreach ($rs['data'] as $key => $data) {
            if($row > 50) break;
            
            if(!empty($data['nilai_huruf']) && $key < 36){
                $total_indeks += $indeks = (int) $data['sks_mata_kuliah'] * (float) $data['nilai_indeks'];
                $total_sks += (int) $data['sks_mata_kuliah'];
                
                $sheet->setCellValue('A'.$row, $no);
                $sheet->setCellValue('B'.$row, $data['nama_mata_kuliah']);
                $sheet->setCellValue('C'.$row, $data['kode_mata_kuliah']);
                $sheet->setCellValue('D'.$row, $data['nilai_huruf']);
                $sheet->setCellValueExplicit('E'.$row, $data['nilai_indeks'] * 1,'n');
                $sheet->setCellValueExplicit('F'.$row, (int) $data['sks_mata_kuliah'],'n');
                $sheet->setCellValueExplicit('G'.$row, $indeks,'n');

                $no++;
                $row++;
            }
        }
        $row2 = 15;
        foreach ($rs['data'] as $key => $data) {
            if($row2 > 50) break;
            
            if(!empty($data['nilai_huruf']) && $key > 35){
                $total_indeks += $indeks = (int) $data['sks_mata_kuliah'] * (float) $data['nilai_indeks'];
                $total_sks += (int) $data['sks_mata_kuliah'];
                
                $sheet->setCellValue('I'.$row2, $no);
                $sheet->setCellValue('J'.$row2, $data['nama_mata_kuliah']);
                $sheet->setCellValue('L'.$row2, $data['kode_mata_kuliah']);
                $sheet->setCellValue('M'.$row2, $data['nilai_huruf']);
                $sheet->setCellValueExplicit('N'.$row2, $data['nilai_indeks'] * 1,'n');
                $sheet->setCellValueExplicit('O'.$row2, (int) $data['sks_mata_kuliah'],'n');
                $sheet->setCellValueExplicit('P'.$row2, $indeks,'n');

                $no++;
                $row2++;
            }
        }
//        $sheet->setCellValueExplicit('O51', $total_sks, 's');
//        $sheet->setCellValueExplicit('P51', $total_indeks, 's');
//        $sheet->setCellValueExplicit('L52', $total_sks, 's');
//        $sheet->setCellValueExplicit('L53', ($total_sks > 0) ? round($total_indeks/$total_sks,2) : 0, 's');
        $sheet->setCellValue('L54', '');
        $sheet->setCellValue('L55', '');
        $sheet->setCellValue('I57', '');
        $sheet->setCellValue('J63', 'Sorong, '.format_date(date('Y-m-d'),1));
        $sheet->setCellValue('J64', 'Kepala Lembaga Pengembangan Pendidikan,');
        $sheet->setCellValue('J65', 'Pembelajaran dan Akademik');
        $sheet->setCellValue('J68', 'Mukhlas Triono, M.Pd.');
        $sheet->setCellValue('J69', 'NIDN. 1223118701');
        
        $filename = url_title('Transkrip Akademik '.$detail['nim'].' '.$detail['nama_mhs'], '-', true).'.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
