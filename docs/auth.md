## Auth0 Integration

The Auth0 integration with VWI allows users to link their VestaCP / VWI account with any third party connection provided through Auth0. Auth0 provides 30+ social login connections out of the box with the ability to add custom integrations as well.

### Auth0 Setup

!> Note: Auth0 requires an SSL connection with VWI in order to securely authenticate user logins. Auth0 cannot be enabled without a valid SSL certificate and HTTPS enabled.

#### Step 1:
From the [Auth0 Dashboard](https://manage.auth0.com/dashboard) create a new tenant domain. If you are creating a new account, you may use the tenant domain you create with your account. Name the tenant domain anything you desire, this will not be shown to users and is only used to access the Auth0 API.

#### Step 2:
Within your new Auth0 tenant domain, create a new application. Name the application anything you desire and set the application type as 'Regular Web Application'.

#### Step 3:

From the settings tab of your new Auth0 application, change the following settings as such:
 * Token Endpoint Authentication Method: 'Post'
 * Application Login URI: 'https://\[YOUR-VWI-INSTALL-LOCATION]/login.php'
 * Allowed Callback URLs: 'https://\[YOUR-VWI-INSTALL-LOCATION]/process/callback.php'
 * Allowed Logout URLs: 'http://\[YOUR-VWI-INSTALL-LOCATION]/process/logout.php'

!> Note: You must replace \[YOUR-VWI-INSTALL-LOCATION] with the address where your Vesta Web Interface installation is publicly accessible.

### Step 4:
Under the 'APIs' tab in Auth0, open the settings for the 'Auth0 Management API' and view the 'Machine to Machine Applications' tab. Authorize your new application, select the permission 'read:connections' and update the API.

### Step 5:
From the 'Connections -> Social' tab in Auth0, enable any social connections you wish to use. For help, visit the [Auth0 Social Connection Docs](https://auth0.com/docs/connections/identity-providers-social). If Auth0 does not have the social connection you desire, you may add any OAuth2 connection through the [Custom Social Connections extension](https://auth0.com/docs/extensions/custom-social-extensions) or any OAuth1 connection through the [Auth0 Connections API](https://auth0.com/docs/connections/adding-generic-oauth1-connection).

### Step 6:
Copy the Domain, Client ID and Client Secret from your new Auth0 app into the VWI settings page under 'Optional Integrations' or into your vwi_config MySQL table for the 'AUTH0_DOMAIN', 'AUTH0_CLIENT_ID' and 'AUTH0_CLIENT_SECRET' fields.

All Done! Once all three fields are filled out, Auth0 will be automically enabled.