<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
    use ResponseTrait;

    private $product;
    public function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index()
    {
        $produk = $this->product->orderBy('id', 'ASC')->findAll();
        $data['produk'] = $produk;
        $data['count'] = count($produk);
        return $this->respond($data);
    }
    // create
    public function create()
    {
        // Validasi Data
        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required',
                'label' => 'Nama produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'label' => 'Harga produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'numeric' => '{field} harus angka!',
                ]
            ]
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        if ($foto == null) // Tidak ada file yg diupload
        {
            $nama_file = "default.png";
        } else {
            // Validasi Foto
            if (!$this->validate([
                'foto.*' => [
                    'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|uploaded[foto]',
                    'label' => 'Foto',
                    'errors' => [
                        'max_size' => '{field} tidak boleh lebih 1MB',
                        'is_image' => 'Yang dipilih bukan gambar!',
                        'mime_in' => 'Yang dipilih bukan gambar!',
                        'uploaded' => 'Gagal upload!',
                    ]
                ]
            ])) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $nama_file = $foto->getRandomName();
            $foto->move('img', $nama_file);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'  => $this->request->getVar('harga'),
            'foto' => 'img/' . $nama_file
        ];
        if ($this->product->insert($data)) {
            $response = [
                'status'   => 201,
                'messages' => [
                    'success' => 'Data produk berhasil ditambahkan.'
                ]
            ];
            return $this->respondCreated($response);
        } else {
            return $this->failValidationErrors("Terjadi Kesalahan...!");
        }
    }
    // single user
    public function show($id = null)
    {
        $data = $this->product->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan...!');
        }
    }
    // update
    public function update($id = null)
    {
        // Validasi Data
        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required',
                'label' => 'Nama produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'label' => 'Harga produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'numeric' => '{field} harus angka!',
                ]
            ],
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getRawInput();
        if ($this->product->update($id, $data)) {
            $response = [
                'status'   => 200,
                'messages' => [
                    'success' => 'Data produk berhasil diubah.'
                ]
            ];
            return $this->respondUpdated($response);
        } else {
            return $this->failValidationErrors("Terjadi Kesalahan...!");
        }
    }

    public function update2($id = null)
    {
        // Validasi Data
        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required',
                'label' => 'Nama produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'label' => 'Harga produk',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'numeric' => '{field} harus angka!',
                ]
            ],
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        // print_r($foto);
        // die;
        if ($foto != null && $foto->getError() === 0) {
            // Validasi Foto
            if (!$this->validate([
                'foto.*' => [
                    'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|uploaded[foto]',
                    'label' => 'Foto',
                    'errors' => [
                        'max_size' => '{field} tidak boleh lebih 1MB',
                        'is_image' => 'Yang dipilih bukan gambar!',
                        'mime_in' => 'Yang dipilih bukan gambar!',
                        'uploaded' => 'Gagal upload!',
                    ]
                ]
            ])) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $nama_file = $foto->getRandomName();
            $foto->move('img', $nama_file);
            $data_lama = $this->product->where('id', $id)->first();
            $foto_lama = $data_lama['foto'];
            // print_r($foto_lama);;
            // die;

            if ($foto_lama != 'img/default.png' && $foto_lama != null) {
                unlink('img/' . $foto_lama);
            }
        } else {
            $nama_file = "default.png";
        }

        $data['nama_produk'] = $this->request->getVar('nama_produk');
        $data['harga'] = $this->request->getVar('harga');
        if ($foto != null && $foto->getError() === 0) {
            $data['foto'] = 'img/' . $nama_file;
        }

        if ($this->product->update($id, $data)) {
            $response = [
                'status'   => 200,
                'messages' => [
                    'success' => 'Data produk berhasil diubah.'
                ]
            ];
            return $this->respondUpdated($response);
        } else {
            return $this->failValidationErrors("Terjadi Kesalahan...!");
        }
    }
    // delete
    public function delete($id = null)
    {
        $data = $this->product->where('id', $id)->delete($id);
        if ($data) {
            $this->product->delete($id);
            $response = [
                'status'   => 200,
                'messages' => [
                    'success' => 'Data produk berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan...!');
        }
    }
}
