<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left info">
        <p>Alexander Pierce</p>
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

        foreach ($nav_data as $nav_item_name => $nav_item) {
          echo "<li class=\"header\">".$nav_item_name."</li>";
          foreach ($nav_item['children'] as $nav_list_name => $nav_list) {
            echo "<li><a href=\"../widgets.html\">
              <i class=\"".$nav_list['icon']."\"></i> <span>".$nav_list_name."</span>
              <span class=\"pull-right-container\">
                <small class=\"label pull-right bg-green\">Hot</small>
              </span>
            </a></li>";
          }
        }
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
