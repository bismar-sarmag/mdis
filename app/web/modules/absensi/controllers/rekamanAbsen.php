<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class RekamanAbsen extends Controller {
    public function __construct() {
        parent::__construct ();
        $this->_data = array ();
        $this->load->model ( 'rekamanabsen_model' );
        isController('absensi','rekamanAbsen');
    }
    protected function _view($template, $data = array(), $result = false) {
        if ($data && is_array ( $data )) {
            return $this->load->view ( $template, $data, $result );
        }
        return $this->load->view ( $template, $this->_data, $result );
    }
    public function index() {
        redirect ( 'absensi/rekamanAbsen/view' );
    }
    protected function _executeView() {
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action' ) );
        // delete action
        if (isAccess('absensi','rekamanAbsen','delete') && $array ['action'] == 'delete' && $array ['id']) {
            if ($this->rekamanabsen_model->delete($array['id'])) {
                $this->_data['errorMessage'] =  'Berhasil delete data absensi' ;
                $this->_data['isSuccess'] =  true ;
            } else {
                $this->_data['errorMessage'] =  'Gagal delete data absensi' ;
            }
        }
    }
    public function view() {
    	if (! isAccess ( 'absensi', 'rekamanAbsen', 'view'))
            redirect (); 
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action', 'page' ) );
        $this->_executeView ();
        $array['page'] = (int) $array['page'];

        $this->load->library('pagination');
        $total = $this->rekamanabsen_model->getCountAbsen();
        if (($array['page'] + 1) > $total)
            $array['page'] = 0;
        $limit = $this->config->item('master_limit');
        $config = $this->config->item('paging');
        $config['base_url'] = site_url('absensi/rekamanAbsen/view/page/');
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        
        $this->pagination->initialize($config);
        $this->_data['paging'] =  $this->pagination->create_links();
        
        $dataView = $this->rekamanabsen_model->getList($limit,$array['page']);
        $this->_data['dataView'] = $dataView;
        $this->_data['uri_to_assoc'] = $array;
			 
        $this->_view ( 'absensi/rekamanAbsenView' );
    }
   

 protected function _executeAdd() {
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action' ) );
        
        if ($this->input->post ( 'kirim' ) == 'kirim') {
            
	    $nip = trim ( $this->input->post ( 'nip' ) );
            $tgl_absensi = trim ( $this->input->post ( 'tgl_absensi' ) );
	    $jam_masuk = trim ( $this->input->post ( 'jam_masuk' ) );
	    $jam_keluar = trim ( $this->input->post ( 'jam_keluar' ) );
	    $absen = trim ( $this->input->post ( 'absen' ) );
            
	    $data = array ();
            $data ['nip'] = $nip;
            $data ['tgl_absensi'] = $tgl_absensi;
	    $data ['jam_masuk'] = $jam_masuk;
	    $data ['jam_keluar'] = $jam_keluar;
	    $data ['absen'] = $absen;
            
	    $errors = array ();
            
	    if (empty ( $nip )) {
                $errors [] = 'Input NIP';
            } else  {
            	$this->load->model ('cek_model');
            	$cekKode = $this->rekamanabsen_model->cekKode ('absensi' , $nip);
            	if($cekKode > 0)
            	    $errors [] = 'Kode Sudah Terdaftar. Silahkan Diganti';
            }
            
            if (empty ( $tgl_absensi ))
                $errors [] = 'Input Tanggal Absensi';
		
            if ($errors) {
            	// '<b>Error</b>: <br />'.implode('<br />', $errors);
                $this->_data['errorMessage'] =  implode ( '<br />', $errors ) ;
            } elseif ($this->rekamanabsen_model->add ( $data )) {
                $this->_data['errorMessage'] =  'Berhasil Tambah Data Absen' ;
                $_POST = array();
                $this->_data['isSuccess'] =  true ;
            } else {
                $this->_data['errorMessage'] =  'Gagal Tambah Data Absen' ;
            }
        
        }
    }

    public function add() {
    	if (! isAccess ( 'absensi', 'rekamanAbsen', 'add'))
            redirect (); 
        $array = $this->uri->uri_to_assoc ( 3, array ('action' ) );
        $this->_executeAdd ();
        $this->_view ( 'absensi/rekamanAbsenAdd' );
    }
    
}