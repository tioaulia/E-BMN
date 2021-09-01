<div class="container-fluid">
<div class="container mt-12 mb-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header alert alert-success">
                    Upload Berkas Peminjaman Anda
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td>:</td>
                            <td><?php echo $barangkeluar->id_barang_keluar;?></td>
                        </tr>
                        <tr>
                            <th>Kode BMN</th>
                            <td>:</td>
                            <td><?php echo $barangkeluar->kode_bmn;?></td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>:</td>
                            <td><?php echo $barangkeluar->nama_barang;?></td>
                        </tr>
                        <tr>
                            <th>Operator Peminjaman</th>
                            <td>:</td>
                            <td><?php echo $barangkeluar->nama;?></td>
                        </tr>

                        <tr>
                            <th>Bukti Pembayaran</th>
                            <td>:</td>
                            <?php if($barangkeluar->berkas != ''){?>
                            <td><a href="<?php echo base_url() ?>uploads/<?php echo $barangkeluar->berkas;?>"><?php echo $barangkeluar->berkas ?></a></td>
                            <?php } ?>

                            <?php if(!$barangkeluar->berkas){?>
                                <td>-</td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <th>Status Pembayaran</th>
                            <td>:</td>
                            <?php if($barangkeluar->id_status==0){?>
                                <td>  <button  class="btn btn-sm btn-primary mb-3" > <?php echo $barangkeluar->status_peminjaman;?></button></td>
                            <?php } ?>
                            <?php if($barangkeluar->id_status==1){?>
                                <td>  <button  class="btn btn-sm btn-warning mb-3" > <?php echo $barangkeluar->status_peminjaman;?></button></td>
                            <?php } ?>
                            <?php if($barangkeluar->id_status==2){?>
                                <td> <button  class="btn btn-sm btn-success mb-3" > <?php echo $barangkeluar->status_peminjaman;?></button></td>
                            <?php } ?>
                            <?php if($barangkeluar->id_status==3){?>
                                <td> <button  class="btn btn-sm btn-danger mb-3" > <?php echo $barangkeluar->status_peminjaman;?></button></td>
                            <?php } ?>
                            
                        </tr>
                       <tr>
                           <td>
                           <?php if($barangkeluar->berkas == ''){?>
                             <button style="width: 100%" class="btn btn-sm btn-danger mb-3" data-toggle="modal" data-target="#tambah_barang"><i class="fas fa-plus fa-sm"></i> Upload Bukti Pembayaran</button>
                            <?php } ?>
                           </td>
                       </tr>
                    </table>
                </div>
            </div>
        </div>




</div>



<!-- Modal -->
<div class="modal fade" id="tambah_barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran Anda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
            <?= $this->session->flashdata('pesan'); ?>
             <?= form_open_multipart('', [], ['id_barang_keluar' => $barangkeluar->id_barang_keluar, 'user_id' => $this->session->userdata('login_session')['user']]); ?>

      <div class="modal-body">
        <div class="form-group">
            <label>Upload Bukti Pembayaran</label>
             <input value="<?= set_value('berkas'); ?>" accept="application/pdf" name="berkas" id="berkas" type="file" class="form-control">
                        <?= form_error('berkas', '<small class="text-danger">', '</small>'); ?>
        
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Kirim</button>
      </div>
          <?= form_close(); ?>
    </div>
  </div>
</div>

<br>
<br>