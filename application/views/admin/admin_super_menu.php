<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <li class="active treeview">
    <a href="<?php echo base_url('admin') ?>">
      <i class="fa fa-dashboard "></i> <span>Dashboard</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>

  </li>
  <li class="treeview">
    <a href="<?php echo base_url() ;?>admin/data_pemilih">
      <i class="fa fa-users text-green"></i>
      <span>Data Pemilih Tetap</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  </li>

  <li class="treeview">
    <a href="<?php echo base_url('admin/kandidat') ?>">
      <i class="fa fa-file-text-o text-yellow"></i>
      <span>Data Kandidat</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>

  </li>

  <li class="">
    <a href="<?php echo base_url('admin/laporan') ?>">
      <i class="fa fa-bar-chart text-purple"></i>
      <span>Laporan</span>
      <span class="pull-right-container">
        
      </span>
    </a>

  </li>
  <li class="">
    <a href="<?php echo base_url('admin/sandi'); ?>">
      <i class="fa fa-laptop text-aqua"></i>
      <span>Ubah Sandi</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>

  </li>

  <li class="treeview">
    <a href="#">
      <i class="fa fa-gear text-teal"></i> <span>Pengaturan</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="<?php echo base_url('admin/info') ?>"><i class="fa fa-circle-o"></i> Info Aplikasi</a></li>
      <li><a href="<?php echo base_url('admin/pengguna') ?>"><i class="fa fa-circle-o"></i> Data Pengguna</a></li>
      <li><a href="<?php echo base_url('admin/kosongkan_db') ?>"><i class="fa fa-circle-o"></i> Kosongkan Data</a></li>
      <li><a href="<?php echo base_url('admin/backup_db') ?>"><i class="fa fa-circle-o"></i> Cadangan Data</a></li>
      <li><a href="<?php echo base_url('admin/restore_db') ?>"><i class="fa fa-circle-o"></i> Pulihkan Data </a></li>


    </ul>
  </li>
  <li><a href="<?php echo base_url() ;?>login/logout"><i class="fa fa-power-off text-red text-bold"></i> <span>Keluar</span></a></li>
</ul>
