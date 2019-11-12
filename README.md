# Wordpress Gogodigital Example
Wordpress Plugin Example

## Copy folder with git from Terminal

Go to folder wp-content/plugins/

```
git clone https://github.com/cinghie/wordpress-gogo-example.git gogodigital-example
```

## Implement your plugin

### 1. Rename information

Edit plugin information in gogodigital-example.php

```
/**
 * Plugin Name: Gogodigital Example
 * Description: Example Plugin for Wordpress
 * Author: Gogodigital S.r.l.s.
 * Author URI: https://www.gogodigital.it
 * Version: 1.0.0
 * Text Domain: gogodigital-example
 **/
 ```
 
### 2. Set default params
 
Set at line 23 in gogodigital-example.php

 - Menu Slug 
 - Menu Title
 - Page Title
 
and at line 58 change gogodigital-example-plugin with Menu Slug 

### 3. Set form input

 - Register settings at line 30 in gogodigital-example.php
 - Update settings at __construct and add_plugin_page in WPGogodigitalExample
 
### 4. Update languages

 - Change text-domain 'gogodigital-example' in all files
 - Change words in all files
 
## Resources

https://developer.wordpress.org/plugins/settings/custom-settings-page/  
https://code.tutsplus.com/tutorials/the-wordpress-settings-api-part-4-on-theme-options--wp-24902  
https://code.tutsplus.com/tutorials/the-wordpress-settings-api-part-5-tabbed-navigation-for-settings--wp-24971  
