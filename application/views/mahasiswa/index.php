<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $title; ?></h1>
        <a href="<?= base_url(); ?>mahasiswa/create" class="btn btn-sm btn-outline-secondary">Buat</a>
    </div>

    <h2>Daftar Mahasiswa</h2>
    <?php if ($this->session->flashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data <strong>mahasiswa</strong> berhasil <?= $this->session->flashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No Induk</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Foto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php if ($data) : ?>
                    <?php foreach ($data as $mhs) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $mhs['no_induk']; ?></td>
                            <td><?= $mhs['nama']; ?></td>
                            <td>
                                <img src="<?= ($mhs['foto_pribadi']) ? base_url() . 'public/upload/img/' . $mhs['foto_pribadi'] : base_url() . 'public/img/default.jpg'; ?>" class="img-thumbnail rounded" alt="<?= $mhs['nama']; ?>" width="50">
                            </td>
                            <td>
                                <a href="<?= base_url(); ?>mahasiswa/detail/<?= $mhs['no_induk']; ?>" class="btn btn-secondary btn-sm" aria-current="page">Detail</a>
                                <a href="<?= base_url(); ?>mahasiswa/edit/<?= $mhs['no_induk']; ?>" class="btn btn-secondary btn-sm">Ubah</a>
                                <a href="<?= base_url(); ?>mahasiswa/destroy/<?= $mhs['no_induk']; ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data mahasiswa</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>