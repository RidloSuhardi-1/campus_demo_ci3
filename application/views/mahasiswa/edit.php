<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $title; ?></h1>
        <a href="<?= base_url(); ?>mahasiswa/" class="btn btn-sm btn-outline-secondary">Kembali ke Mahasiswa</a>
    </div>

    <h2>Ubah Mahasiswa</h2>

    <form action="<?= base_url(); ?>mahasiswa/update/<?= $mahasiswa['no_induk']; ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="old_no_induk" value="<?= $mahasiswa['no_induk']; ?>">

        <div class="row g-3">
            <div class="col-sm-6">
                <label for="no_induk" class="form-label">No Induk</label>
                <input name="no_induk" type="number" class="form-control mb-2 <?= (form_error('no_induk')) ? 'is-invalid' : ''; ?>" id="no_induk" placeholder="" value="<?= set_value('no_induk', $mahasiswa['no_induk']) ?>" required>
                <span class="text-danger"><?= form_error('no_induk'); ?></span>
            </div>

            <div class="col-sm-6">
                <label for="nama" class="form-label">Nama</label>
                <input name="nama" type="text" class="form-control mb-2 <?= (form_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" placeholder="" value="<?= set_value('nama', $mahasiswa['nama']); ?>" required>
                <span class="text-danger"><?= form_error('nama'); ?></span>
            </div>

            <div class="col-12">
                <label for="foto_pribadi" class="form-label">Foto Pribadi</label>
                <input name="foto_pribadi" class="form-control form-control-sm mb-2 <?= ($this->session->flashdata('error_foto_pribadi')) ? 'is-invalid' : ''; ?>" id="foto_pribadi" type="file">
                <?php if ($this->session->flashdata('error_foto_pribadi')) : ?>
                    <span class="text-danger">
                        <?= $this->session->flashdata('error_foto_pribadi'); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label for="foto_ktp" class="form-label">Foto KTP</label>
                <input name="foto_ktp" class="form-control form-control-sm mb-2 <?= ($this->session->flashdata('error_foto_ktp')) ? 'is-invalid' : ''; ?>" id="foto_ktp" type="file">
                <?php if ($this->session->flashdata('error_foto_ktp')) : ?>
                    <span class="text-danger">
                        <?= $this->session->flashdata('error_foto_ktp'); ?>
                    </span>
                <?php endif; ?>
            </div>

            <hr class="my-3">

            <button class="w-100 btn btn-primary" type="submit">Perbarui</button>
    </form>
</main>