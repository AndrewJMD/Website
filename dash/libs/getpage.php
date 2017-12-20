<?php
  ob_start();
  header('Content-Type: application/json');
  require($_SERVER['DOCUMENT_ROOT']."/config.php");
  $a = GetFromURL('a','dashboard');
  if (file_exists(DROOT."dash/pages/$a.php")) {
    include(DROOT."dash/pages/$a.php");
  } else {
    include(DROOT."dash/pages/404.php");
  }
  OutputPage();
  $data = ob_get_contents();
  ob_end_clean();
  $page = array(
    "title" => $PAGE_TITLE,
    "data" => str_replace("\n","",$data)
  );
  echo json_encode($page);
?>
