<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;

class Feeder {
    
    const user_pddikti = '141010';
    const pass_pddikti = '210722';
    
    protected $_CI;
    public $token = '';

    function __construct() {
        $this->_CI = & get_instance();
        if(empty($this->token)){
            $this->_token();
        }
    }
    private function _restAPI($data, $method = 'POST', $url = '', $option = array()) {
        $uri = (ENVIRONMENT == 0) ? 'localhost' : '103.226.138.149';
        $client = new Client(['base_uri' => 'http://'.$uri.':3003/ws/live2.php', 'timeout' => 30]);
        try {
            $option['headers'] = ['Accept' => 'application/json'];
            $option['form_params'] = $data;
            $response = $client->request($method, $url, $option);
            return json_decode($response->getBody()->getContents(), true);
        }catch (RequestException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody()->getContents());
            if(is_null($body)){ return ['error_code' => $response->getStatusCode(), 'error_desc' => 'Response not found'];}
            
            return [ 'error_code' => $response->getStatusCode(),'error_desc' => $body->message ];
        }catch (ClientException $e) {
            return ['error_code' => -1, 'error_desc' => 'Koneksi tidak stabil CE', 'data' => $e->getMessage() ];
        }catch (ConnectException $e) {
            return ['error_code' => -2, 'error_desc' => 'Koneksi tidak stabil CNE',  'data' => $e->getMessage()];
        }catch (BadResponseException $e) {
            return ['error_code' => -3, 'error_desc' => 'Koneksi tidak stabil BR', 'data' => $e->getMessage()];
        }        
    }
    private function _token() {
        //Get Token
        $where['act'] = 'GetToken';
        $where['username'] = self::user_pddikti;
        $where['password'] = self::pass_pddikti;
        
        $rs = $this->_restAPI($where);
        if($rs['error_code'] === 0){
            $this->token = $rs['data']['token'];
        }
    }
    public function get($action, $where = null){
        $limit = element('limit', $where, '');
        $filter = element('filter', $where, '');
        $order = element('order', $where, '');
        $offset = element('offset', $where, 0);
        
        $data = array('token' => $this->token, 'act' => $action,
            'filter' => $filter,
            'order' => $order,
            'limit' => $limit,
            'offset' => $offset
        );
        $rs = $this->_restAPI($data);
        
        $status = ($rs['error_code'] == 0) ? true : false;
        return ['status' => $status, 'msg' => $rs['error_desc'], 'data' => $rs['data'], 'code' => $rs['error_code']];
    }
    public function post($action, $record){
        $data['token'] = $this->token;
        $data['act'] = $action;
        $data['record'] = $record;
        
        $rs = $this->_restAPI($data);
        
        $status = ($rs['error_code'] == 0) ? true : false;
        return ['status' => $status, 'msg' => $rs['error_desc'], 'data' => $rs['data'], 'code' => $rs['error_code']];
    }
    public function update($action, $key, $record){
        $data['token'] = $this->token;
        $data['act'] = $action;
        $data['key'] = $key;
        $data['record'] = $record;
        
        $rs = $this->_restAPI($data);
        
        $status = ($rs['error_code'] == 0) ? true : false;
        return ['status' => $status, 'msg' => $rs['error_desc'], 'data' => $rs['data'], 'code' => $rs['error_code']];
    }
    public function delete($action, $key){
        $data['token'] = $this->token;
        $data['act'] = $action;
        $data['key'] = $key;
        
        $rs = $this->_restAPI($data);
        
        $status = ($rs['error_code'] == 0) ? true : false;
        return ['status' => $status, 'msg' => $rs['error_desc'], 'data' => $rs['data'], 'code' => $rs['error_code']];
    }
    public function ipk($id, $smtid){
        $data = array('list' => array(), 'table' => array(), 'sks' => 0, 'ips' => 0, 'total' => 0, 'ipk' => 0);
        $rs = $this->get('GetDetailNilaiPerkuliahanKelas', array('filter' => "id_registrasi_mahasiswa='{$id}' AND id_semester <='{$smtid}'"));
        
        if(!$rs['status']){
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
        if(count($rs['data']) > 0){
            $indeks_ips = 0; $indeks_ipk = 0;
            foreach ($rs['data'] as $val) {
                if($smtid == $val['id_semester']){
                    $data['sks'] += $val['sks_mata_kuliah'];
                    $indeks_ips += $val['sks_mata_kuliah']*$val['nilai_indeks'];
                    $data['list'][] = $val;
                }
                $data['total'] += $val['sks_mata_kuliah'];
                $indeks_ipk += $val['sks_mata_kuliah']*$val['nilai_indeks'];
                $data['table'][] = $val;
            }
            $data['ips'] = ($data['sks'] > 0) ? round($indeks_ips/$data['sks'],2) : 0;
            $data['ipk'] = ($data['total'] > 0) ? round($indeks_ipk/$data['total'],2) : 0;
        }
        return $data;
    }
    public function akm($id, $smtid){
        $data = array('table' => array(), 'status_mhs' => null, 'sks' => 0, 'ips' => 0, 'biaya_smt' => 2000000);
        $rs = $this->get('GetAktivitasKuliahMahasiswa', array('filter' => "id_registrasi_mahasiswa='{$id}'", 'order' => "id_semester asc"));
        
        if(!$rs['status']){
            jsonResponse(array('status' => false, 'msg' => $rs['msg']));
        }
        if(count($rs['data']) > 0){
            foreach ($rs['data'] as $val) {
                if($smtid == $val['id_semester']){
                    $data['status_mhs'] = $val['id_status_mahasiswa'];
                    $data['sks'] = $val['sks_semester'];
                    $data['ips'] = $val['ips'];
                    $data['biaya_smt'] = ((int)$val['biaya_kuliah_smt'] == 0 && $val['id_status_mahasiswa']!='N') ? 2000000:(int)$val['biaya_kuliah_smt'];
                }
                $data['table'][] = $val;
            }
        }
        return $data;
    }
}

