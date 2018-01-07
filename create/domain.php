***REMOVED***

session_start();

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;
    if(base64_decode($_SESSION['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    // Remove www. from domain and lowercase
    $v_domain = preg_replace("/^www\./i", "", $_POST['v_domain']);
    $v_domain = strtolower($v_domain);

    // Define domain aliases
    $v_aliases = $_POST['v_alias'];
    $aliases = preg_replace("/\n/", ",", $v_aliases);
    $aliases = preg_replace("/\r/", ",", $aliases);
    $aliases = preg_replace("/\t/", ",", $aliases);
    $aliases = preg_replace("/ /", ",", $aliases);
    $aliases_arr = explode(",", $aliases);
    $aliases_arr = array_unique($aliases_arr);
    $aliases_arr = array_filter($aliases_arr);
    $alias = implode(",",$aliases_arr);
    if (empty($_POST['v_alias'])) $alias = 'none';

    // Define proxy extensions
    $v_proxy_ext = $_POST['v_prxext'];
    $proxy_ext = preg_replace("/\n/", ",", $v_proxy_ext);
    $proxy_ext = preg_replace("/\r/", ",", $proxy_ext);
    $proxy_ext = preg_replace("/\t/", ",", $proxy_ext);
    $proxy_ext = preg_replace("/ /", ",", $proxy_ext);
    $proxy_ext_arr = explode(",", $proxy_ext);
    $proxy_ext_arr = array_unique($proxy_ext_arr);
    $proxy_ext_arr = array_filter($proxy_ext_arr);
    $prxext = implode(",",$proxy_ext_arr);

    // Check DNS option
    if (!empty($_POST['v_dnsenabled'])) {
        $v_dnsx = 'yes';
    ***REMOVED*** else {
        $v_dnsx = 'no';
    ***REMOVED***
    // Check Mail option
    if (!empty($_POST['v_mailenabled'])) {
        $v_mailx = 'yes';
    ***REMOVED*** else {
        $v_mailx = 'no';
    ***REMOVED***
    // Check Proxy option
    if (!empty($_POST['v_pryxyenabled'])) {
        $v_prxx = 'yes';
    ***REMOVED*** else {
        $v_prxx = 'no';
    ***REMOVED***
    // Check SSL option
    if (!empty($_POST['v_sslenabled'])) {
        $v_sslx = 'yes';
    ***REMOVED*** else {
        $v_sslx = 'no';
    ***REMOVED***
    // Check Let's Encrypt option
    if (!empty($_POST['v_leenabled'])) {
        $v_lex = 'yes';
    ***REMOVED*** else {
        $v_lex = 'no';
    ***REMOVED***
    // Check FTP option
    if (!empty($_POST['v_ftpenabled'])) {
        $v_ftpx = 'yes';
    ***REMOVED*** else {
        $v_ftpx = 'no';
    ***REMOVED***
    if ((!isset($v_domain)) || ($v_domain == '')) { header('Location: ../add/domain.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../add/domain.php?returncode=1');***REMOVED***
    else {
        $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip'], 'arg4' => 'no', 'arg5' => $alias, 'arg6' => $prxext);

        $curl0 = curl_init();
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
        $r0 = curl_exec($curl0);

        if ($v_prxx == 'no'){
            $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-proxy','arg1' => $username,'arg2' => $v_domain, 'arg3' => 'no');

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        ***REMOVED*** else { $r1 = '0'; ***REMOVED***
        if ($v_mailx == 'yes'){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain','arg1' => $username,'arg2' => $v_domain);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED*** else { $r2 = '0'; ***REMOVED***
        if ($v_dnsx == 'yes'){
            $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip'], 'arg4' => '', 'arg5' => '', 'arg6' => '', 'arg7' => '', 'arg8' => '', 'arg9' => '', 'arg10' => '', 'arg11' => '', 'arg12' => 'no');

            $curl3 = curl_init();
            curl_setopt($curl3, CURLOPT_URL, $vst_url);
            curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl3, CURLOPT_POST, true);
            curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
            $r3 = curl_exec($curl3);
            foreach ($aliases_arr as $dnsalias) {
                if ($dnsalias != "www.".$_POST['v_domain']) {
                    $postvars4 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-on-web-alias','arg1' => $username,'arg2' => $dnsalias, 'arg3' => $_POST['v_ip'], 'arg4' => 'no');

                    $curl4 = curl_init();
                    curl_setopt($curl4, CURLOPT_URL, $vst_url);
                    curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl4, CURLOPT_POST, true);
                    curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
                    $r4 = curl_exec($curl4);
                ***REMOVED*** else {$r4 = '0';***REMOVED***
            ***REMOVED***
        ***REMOVED*** else { $r3 = '0'; $r4 = '0';***REMOVED***
        if ((!empty($_POST['v_webstats'])) && ($_POST['v_webstats'] != 'none' )){
            $postvars5 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

            $curl5 = curl_init();
            curl_setopt($curl5, CURLOPT_URL, $vst_url);
            curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl5, CURLOPT_POST, true);
            curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
            $r5 = curl_exec($curl5);
        ***REMOVED*** else { $r5 = '0'; ***REMOVED***
        if ((!empty($_POST['v_webstats'])) && ($_POST['v_webstats'] != 'none') && (!empty($_POST['v_statsuname'])) && (!empty($_POST['v_statspassword']))) {
            $postvars6 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

            $curl6 = curl_init();
            curl_setopt($curl6, CURLOPT_URL, $vst_url);
            curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl6, CURLOPT_POST, true);
            curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
            $r6 = curl_exec($curl6);
        ***REMOVED*** else { $r6 = '0'; ***REMOVED***
        if ($v_lex == 'yes') {
            $postvars7 = array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-schedule-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain);

            $curl7 = curl_init();
            curl_setopt($curl7, CURLOPT_URL, $vst_url);
            curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl7, CURLOPT_POST, true);
            curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
            $r7 = curl_exec($curl7);

        ***REMOVED*** 
        elseif ($v_sslx == 'yes') {
                /* NEEDS TO BE INTEGRATED INTO BACKEND */
            ***REMOVED***
        else { $r7 = '0';***REMOVED***
        if ($v_ftpx == 'yes') {
            /* NEEDS TO BE INTEGRATED INTO BACKEND */
        ***REMOVED***
        header('Location: ../list/web.php?returncode=' . $r0 . '.' . $r1 . '.' . $r2 . '.' .$r3 . '.' . $r4 . '.' . $r5 . '.' . $r6 . '.' . $r7);
    ***REMOVED***

    ***REMOVED***