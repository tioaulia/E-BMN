<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
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
        $data['title'] = "Barang keluar";
        $data['barangkeluar'] = $this->admin->getBarangkeluar();    
        $this->template->load('templates/dashboard', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');


        
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Keluar";
            $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_keluar'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $encoded_data = str_replace('[removed]', 'data:image/jpeg;base64,', $input['gambar']);
            $img          = str_replace('data:image/jpeg;base64,', '', $encoded_data );
            $data         = base64_decode($img);
            $file_name    = 'BK_image_'.date('Y-m-d-H-i-s', time()); // You can change it to anything
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
          
      
            
            



            $insert = $this->admin->insert('barang_keluar', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangkeluar');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            }
        }
    }

   
    
    public function detail($getId)
    {
        
        $id = encode_php_tags($getId);
        $data = $this->admin->getBarangkeluarId($id);
        $barangkeluar = $data[0];
      //  var_dump($this->form_validation->run());
        
        $this->_validasi();
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Barang Peminjaman";
            $data['barangkeluar'] = $barangkeluar;
            $this->template->load('templates/dashboard', 'barang_keluar/detail', $data);

        }if($this->input->post(null, true)){



            $input = $this->input->post(null, true);
            $input['status_id'] = '1';

            $config['upload_path'] = FCPATH . "/uploads/";
            $config['allowed_types']        = 'pdf';
            $config['overwrite']			= true;
            $config['max_size']             = 10000;
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload('berkas')){
                echo "berkas Gagal Di Upload !";
                $error = array('error' => $this->upload->display_errors());
             //   var_dump($error);
            }else{
                $input['berkas'] = $this->upload->data('file_name');
            }
            $update = $this->admin->update('barang_keluar', 'id_barang_keluar',$id,$input);
           

            if ($update) {
                set_pesan('data berhasil disimpan.');
                redirect('barangkeluar/detail/'.$id);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/detail/'.$id);
            }


        }
    }
    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_keluar', 'id_barang_keluar', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }
}
