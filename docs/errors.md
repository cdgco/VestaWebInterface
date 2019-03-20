## Error Codes

While all errors are logged in the VestaCP error log (/usr/local/vesta/log/error.log) errors faced within Vesta Web Interface often display an error code to help decipher what process or command resulted in an error.

These codes are ofter formatted in a string of numbers seperated by periods. Where the order tells which process corresponds to which error, and each number represents a specific error.

Example : `0.1.2.0`

The possible error numbers are as follows:
* 0: Command has been successfuly performed
* 1: Not enough arguments provided
* 2: Object or argument is not valid
* 3: Object doesn't exist
* 4: Object already exists
* 5: Object is suspended
* 6: Object is already unsuspended
* 7: Object can't be deleted because is used by the other object
* 8: Object cannot be created because of hosting package limits
* 9: Wrong password
* 10: Object cannot be accessed be the user
* 11: Subsystem is disabled
* 12: Configuration is broken
* 13: Not enough disk space to complete the action
* 14: Server is to busy to complete the action
* 15: Connection failed. Host is unreachable
* 16: FTP server is not responding
* 17: Database server is not responding
* 18: RRDtool failed to update the database
* 19: Update operation failed
* 20: Service restart failed

Apart from error codes, '500' errors may be shown by enabling the 'display_errors' flag in the .htaccess file.

### Page Error Code Order
Here are the services and commands that correspond to the error codes on the following pages:

#### Base

* profile.php: `E1.E2.E3.E4.E5`
 - E1: Update Password
 - E2: Update Email Address
 - E3: Update User Language
 - E4: Update Account Name
 - E5: Update Default Nameservers
 
#### List 
* list/maildomain.php: `E1.E2.E3.E4.E5`
 - E1: Add Mail Account
 - E2: Add Mail Account Alias
 - E3: Add Mail Account Forward
 - E4: Add Mail Account Forward Only
 - E5: Add Mail Account Autoreply
 
* list/web.php
  - Delete: `E1.E2.E3`
   - E1: Delete Web Domain
   - E2: Delete DNS Domain
   - E3: Delete Mail Domain
  - Create: `E1.E2.E3.E4.E5.E6.E7.E8`
   - E1: Add Web Domain
   - E2: Delete Web Domain Proxy
   - E3: Add Mail Domain
   - E4: Add DNS Domain
   - E5: Add DNS on Web Alias
   - E6: Add Web Domain Stats
   - E7: Add Web Domain Stats User
   - E8: Schedule Let's Encrypt / Add Web Domain SSL
   
#### Edit
* edit/dns.php: `E1.E2.E3.E4.E5`
 - E1: Change DNS Domain IP Address
 - E2: Change DNS Domain Template
 - E3: Change DNS Domain Expiration
 - E4: Change DNS Domain Start-Of-Authority
 - E5: Change DNS Domain Time-To-Live
 
* edit/dnsrecord.php: `E1.E2`
 - E1: Change DNS Record
 - E2: Change DNS Record ID
 
* edit/domain.php `E1.E2.E3.E4.E5.E6.E7.E8.E9.E10.E11.E12`
   - E1: Change Web Domain IP
   - E2: Delete / Add Web Domain Alias
   - E3: Change Web Domain Template
   - E4: Delete / Add Web Domain Proxy
   - E5: Change Web Domain Proxy Template
   - E6: Delete / Add / Change Web Domain Stats
   - E7: Delete / Add Web Domain Stats User
   - E8: Schedule / Delete Let's Encrypt
   - E9: Delete / Add / Change Web Domain SSL & Change SSL Home
   - E10: Enable Additional FTP (Add FTP Users)
   - E11: Disable Additional FTP (Delete Users)
   - E12: Change Additional FTP (Change Password, Change Directory, Create / Change / Delete Users)
   
* edit/mail.php: `E1.E2.E3.E4`
 - E1: Add / Delete Mail Domain Antispam
 - E2: Add / Delete Mail Domain Antivirus
 - E3: Add / Delete Mail Domain DKIM
 - E4: Change Mail Domain Catchall
 
* edit/mailaccount.php: `E1.E2.E3.E4.E5`
 - E1: Change Mail Account Password
 - E2: Add / Delete Mail Account Alias
 - E3: Add / Delete Mail Account Forward
 - E4: Add / Delete Mail Acccount Forward Only
 - E5: Add / Delete Mail Account Autoreply
 
#### Admin/Edit
* admin/edit/ip.php: `E1.E2.E3.E4`
  - E1: Change IP Status
  - E2: Change IP Owner
  - E3: Change IP Name
  - E4: Change IP NAT
  
* admin/edit/package.php: `E1.E2`
 - E1: Add Package
 - E2: Update Package
 
* admin/edit/user.php: `E1.E2.E3.E4.E5.E6.E7`
  - E1: Change User Password
  - E2: Change User Email
  - E3: Change User Package
  - E4: Change User Language
  - E5: Change Account Name
  - E6: Change User Shell
  - E7: Change Default Nameservers
  
#### Admin/Server
* admin/server/vesta.php: `E1.E2.E3.E4.E5.E6.E7.E8.E9.E10.E11.E12.E13.E14`
  - E1: Change System Hostname
  - E2: Change System Timezone
  - E3: Change System Language
  - E4: Change MySQL Root Password
  - E5: Change PostgreSQL Root Password
  - E6: Change Remote Backup
  - E7: Change Backup Compression Level
  - E8: Change Backup Directory
  - E9: Change Vesta SSL
  - E10: Change System Quota
  - E11: Change System Firewall
  - E12: Activate / Deavtivate sFTP Jail
  - E13: Activate / Deavtivate Filemanager
  - E14: Activate / Deavtivate Softaculous
  
 