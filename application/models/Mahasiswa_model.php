<?php

class Mahasiswa_model extends CI_Model
{
    public function select($id = '')
    {
        if ($id == '') {
            return $this->db->get('mahasiswa')->result_array();
        } else {
            return $this->db->get_where('mahasiswa', ['no_induk' => $id])->row_array();
        }
    }

    public function insert($data = '')
    {
        $data = [
            'no_induk' => $this->input->post('no_induk', true),
            'nama' => $this->input->post('nama', true),
            'foto_pribadi' => $data['filename_foto_pribadi'],
            'foto_ktp' => $data['filename_foto_ktp']
        ];

        $this->db->insert('mahasiswa', $data);
    }

    public function update($id, $data = '')
    {
        $data = [
            'no_induk' => $this->input->post('no_induk', true),
            'nama' => $this->input->post('nama', true),
            'foto_pribadi' => $data['filename_foto_pribadi'],
            'foto_ktp' => $data['filename_foto_ktp']
        ];

        $this->db->where('id', $id);
        $this->db->update('mahasiswa', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mahasiswa');
    }

    // fungsi tambahan

    public function insert_images()
    {
    }
}
