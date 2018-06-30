## Registrations Configuration

Once enabling registrations from the VWI configuration, you must edit the register.php file and change the allowed plans for registration.

Within the register.php file on line 118, list the allowed plans within HTML 'option' tags.

Example:

```
<option value="default"><?php echo _('Default'); ?></option>
```

The above example has the case sensitive plan name in tha value option, and the display name within the PHP echo tag. Repeat for all allowed plans.