<?php
    require 'Koneksi.php';

    // cek status
    function changeStatus($id, $status) {
        global $con;
        if($status === 'done'){
            $query = "UPDATE db_todo SET `status` = 0 WHERE `id` = $id";
            $execute_query = mysqli_query($con, $query);
            if($execute_query){
                header('location: index.php');
            }
        }
        if($status === 'undone'){
            $query = "UPDATE db_todo SET `status`= 1 WHERE `id` = $id";
            $execute_query = mysqli_query($con, $query);
            if($execute_query){
                header('location: index.php');
            }
        }
    };

    // menampilkan semua kegiatan
    function getAll() {
        global $con;
        $result = mysqli_query($con, 'SELECT * FROM db_todo');
        return $result;
    };

    // tambah data todo
    function addTodo($data) {
        global $con;
        // ambil data dari tiap element dalam kolom form
        $isi = htmlspecialchars($data['do']);
        $tgl_awal = htmlspecialchars($data['date_start']);
        $tgl_akhir = htmlspecialchars($data['date_end']);

        // sql tambah
        $query = "INSERT INTO db_todo (`isi`, `tgl_awal`, `tgl_akhir`, `status`)
                    VALUES 
                    ('$isi', '$tgl_awal', '$tgl_akhir', '0')
                ";
        $execute_query = mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    };

    // edit data Todo 
    function editTodo($data){
        global $con;

        $id = htmlspecialchars($data['no']);
        $isi = htmlspecialchars($data['do']);
        $tgl_awal = htmlspecialchars($data['date_start']);
        $tgl_akhir = htmlspecialchars($data['date_end']);

        $query = "UPDATE db_todo SET isi = '$isi', tgl_awal ='$tgl_awal', tgl_akhir = '$tgl_akhir' WHERE id = $id";
        $execute_query = mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    };

    function getUpdate($id){
        global $con;

        $query= "SELECT * FROM db_todo WHERE id = $id";
        $execute_query = mysqli_query($con, $query);
        $get_todo = mysqli_fetch_assoc($execute_query);
        return $get_todo;
        // return 
        return mysqli_affected_rows($con);
    }

    function deleteTodo($id){
        global $con;
        //sql hapus
        $query = "DELETE FROM db_todo WHERE id = $id";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: index.php');
        }
    };
    $cekTodo;
?>