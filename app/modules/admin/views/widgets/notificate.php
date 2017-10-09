<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o fa-lg fa-2"></i>
  </a>
  <ul class="dropdown-menu">
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu">

        <li>
          <a href="#">
            <i class="fa fa-users text-aqua"></i> 5 new members joined today
          </a>
        </li>


      </ul>
    </li>
    <li class="footer"><?= anchor('admin/notifications', 'View all'); ?></li>
  </ul>
</li>