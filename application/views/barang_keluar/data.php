<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang Keluar
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Keluar
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal Peminjaman</th>
                    <th>Kode BMN</th>
                    <th>Nama Peminjaman</th>
                    <th>Nama Barang</th>
                    <th>Gambar</th>
                    <th>Operator Peminjaman</th>
                    <th>Status Peminjaman</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangkeluar) :
                    foreach ($barangkeluar as $bk) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['tanggal_keluar']; ?></td>
                            <td><?= $bk['kode_bmn']; ?></td>
                            <td><?= $bk['nama_peminjam']; ?></td>
                            <td><?= $bk['nama_barang']; ?></td>
                            <td><img style="width:100px;height:100px;" src="<?php echo base_url().'/uploads/'.$bk['gambar_bk']; ?>"></td>
                            <td><?= $bk['nama']; ?></td>
                            <td><?= $bk['status_peminjaman']; ?></td>
                            
                            <td>
                                <a href="<?= base_url('barangkeluar/detail/') . $bk['id_barang_keluar'] ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-info"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangkeluar/delete/') . $bk['id_barang_keluar'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>