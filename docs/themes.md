## Themes
VWI offers 5 preset themes for users to choose from:
* Default
* Orange
* Purple
* Blue
* Dark

You can set the default theme from the Admin Settings section, or from your MySQL database.
End-users can set a theme for the current login / session by accessing the profile / settings page.

You can create your own theme by setting the theme option to 'Custom' in the Admin Settings panel and selecting a primary and secondary color.
When enabling a custom theme, theme selection will be locked for non-admin users.

To create your own theme file, use a stylesheet from the `/css/colors` folder as a template and save the file under a custom name within the `/css/colors` folder once done.
To apply the custom theme, enter the name of the stylesheet without the ending '.css' as the 'theme' value in your MySQL database.


[Video Tutorial](https://www.youtube.com/watch?v=xCWJyRbRd8Q&list=PL4JkcC_rCsyf9ha5OBrWqDS4xWC3hZgfz)