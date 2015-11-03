<title>Home</title>
<?php 
include 'header.php';

if (isset($_GET['v'])) {
  if($_GET['v']=='MLB'){
  	echo "MLB";
    indexContent('MLB');
    echo "contentEnd";
  }elseif ($_GET['v']=='SL') {
    echo "SL";
    indexContent('SL');
    echo "contentEnd";
  }else{
    indexContent('');
  }
}else{
    indexContent('');
}

include 'footer.php'; ?>