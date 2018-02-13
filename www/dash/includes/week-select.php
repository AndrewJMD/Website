<li class="dropdown camps-menu">
  <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
    <span class="hidden-xs"><?php echo $_SESSION['camp']['year']; ?>, Week <?php echo $_SESSION['camp']['week']; ?></span>
  </a>
  <ul class="dropdown-menu">
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu" id='week-selector'>
      </ul>
    </li>
    <li class="footer">
      <a onclick="loadPage('camps')">View all camps</a>
    </li>
  </ul>
</li>
