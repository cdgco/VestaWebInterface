## Registrations Configuration

Once enabling registrations from the VWI configuration, you must edit the register.php file and change the allowed plans for registration.

Within the register.php file on line 136, list the allowed plans within HTML 'option' tags.

Example:

```html
<option value="default"><?php echo _('Default'); ?></option>
```

The above example has the case sensitive plan name in the value option, and the display name within the PHP echo tag. Repeat for all allowed plans.


[Video Tutorial](https://www.youtube.com/watch?v=0_bLwiVII_o&list=PL4JkcC_rCsyf9ha5OBrWqDS4xWC3hZgfz)