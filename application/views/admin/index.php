<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <table style="margin:20px auto;" border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Pekerjaan</th>
            <th>Action</th>
        </tr>
        <?php
        $no = 1;
        foreach ($user as $u) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $u->name ?></td>
                <td><?php echo $u->email ?></td>
                <td><?php echo $u->image ?></td>
                <td><?php echo $u->role_id ?></td>
                <td><?php echo $u->is_active ?></td>
                <td><?php echo $u->no_hp ?></td>
                <td><?php echo $u->wa ?></td>
            </tr>
        <?php } ?>
    </table>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->