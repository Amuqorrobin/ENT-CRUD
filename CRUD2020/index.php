<?php 

  //Koneksi Database
  $server = "localhost";
  $user   = "root";
  $pass   = "";
  $database = "dblatihan";

  $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

  if(isset($_POST['bsimpan']))
  {

    //pengujian apakah edit atau bukan
    if($_GET['hal'] == 'edit')
    {
      //Data akan diedit
      $edit = mysqli_query($koneksi, " UPDATE tmhs set nim = '$_POST[tnim]',nama = '$_POST[tnama]', alamat = '$_POST[talamat]', prodi = '$_POST[tprodi]' WHERE id_mhs = '$_GET[id]' ");

        if($edit) //JKA SIMPAN SUKSES
        {
        echo " <script>
        alert('Edit Data Sukses');
        document.location='index.php';
        </script> ";
        }
        else{
        echo " <script>
        alert('Edit Data GAGAL!!!');
        document.location='index.php';
        </script> ";
        }
    }
    
    else
    {
      //data akan disimpan baru
      $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
                                      VALUES ('$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodi]') ");
    
      if($simpan) //JKA SIMPAN SUKSES
      {
        echo " <script>
              alert('Simpan Data Sukses');
              document.location='index.php';
        </script> ";
      }
      else{
        echo " <script>
              alert('Simpan Data GAGAL!!!');
              document.location='index.php';
        </script> ";
      }
    }

    

  }
  //pengujian jika tombol edit / hapus ditekan
  if(isset($_GET['hal']))
  {
    //pengujian jika edit data
    if($_GET['hal'] == 'edit')
    {
      $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
      $data = mysqli_fetch_array($tampil);  
      if($data)
      {
        $vnim  = $data['nim'];
        $vnama = $data['nama'];
        $valamat = $data['alamat'];
        $vprodi = $data['prodi'];
      }
    }
    else if ($_GET['hal'] == "hapus")
    {
      //Kode penghapusan
      $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
      if($hapus){
        echo " <script>
              alert('HAPUS BERHASILL');
              document.location='index.php';
        </script> ";
      }
    }

  }

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>CRUD 2020</title>
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">DATA MAHASISWA 2020</h1>
        <h3 class="text-center">By : Achmad Muqorrobin</h3>
      <!-- Awal form -->
      <div class="card">
        <div class="card-header bg-primary text-white text-capitalize">
          Form input data mahasiswa
        </div>
          <div class="card-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="">NIM</label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input Nim anda disini" required>
              </div>
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini" required>
              </div>
              <div class="form-group">
                <label for="">Alamat</label>
                <textarea name="talamat" id="" class="form-control" placeholder="Input Alamat anda disini"><?=@$valamat?></textarea>
              </div>
              <div class="form-group">
                <label for="">Program study</label>
                <select name="tprodi" id="" class="form-control">
                  <option value="<?=@$prodi?>"><?=@$vprodi?></option>
                  <option value="d3-ti">D3 - TI</option>
                  <option value="d4-ti">D4 - TI</option>
                  <option value="d3-mmb"> D3 - MMB</option>
                </select>
              </div>

              <button type="submit" value="" class="btn btn-success" name="bsimpan">Simpan</button>
              <button type="reset" value="" class="btn btn-danger" name="breset">Reset</button>

            </form>
        </div>
      </div>
      <!-- Awal card tabel -->
      <div class="card">
        <div class="card-header bg-success text-white text-capitalize">
          Daftar Mahasiswa
        </div>
        <div class="card-body">
           <table class="table table-bordered table-striped">
            <tr>
              <th>No</th>
              <th>NIM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Program Study</th>
              <th>Action</th>
            </tr>

            <?php 
            
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
            while($data = mysqli_fetch_array($tampil)) :
            
            ?>

            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['nim'];?></td>
              <td><?=$data['nama'];?></td>
              <td><?=$data['alamat'];?></td>
              <td><?=$data['prodi'];?></td>
              <td>
                <a href="index.php?hal=edit&id=<?=$data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=hapus&id=<?=$data['id_mhs'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini ?')" >Hapus</a>
              </td>
            </tr>
            
            <?php endwhile; //penutup perulangan while ?>

           </table>
        </div>
      </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>