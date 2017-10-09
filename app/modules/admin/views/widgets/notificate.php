<?php if($query) { ?>
<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o fa-lg fa-2"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <?php foreach($query as $row) { ?>
                <li>
                    <a href="<?= site_url('admin/notifications/markasread/' . $row->id) ?>" target="_blank">
                        <i class="fa fa-newspaper-o text-aqua"></i>  <?= $row->title; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <li class="footer"><?= anchor('admin/notifications', wpn_lang('view_all')); ?></li>
    </ul>
</li>
<?php } ?>