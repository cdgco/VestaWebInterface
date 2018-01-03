    ***REMOVED***

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_domain = $_POST['v_domain'];

    // Check antispam option
    if (!empty($_POST['v_antispam'])) {
        $v_antispam = 'yes';
    ***REMOVED*** else {
        $v_antispam = 'no';
    ***REMOVED***

    // Check antivirus option
    if (!empty($_POST['v_antivirus'])) {
        $v_antivirus = 'yes';
    ***REMOVED*** else {
        $v_antivirus = 'no';
    ***REMOVED***

    // Check dkim option
    if (!empty($_POST['v_dkim'])) {
        $v_dkim = 'yes';
    ***REMOVED*** else {
        $v_dkim = 'no';
    ***REMOVED***


    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/mail.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_antispam'])) || ($_POST['v_antispam'] == '')) { header('Location: ../edit/mail.php?returncode=1&domain=' . $v_domain);***REMOVED***
    elseif ((!isset($_POST['v_antivirus'])) || ($_POST['v_antivirus'] == '')) { header('Location: ../edit/mail.php?returncode=1&domain=' . $v_domain);***REMOVED***
    elseif ((!isset($_POST['v_dkim'])) || ($_POST['v_dkim'] == '')) { header('Location: ../edit/mail.php?returncode=1&domain=' . $v_domain);***REMOVED***
    if ($_POST['v_antispam-x'] != $v_antispam){
        if ($v_antispam == 'yes'){
            $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-antispam','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl0 = curl_init();
            curl_setopt($curl0, CURLOPT_URL, $vst_url);
            curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl0, CURLOPT_POST, true);
            curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
            $r0 = curl_exec($curl0);
        ***REMOVED***
        if ($v_antispam == 'no'){
            $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-antispam','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl0 = curl_init();
            curl_setopt($curl0, CURLOPT_URL, $vst_url);
            curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl0, CURLOPT_POST, true);
            curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
            $r0 = curl_exec($curl0);
        ***REMOVED******REMOVED*** else { $r0 = '0';***REMOVED***
    if ($_POST['v_antivirus-x'] != $v_antivirus){
        if ($v_antivirus == 'yes'){
            $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-antivirus','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        ***REMOVED***
        if ($v_antivirus == 'no'){
            $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-antivirus','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        ***REMOVED******REMOVED*** else { $r1 = '0';***REMOVED***
    if ($_POST['v_dkim-x'] != $v_dkim){
        if ($v_dkim== 'yes'){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-dkim','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED***
        if ($v_dkim == 'no'){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-dkim','arg1' => $username,'arg2' => $_POST['v_domain']);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED******REMOVED***
    else { $r2 = '0';***REMOVED***
    if (isset($_POST['v_catchall'])){
        $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-mail-domain-catchall','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_catchall']);

        $curl3 = curl_init();
        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
        $r3 = curl_exec($curl3);
    ***REMOVED*** else { $r3 = '0';***REMOVED***


    header('Location: ../edit/mail.php?domain=' . $v_domain . '&returncode=' . $r0 . '.' . $r1 . '.' .$r2 . '.' . $r3);

    ***REMOVED***