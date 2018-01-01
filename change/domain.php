    ***REMOVED***

    require '../includes/config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    // Remove www. from domain and lowercase
    $v_domain = $_POST['v_domain'];

    // Define proxy extensions
    $v_proxy_ext = $_POST['v_prxext'];
    if ($v_proxy_ext == ''){ $v_proxy_ext = 'jpeg, jpg, png, gif, bmp, ico, svg, tif, tiff, css, js, htm, html, ttf, otf, webp, woff, txt, csv, rtf, doc, docx, xls, xlsx, ppt, pptx, odf, odp, ods, odt, pdf, psd, ai, eot, eps, ps, zip, tar, tgz, gz, rar, bz2, 7z, aac, m4a, mp3, mp4, ogg, wav, wma, 3gp, avi, flv, m4v, mkv, mov, mp4, mpeg, mpg, wmv, exe, iso, dmg, swf';***REMOVED***
    $proxy_ext = preg_replace("/\n/", ",", $v_proxy_ext);
    $proxy_ext = preg_replace("/\r/", ",", $proxy_ext);
    $proxy_ext = preg_replace("/\t/", ",", $proxy_ext);
    $proxy_ext = preg_replace("/ /", ",", $proxy_ext);
    $proxy_ext_arr = explode(",", $proxy_ext);
    $proxy_ext_arr = array_unique($proxy_ext_arr);
    $proxy_ext_arr = array_filter($proxy_ext_arr);
    $prxext = implode(",",$proxy_ext_arr);

    // Check Proxy option
    if (!empty($_POST['v_prxenabled'])) {
        $v_prxx = 'yes';
    ***REMOVED*** else {
        $v_prxx = 'no';
    ***REMOVED***
    if (!empty($_POST['v_prxenabled-x'])) {
        $v_prxx_x = 'yes';
    ***REMOVED*** else {
        $v_prxx_x = 'no';
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
    // Check Stats Auth option
    if (!empty($_POST['v_statsuserenabled'])) {
        $v_statsuserenabled = 'yes';
    ***REMOVED*** else {
        $v_statsuserenabled = 'no';
    ***REMOVED***
    // Check FTP option
    if (!empty($_POST['v_ftpenabled'])) {
        $v_ftpx = 'yes';
    ***REMOVED*** else {
        $v_ftpx = 'no';
    ***REMOVED***

    if ((!isset($v_domain)) || ($v_domain == '')) { header('Location: ../list/web.php?returncode=1');***REMOVED***
    else {
        if ($_POST['v_ip-x'] != $_POST['v_ip']){
            $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ip','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip']);

            $curl0 = curl_init();
            curl_setopt($curl0, CURLOPT_URL, $vst_url);
            curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl0, CURLOPT_POST, true);
            curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
            $r0 = curl_exec($curl0);
        ***REMOVED*** else { $r0 = 'x0'; ***REMOVED***
        // Change account aliases
        $valiases = explode(",", $_POST['v_alias-x']);
        $waliases = preg_replace("/\n/", " ", $_POST['v_alias']);
        $waliases = preg_replace("/,/", " ", $waliases);
        $waliases = preg_replace('/\s+/', ' ',$waliases);
        $waliases = trim($waliases);
        $aliases = explode(" ", $waliases);
        $v_aliases = str_replace(' ', "\n", $waliases);
        $result = array_diff($valiases, $aliases);
        $r1 = 'x0';
        foreach ($result as $alias) {
            if (!empty($alias)) {
                $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-alias','arg1' => $username,'arg2' => $v_domain, 'arg3' => $alias, 'arg4' => 'no');

                $curl1 = curl_init();
                curl_setopt($curl1, CURLOPT_URL, $vst_url);
                curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl1, CURLOPT_POST, true);
                curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
                $r1 = curl_exec($curl1);
            ***REMOVED***
        ***REMOVED***
        $result = array_diff($aliases, $valiases);
        foreach ($result as $alias) {
            if (!empty($alias)) {
                $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-alias','arg1' => $username,'arg2' => $v_domain, 'arg3' => $alias, 'arg4' => 'no');

                $curl1 = curl_init();
                curl_setopt($curl1, CURLOPT_URL, $vst_url);
                curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl1, CURLOPT_POST, true);
                curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
                $r1 = curl_exec($curl1);
            ***REMOVED***
        ***REMOVED***
        if ($_POST['v_tpl-x'] != $_POST['v_tpl']){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-tpl','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_tpl']);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED***
        else { $r2 = 'x0'; ***REMOVED***
        if ($v_prxx != $v_prxx_x && $v_prxx == 'yes' && $v_prxx_x == 'no'){
            $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-proxy','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_prxtpl'], 'arg4' => $prxext, 'arg5' => 'no');

            $curl3 = curl_init();
            curl_setopt($curl3, CURLOPT_URL, $vst_url);
            curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl3, CURLOPT_POST, true);
            curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
            $r3 = curl_exec($curl3);
        ***REMOVED*** else { $r3 = 'x0'; ***REMOVED***
        if ($v_prxx != $v_prxx_x && $v_prxx == 'no' && $v_prxx_x == 'yes'){
            $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-proxy','arg1' => $username,'arg2' => $v_domain);

            $curl3 = curl_init();
            curl_setopt($curl3, CURLOPT_URL, $vst_url);
            curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl3, CURLOPT_POST, true);
            curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
            $r3 = curl_exec($curl3);
            if ($r3 == '3') { $r3 = '0';***REMOVED***
        ***REMOVED*** else { $r3 = 'x0'; ***REMOVED***
        if ($v_prxx == 'yes' && $_POST['v_prxtpl-x'] != $_POST['v_prxtpl'] || $_POST['v_prxext-x'] != $prxext ){
            $postvars4 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-proxy-tpl','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_prxtpl'], 'arg4' => $prxext, 'arg5' => 'no');

            $curl4 = curl_init();
            curl_setopt($curl4, CURLOPT_URL, $vst_url);
            curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl4, CURLOPT_POST, true);
            curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
            $r4 = curl_exec($curl4);
            if ($r4 == '3') { $r4 = '0';***REMOVED***
        ***REMOVED*** else { $r4 = 'x0'; ***REMOVED***
        if (($_POST['v_webstats'] != 'none')  && ($_POST['v_webstats-x'] == 'none')){
            $postvars5 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

            $curl5 = curl_init();
            curl_setopt($curl5, CURLOPT_URL, $vst_url);
            curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl5, CURLOPT_POST, true);
            curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
            $r5 = curl_exec($curl5);
        ***REMOVED***
        elseif (($_POST['v_webstats'] == 'none') && ($_POST['v_webstats'] != $_POST['v_webstats-x'])){
            $postvars5 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-stats','arg1' => $username,'arg2' => $v_domain);

            $curl5 = curl_init();
            curl_setopt($curl5, CURLOPT_URL, $vst_url);
            curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl5, CURLOPT_POST, true);
            curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
            $r5 = curl_exec($curl5);
        ***REMOVED***
        elseif (($_POST['v_webstats'] != 'none') && ($_POST['v_webstats-x'] != 'none')){
            $postvars5 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

            $curl5 = curl_init();
            curl_setopt($curl5, CURLOPT_URL, $vst_url);
            curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl5, CURLOPT_POST, true);
            curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
            $r5 = curl_exec($curl5);
        ***REMOVED*** else { $r5 = 'x0'; ***REMOVED***

        if ($_POST['v_statsuserenabled'] != '' && $_POST['v_statsuserenabled'] != $_POST['v_statsuserenabled-x'] && !empty($_POST['v_statsuname']) && !empty($_POST['v_statspassword'])) {
            $postvars6 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

            $curl6 = curl_init();
            curl_setopt($curl6, CURLOPT_URL, $vst_url);
            curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl6, CURLOPT_POST, true);
            curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
            $r6 = curl_exec($curl6);
        ***REMOVED*** 
        elseif ($_POST['v_statsuserenabled'] == '' && $_POST['v_statsuserenabled'] != $_POST['v_statsuserenabled-x'] || $_POST['v_statuname'] == '' && $_POST['v_statsuname'] != $_POST['v_statsuname-x'] || $_POST['v_webstats'] == 'none' && $_POST['v_webstats'] != $_POST['v_webstats-x']) {
            $postvars6 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

            $curl6 = curl_init();
            curl_setopt($curl6, CURLOPT_URL, $vst_url);
            curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl6, CURLOPT_POST, true);
            curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
            $r6 = curl_exec($curl6);
        ***REMOVED*** else { $r6 = 'x0'; ***REMOVED***
        if ($v_lex == 'yes' && $_POST['v_leenabled'] != $_POST['v_leenabled-x']) {
            $postvars7 = array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-schedule-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain);

            $curl7 = curl_init();
            curl_setopt($curl7, CURLOPT_URL, $vst_url);
            curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl7, CURLOPT_POST, true);
            curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
            $r7 = curl_exec($curl7);
            if ($r7 == 'OK') { $r4 = '0';***REMOVED***   
        ***REMOVED*** 
        elseif ($v_lex == 'no' && $_POST['v_leenabled'] != $_POST['v_leenabled-x']) {
            $postvars7 = array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-delete-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => 'no');

            $curl7 = curl_init();
            curl_setopt($curl7, CURLOPT_URL, $vst_url);
            curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl7, CURLOPT_POST, true);
            curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
            $r7 = curl_exec($curl7);
            if ($r7 == 'OK') { $r4 = '0';***REMOVED*** 
        ***REMOVED*** else { $r7= 'x0'; ***REMOVED***
        header('Location: ../edit/domain.php?domain=' . $v_domain . '&returncode=' . $r0 . '.' . $r1 . '.' . $r2 . '.' . $r3 . '.' . $r4 . '.' . $r5 . '.' . $r7 . '.' . $r6);
    ***REMOVED***

    ***REMOVED***