<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->model('Resep_model');
    $this->load->model('m_id');
  }

  public function index(){
    $data = array(
      'pasien' => $this->db->get('pasien')
    );
    $this->load->view('v_index',$data);
  }

  public function cetak($kd_rm){
    // ========================================================================

    // $ket = 'Semua Data Rekam Medis';
		// $alamat = 'Kp. Cibereum No.18 RT/RW 04/01 Tanjungjaya';

		// ob_start();   
		// require('assets/pdf/fpdf.php');  
		// $data['pemeriksaan'] = $this->Pemeriksaan_model->view_all(); 
		// $data['ket'] = $ket;  
		// $data['alamat'] = $alamat;
		// $this->load->view('pemeriksaan/preview', $data);

    // ======================================================================

    $data = array(
      'pasien'  => $this->db->query("SELECT * FROM pasien where kd_rm='$kd_rm'"),
    );

    ob_start();
		// require('assets/pdf/fpdf.php');
    $this->load->view('data_pasien/cetak', $data);
    // $html = $this->output->get_output();
    // $this->load->library('dompdf_gen');
    // $this->dompdf->load_html($html);
    // $this->dompdf->render();
    // $sekarang=date("d:F:Y:h:m:s");
    // $this->dompdf->stream("pendaftaran".$sekarang.".pdf",array('Attachment'=>0));
  }

  public function cetak_resep($koderesep) {
      $data = array(
        'resep'  => $this->db->query("SELECT * FROM detail_resep JOIN obat on detail_resep.id_obat = obat.id_obat WHERE kd_resep='$koderesep'"),
      );
      $data['kd_resep'] = $this->db->query("SELECT * FROM detail_resep JOIN obat on detail_resep.id_obat = obat.id_obat WHERE kd_resep='$koderesep'")->row_array();
      $this->load->view('resep_obat/cetak',$data);
      $html = $this->output->get_output();
      $this->load->library('dompdf_gen');
      $this->dompdf->load_html($html);
      $this->dompdf->render();
      $sekarang=date("d:F:Y:h:m:s");
      $this->dompdf->stream("Resep Obat".$sekarang.".pdf",array('Attachment'=>0));
  }

 public function cetak_bayar($kodebayar){
  $data = array(
    'bayar'  => $this->db->query("SELECT * FROM detail_bayar JOIN tarif on detail_bayar.id_tarif = tarif.id_tarif WHERE kd_bayar='$kodebayar'"),
  );
  $data['kd_bayar'] = $this->db->query("SELECT * FROM detail_bayar JOIN tarif on detail_bayar.id_tarif = tarif.id_tarif WHERE kd_bayar='$kodebayar'")->row_array();
  $data['obat'] = $this->db->query("SELECT * FROM resep JOIN pembayaran on resep.kd_resep = pembayaran.kd_resep JOIN admin on pembayaran.id_admin = admin.id_admin where kd_bayar = '$kodebayar'");

  ob_start();
  // require('assets/pdf/fpdf.php');
  $this->load->view('pembayaran/cetak',$data);

  // $html = $this->output->get_output();
  // $this->load->library('dompdf_gen');
  // $this->dompdf->load_html($html);
  // $this->dompdf->render();
  // $sekarang=date("d:F:Y:h:m:s");
  // $this->dompdf->stream("Pembayaran".$sekarang.".pdf",array('Attachment'=>0));
 }

}
