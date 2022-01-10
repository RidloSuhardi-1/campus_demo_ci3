<?php

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('mahasiswa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'title' => 'Mahasiswa',
            'data' => $this->mahasiswa_model->select()
        ];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');

        if (isset($_SESSION['pesan'])) {
            unset($_SESSION['pesan']);
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Mahasiswa',
            'mahasiswa' => $this->mahasiswa_model->select($id)
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/detail', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $data['title'] = 'Mahasiswa Baru';

        $data['error_foto_pribadi'] = '';
        $data['error_foto_ktp'] = '';

        // validasi form input
        $this->form_validation->set_rules('no_induk', 'Nomor Induk', 'required|numeric|is_unique[mahasiswa.no_induk]|min_length[5]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        // file foto wajib dikirim yah..
        if (empty($_FILES['foto_pribadi']['name'])) {
            $this->form_validation->set_rules('foto_pribadi', 'File Foto Pribadi', 'required');
        }
        if (empty($_FILES['foto_ktp']['name'])) {
            $this->form_validation->set_rules('foto_ktp', 'File Foto KTP', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('mahasiswa/create');
            $this->load->view('templates/footer');

            if (isset($_SESSION['error_foto_pribadi'])) {
                unset($_SESSION['error_foto_pribadi']);
            }

            if (isset($_SESSION['error_foto_ktp'])) {
                unset($_SESSION['error_foto_ktp']);
            }
        } else {
            // validasi file input
            // konfigurasi rules file input

            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $path = 'public/upload/img/';
                    $data['filename_foto_pribadi'] = $this->do_upload('foto_pribadi', $path, 'mahasiswa/create');
                }
                if ($i == 1) {
                    $path = 'public/upload/img/';
                    $data['filename_foto_ktp'] = $this->do_upload('foto_ktp', $path, 'mahasiswa/create');
                }
            }

            $this->mahasiswa_model->insert($data);
            $this->session->set_flashdata('pesan', 'ditambahkan');
            redirect('/mahasiswa');
        }
    }

    public function edit($id)
    {
        $mahasiswa = $this->mahasiswa_model->select($id);
        $data['title'] = 'Ubah Mahasiswa';
        $data['mahasiswa'] = $mahasiswa;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $data = $this->mahasiswa_model->select($id);

        // validasi no induk
        $getMahasiswa = $this->mahasiswa_model->select();
        $available = FALSE;

        $old_no_induk = $this->input->post('old_no_induk');
        $new_no_induk = $this->input->post('no_induk');

        // masih sama, oh skip aja
        if ($old_no_induk == $new_no_induk) {
            $available = true;
        } else {
            // oh beda, kira-kira ada yang samaan ga ?
            foreach ($getMahasiswa as $m) {
                if ($m['no_induk'] == $new_no_induk) {
                    $available = false;
                    break;
                } else {
                    $available = true;
                }
            }
        }

        if ($available) {
            $rules = 'required|numeric|min_length[5]';
        } else {
            $rules = 'required|is_unique[mahasiswa.no_induk]|numeric|min_length[5]';
        }

        // validasi form input
        $this->form_validation->set_rules('no_induk', 'Nomor Induk', $rules);
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        // jika ada yang salah
        if ($this->form_validation->run() == FALSE) {
            redirect('mahasiswa/edit/' . $data['no_induk']);

            if (isset($_SESSION['error_foto_pribadi'])) {
                unset($_SESSION['error_foto_pribadi']);
            }

            if (isset($_SESSION['error_foto_ktp'])) {
                unset($_SESSION['error_foto_ktp']);
            }
        } else {

            // validasi file input
            // konfigurasi rules file input

            $path = 'public/upload/img/';
            $data['filename_foto_pribadi'] = $data['foto_pribadi']; // nama file default
            $data['filename_foto_ktp'] = $data['foto_ktp'];


            // ada yang di upload? kalo ada eksekusi
            if (!empty($_FILES['foto_pribadi']['name'])) {
                unlink('public/upload/img/' . $data['foto_pribadi']);
                $data['filename_foto_pribadi'] = $this->do_upload('foto_pribadi', $path, '/mahasiswa/edit/' . $data['no_induk']);
            }

            if (!empty($_FILES['foto_ktp']['name'])) {
                unlink('public/upload/img/' . $data['foto_ktp']);
                $data['filename_foto_ktp'] = $this->do_upload('foto_ktp', $path, 'mahasiswa/edit/' . $data['no_induk']);
            }

            $this->mahasiswa_model->update($data['id'], $data);
            $this->session->set_flashdata('pesan', 'diperbarui');
            redirect('/mahasiswa');
        }
    }

    public function destroy($id)
    {
        $data = $this->mahasiswa_model->select($id);

        unlink('public/upload/img/' . $data['foto_pribadi']);
        unlink('public/upload/img/' . $data['foto_ktp']);

        $this->mahasiswa_model->delete($data['id']);

        $this->session->set_flashdata('pesan', 'dihapus');
        redirect('/mahasiswa');
    }

    // fungsi tambahan

    private function do_upload($field, $path, $destination_error)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1024';
        $config['encrypt_name'] = TRUE;

        // unggah file
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field)) {
            $error = $this->upload->display_errors();

            if (isset($_SESSION['error_' . $field])) {
                unset($_SESSION['error_' . $field]);
            }

            $this->session->set_flashdata('error_' . $field, $error);
            redirect($destination_error); // tujuan setelah error
        } else {
            $upload_data = $this->upload->data();
            $fileName = $upload_data['file_name'];

            return $fileName;
        }
    }
}
