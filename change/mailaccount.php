    ***REMOVED***

    require '../includes/vars.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_domain = $_POST['v_domain'];
    $v_account = $_POST['v_account'];

    // Check forward-only option
    if (!empty($_POST['v_fwd_only'])) {
        $v_fwd_only = 'yes';
    ***REMOVED*** else {
        $v_fwd_only = 'no';
    ***REMOVED***
    // Check forward-only option
    if (!empty($_POST['v_fwd_only_x'])) {
        $v_fwd_only_x = 'yes';
    ***REMOVED*** else {
        $v_fwd_only_x = 'no';
    ***REMOVED***

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/mail.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_account'])) || ($_POST['v_account'] == '')) { header('Location: ../edit/mail.php?returncode=1&domain=' . $v_domain);***REMOVED***

    // Change account aliases
    $valiases = explode(",", $_POST['v_alias-x']);
    $waliases = preg_replace("/\n/", " ", $_POST['v_alias']);
    $waliases = preg_replace("/,/", " ", $waliases);
    $waliases = preg_replace('/\s+/', ' ',$waliases);
    $waliases = trim($waliases);
    $aliases = explode(" ", $waliases);
    $v_aliases = str_replace(' ', "\n", $waliases);
    $result = array_diff($valiases, $aliases);
    foreach ($result as $alias) {
        if (!empty($alias)) {
            $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-account-alias','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $alias);

            $curl0 = curl_init();
            curl_setopt($curl0, CURLOPT_URL, $vst_url);
            curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl0, CURLOPT_POST, true);
            curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
            $r0 = curl_exec($curl0);
        ***REMOVED***
    ***REMOVED***
    $result = array_diff($aliases, $valiases);
    foreach ($result as $alias) {
        if (!empty($alias)) {
            $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-account-alias','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $alias);

            $curl0 = curl_init();
            curl_setopt($curl0, CURLOPT_URL, $vst_url);
            curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl0, CURLOPT_POST, true);
            curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
            $r0 = curl_exec($curl0);
        ***REMOVED***
    ***REMOVED***

    // Change forwarders
    $vfwd = explode(",", $_POST['v_forward-x']);
    $wfwd = preg_replace("/\n/", " ", $_POST['v_forward']);
    $wfwd = preg_replace("/,/", " ", $wfwd);
    $wfwd = preg_replace('/\s+/', ' ',$wfwd);
    $wfwd = trim($wfwd);
    $fwd = explode(" ", $wfwd);
    $v_fwd = str_replace(' ', "\n", $wfwd);
    $result = array_diff($vfwd, $fwd);
    foreach ($result as $forward) {
        if (!empty($forward)) {
            $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-account-forward','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $forward);

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
    $result = array_diff($fwd, $vfwd);
    foreach ($result as $forward) {
        if (!empty($forward)) {
            $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-account-forward','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $forward);

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

    if ($v_fwd_only_x != $v_fwd_only){
        if ($v_fwd_only == 'yes'){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-account-fwd-only','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'],);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED***
        if ($v_fwd_only == 'no'){
            $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-account-domain-fwd-only','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'],);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        ***REMOVED******REMOVED*** else { $r2 = '0';***REMOVED***

    // Delete autoreply
    if ($_POST['v_autoreply'] != 'yes' && $_POST['v_autoreply'] != $_POST['v_autoreply-x'] ) {
        $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-account-autoreply','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account']);

        $curl3 = curl_init();
        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
        $r3 = curl_exec($curl3);
        $v_autoreply = 'no';
        $v_autoreply_message = '';
    ***REMOVED***
    else {
        if ( $_POST['v_message_x'] != $_POST['v_message']) {
            $v_autoreply_message = str_replace("\r\n", "\n", $_POST['v_message']);
            $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-account-autoreply','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $v_autoreply_message);

            $curl3 = curl_init();
            curl_setopt($curl3, CURLOPT_URL, $vst_url);
            curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl3, CURLOPT_POST, true);
            curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
            $r3 = curl_exec($curl3);
        ***REMOVED***
    ***REMOVED***
    if (isset($_POST['password'])){
        $postvars4 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-mail-account-password','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_account'], 'arg4' => $_POST['password']);

        $curl4 = curl_init();
        curl_setopt($curl4, CURLOPT_URL, $vst_url);
        curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl4, CURLOPT_POST, true);
        curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
        $r4 = curl_exec($curl4);
    ***REMOVED*** else { $r4 = '0';***REMOVED***


    header('Location: ../edit/mailaccount.php?domain=' . $v_domain . '&account=' . $v_account . '&returncode=' . $r4 . '.' . $r0 . '.' . $r1 . '.' .$r2 . '.' . $r3);

    ***REMOVED***