<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left info">
        <p><?php echo $_SESSION['name']?></p>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <?php
        $nav_data = json_decode(file_get_contents("data/nav.json"),true);

        $tree = array();
        $breadcrumb = array();

        foreach ($nav_data as $nav_item_name => $nav_item) {
          echo "<li class=\"header\">".$nav_item_name."</li>";
          $tree = array($nav_item_name);
          foreach ($nav_item['children'] as $nav_list_name => $nav_list) {
            if ($nav_list['short'] == $a) {
              array_push($tree, $nav_list_name);
              $active = "active";
            } else {
              $active = "";
            }
            echo "<li class=\"$active\" id=\"nav_item_$nav_list[short]\"><a onclick=\"loadPage('$nav_list[short]')\">
              <i class=\"$nav_list[icon]\"></i> <span>$nav_list_name</span>
            </a></li>";
          }
        }
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
