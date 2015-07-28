<?php

    $data = str_replace(array(
      '[',']','?', 'Date of indenture 1869-01-07, Poole', '$',
      'Signed with a mark (Y/N)','Date of indenture 1868-12-17, Cardiff','Able','Did not sign ','blkyblk','blknblk',
      'yblk','.' , 'didnotappeartosignrelease','b'
    ), '', '[N]');

    $data = preg_replace('/\s+/', '', $data);

    if($data == '') {
      $data = 'blk';
    }
echo $data;