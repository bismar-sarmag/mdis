<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class MasterAbsen extends Controller {
    public function __construct() {
        parent::__construct ();
        $this->_data = array ();
        $this->load->model ( 'masterabsen_model' );
        isController('absensi','masterAbsen');
    }
    protected function _view($template, $data = array(), $result = false) {
        if ($data && is_array ( $data )) {
            return $this->load->view ( $template, $data, $result );
        }
        return $this->load->view ( $template, $this->_data, $result );
    }
    public function index() {
        redirect ( 'absensi/masterAbsen/view' );
    }
    protected function _executeView() {
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action' ) );
        // delete action
        if (isAccess('absensi','masterAbsen','delete') && $array ['action'] == 'delete' && $array ['id']) {
            if ($this->masterAbsen_model->delete($array['id'])) {
                $this->_data['errorMessage'] =  'Berhasil delete data absensi' ;
                $this->_data['isSuccess'] =  true ;
            } else {
                $this->_data['errorMessage'] =  'Gagal delete data absensi' ;
            }
        }
    }
    public function view() {
    	if (! isAccess ( 'absensi', 'masterAbsen', 'view'))
            redirect (); 
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action', 'page' ) );
        $this->_executeView ();
        $array['page'] = (int) $array['page'];

        $this->load->library('pagination');
        $total = $this->masterabsen_model->getCountAbsen();
        if (($array['page'] + 1) > $total)
            $array['page'] = 0;
        $limit = $this->config->item('master_limit');
        $config = $this->config->item('paging');
        $config['base_url'] = site_url('absensi/masterAbsen/view/page/');
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        
        $this->pagination->initialize($config);
        $this->_data['paging'] =  $this->pagination->create_links();
        
        $dataView = $this->masterabsen_model->getList($limit,$array['page']);
        $this->_data['dataView'] = $dataView;
        $this->_data['uri_to_assoc'] = $array;
			 
        $this->_view ( 'absensi/masterAbsenView' );
    }
   

 protected function _executeAdd() {
        $array = $this->uri->uri_to_assoc ( 3, array ('id', 'action' ) );
        
        if ($this->input->post ( 'kirim' ) == 'kirim') {
            
	    $jam_masuk = trim ( $this->input->post ( 'jam_masuk' ) );
	    $jam_pulang = trim ( $this->input->post ( 'jam_pulang' ) );
	    $harikerja = trim ( $this->input->post ( 'harikerja' ) );
            
	    $data = array ();
            $data ['hari_kerja'] = $harikerja;
	    $data ['jam_masuk'] = $jam_masuk;
	    $data ['jam_keluar'] = $jam_keluar;
	    
            
	    $errors = array ();   
            
	    if (empty ( $harikerja ))
                $errors [] = 'Input Hari Kerja';
		
	    if (empty ( $jam_masuk ))
                $errors [] = 'Input Jam Masuk';
	    
	    if (empty ( $jam_pulang ))
                $errors [] = 'Input Jam Pulang';
			
	    
            if ($errors) {
            	// '<b>Error</b>: <br />'.implode('<br />', $errors);
                $this->_data['errorMessage'] =  implode ( '<br />', $errors ) ;
            } elseif ($this->masterabsen_model->add ( $data )) {
                $this->_data['errorMessage'] =  'Berhasil Tambah Data Absen' ;
                $_POST = array();
                $this->_data['isSuccess'] =  true ;
            } else {
                $this->_data['errorMessage'] =  'Gagal Tambah Data Absen' ;
            }
        
        }
    }

    public function add() {
    	if (! isAccess ( 'absensi', 'masterAbsen', 'add'))
            redirect (); 
        $array = $this->uri->uri_to_assoc ( 3, array ('action' ) );
        $this->_executeAdd ();
        $this->_view ( 'absensi/masterAbsenAdd' );
    }
    
}