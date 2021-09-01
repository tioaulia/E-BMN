<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Barang Masuk";
        $data['barangmasuk'] = $this->admin->getBarangMasuk();
        $this->template->load('templates/dashboard', 'barang_masuk/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Pengembalian', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'T-BM-' . date('dmy');
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'id_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_masuk'] = $kode . $number;

            
            $this->template->load('templates/dashboard', 'barang_masuk/add', $data);
        } else {


            $input = $this->input->post(null, true);
 
            $encoded_data = str_replace('[removed]', 'data:image/jpeg;base64,', $input['gambar']);
            $img          = str_replace('data:image/jpeg;base64,', '', $encoded_data );
            $data         = base64_decode($img);
            $file_name    = 'BM_image_'.date('Y-m-d-H-i-s', time()); // You can change it to anything
            $file         = 'uploads/' . $file_name . '.jpg';
            $success      = file_put_contents($file, $data);
            
            $input['gambar'] =  $file_name.'.jpg';
            // var_dump($img);
            // die();

            $config['upload_path'] = FCPATH . "/uploads/";
            $config['allowed_types']        = 'pdf';
            $config['overwrite']			= true;
            $config['max_size']             = 10000;
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload('berkas')){
                echo "berkas Gagal Di Upload !";
                $error = array('error' => $this->upload->display_errors());
                var_dump($error);
            }else{
                $input['berkas'] = $this->upload->data('file_name');
            }
            var_dump($config);
           // die();
          
      
            

            $insert = $this->admin->insert('barang_masuk', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangmasuk');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }
    public function kondisi()
    {
        
       
        $this->_validasi();
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Data Peminjaman";
            $data['barangmasuk'] = $this->admin->getBarangMasuk();
            $this->template->load('templates/dashboard', 'barang_masuk/kondisi', $data);
    }
}
    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangmasuk');
    }
}
