<?php 
    // koneksi dalam file function
    require 'functions.php';

    // menampilkan semua data yang ada
    $tampil = getAll();

    // cek tombol simpan
    if(isset($_POST['simpan'])){
        // masuk fungsi tambah
        if(addTodo($_POST) > 0) {
            echo "
                <script>
                    alert('Data Berhasil di Tambahkan')
                    document.location.href = 'index.php';
                </script>    
                ";
        } else {
            echo "
                <script>
                    alert('Data Gagal di Tambahkan!')
                    document.location.href = 'index.php';
                </script>    
            ";
        }
    }

    // pengecekan edit dan hapus menggunakan action
    if(isset($_GET['action'])){
        $id = $_GET['id'];
        // aksi hapus
        if($_GET['action'] === "del"){
            deleteTodo($id);
        };

        // aksi edit
        if($_GET['action'] === 'edit'){
            $id = $_GET['id'];
            // menampilkan data yang akan di update
            $upd = getUpdate($id);
            // melakukan update data todo list
        } else if(isset($_POST['ubah'])){
            $id = $_POST['no'];
            if(editTodo($_POST)) {
                echo "
                    <script>
                        alert('Data Berhasil di Update')
                        document.location.href = 'index.php';
                    </script>    
                    ";
            } else {
                echo "
                    <script>
                        alert('Data Gagal di Update!')
                        document.location.href = 'index.php';
                    </script>    
                ";
            }
        };
    };

    // cek status
    if(isset($_GET['status']) && $_GET['id']){
        $id = $_GET['id'];
        $status = $_GET['status'];
        if($_GET['status'] === 'undone'){
            changeStatus($id, $status);
        }
        if($_GET['status'] === 'done'){
            changeStatus($id, $status);
        }
    }else{
        ?>
        <script>window.href.location ='todo.php';</script>
        <?php
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>To Do List Bengkot</title>
</head>
<body>
    <div class="container mt-4"> 
        <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd">
            <div class="container-fluid">
                <b class="navbar-brand">To Do List</b>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <p class="navbar-nav">Catatan hal yang akan kmu kerjakan disini.</p>
                </div>
            </div>
        </nav>
        <hr>
        <form action="index.php?action=null" method="POST">
            <div class="row g-2 g-lg-3">
                <?php if(!empty($_GET['action']) && $_GET['id']) {?>
				    <input type="hidden" name="no" value="<?= $upd['id'] ?>"/>
                    <div class="col do">
                        <div class="p-3">
                            <b>Kegiatan</b>
                            <input type="text" class="form-control mt-2" placeholder="Kegiatan" name="do" value="<?= $upd['isi']?>">
                        </div>
                    </div>
                    <div class="col date-start">
                        <div class="p-3">
                            <b>Tanggal Awal</b>
                            <input type="date" class="form-control mt-2" placeholder="Tanggal Awal" name="date_start" value="<?= $upd['tgl_awal']?>">
                        </div>
                    </div>
                    <div class="col date-end">
                        <div class="p-3">
                            <b>Tanggal Akhir</b>
                            <input type="date" class="form-control mt-2" placeholder="Tanggal Akhir" name="date_end" value="<?= $upd['tgl_akhir']?>">
                        </div>
                    </div>
                    <div class="col date-start">
                    <div class="p-3">
                        <button type="submit" class="btn btn-primary" name="ubah">simpan</button> 
                    </div>
                </div>
                <?php }else{?>
                    <div class="col do">
                        <div class="p-3">
                            <b>Kegiatan</b>
                            <input type="text" class="form-control mt-2" placeholder="Kegiatan" name="do" required>
                        </div>
                    </div>
                    <div class="col date-start">
                        <div class="p-3">
                            <b>Tanggal Awal</b>
                            <input type="date" class="form-control mt-2" placeholder="Tanggal Awal" name="date_start" required>
                        </div>
                    </div>
                    <div class="col date-end">
                        <div class="p-3">
                            <b>Tanggal Akhir</b>
                            <input type="date" class="form-control mt-2" placeholder="Tanggal Akhir" name="date_end" required>
                        </div>
                    </div>
                    <div class="col date-start">
                        <div class="p-3">
                            <button type="submit" class="btn btn-primary" name="simpan">simpan</button>
                        </div>
                    </div>
                <?php }?> 
            </div>
        </form>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
                $i = 1;
                foreach($tampil as $todo) {
            ?>
                <tbody>
                    <tr>
                        <td><?= $i;?></td>
                        <td><?= $todo['isi']?></td>
                        <td><?= $todo['tgl_awal']?></td>
                        <td><?= $todo['tgl_akhir']?></td>
                        <td>
                            <?php
                                if($todo['status'] == 0) { ?>
                                <a href="index.php?id=<?= $todo['id'] ?>&status=undone" class="btn btn-warning">Belum</a></td>
                            <?php } else{?>
                                <a href="index.php?id=<?= $todo['id'] ?>&status=done" class="btn btn-success">Sudah</a></td>
                            <?php }?>
                        <td>
                            <a href="index.php?action=edit&id=<?= $todo['id'];?>"class="btn btn-info" name="edit">Ubah</a>
                            <a href="index.php?action=del&id=<?= $todo['id'];?>"class="btn btn-danger" name="hapus" onclick="return confirm('yakin?');">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            <?php $i++; } ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>