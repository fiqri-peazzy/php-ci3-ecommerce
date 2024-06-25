<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Manajemen Akun Pengguna</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Manajemen Akun Pengguna
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card card-box mb-30">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-6">
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tgl Bergabung</th>
                            <th>Aktif</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($users as $user) : ?>
                        <tr>
                            <td class="table-plus"><?= $no++ ?></td>
                            <td><?= $user->username ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->created_at ?></td>
                            <td><?= $user->is_active == 0 ? 'Aktif' : 'Tidak Aktif' ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                                        role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" data-id="<?= $user->id ?>" role="button"
                                            id="see_detail_user"><i class="dw dw-eye"></i> Lihat</a>
                                        <a class="dropdown-item" data-id="<?= $user->id ?>" role="button"
                                            id="delete_user"><i class="dw dw-delete-3"></i> Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>