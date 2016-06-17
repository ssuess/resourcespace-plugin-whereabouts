# whereabouts 
**A ResourceSpace plugin for tracking item location and history**

This plugin allows entry of date, who to, notes, location (with maps) for any resource. It will keep a history table of prior dates and display them on the view and edit pages.


## Installation Part I
Download the whole diretory and rename to "whereabouts". Then you can install it one of two ways:

1. Upload as rsp file
	* tar.gz it and change the extenstion to ".rsp"
	* upload the rsp file from the plugin config screen in ResourceSpace admin
	* activate the plugin
2. Upload folder to the plugins directory
	* activate the plugin from the plugin config screen in ResourceSpace admin
	
## Installation Part II: VERY IMPORTANT
*Only worry about the following IF your RS version is prior to SVN r8394 (which comes after 7.8 version released 6/17/16):*

Because this plugin relies on a hook that is not in Resourcespace prior to r8394, you will probably need to add this hook in the /pages/edit.php page. 
Find the code that looks like this:

```
<!-- end of question_copyfrom -->
 <?php
} ?>
```	
Then add the hook `hook('addcollapsiblesection');` just after so it will all look like this when you are done:

```
<!-- end of question_copyfrom -->
 <?php
} ?><?php hook('addcollapsiblesection'); //whereabouts plugin hook ?>
```


## Configuration Options

- Resource Types to exclude (pick from list). This will exclude whereabouts functionality from those types of resources.
- Use Datepicker. If set to true, datepicker will allow date of entry to be set. If set to false, datetime stamp is automatic.
- Show maps. If set to true, map will show on rollover of location link. (requires Google Static Maps API key, available [here] (https://developers.google.com/maps/documentation/static-maps/)).
- Show maps on all location links. (by default only pulls map on first link to reduce API usage)
- Maps zoom level. If showing maps, set zoom level (default 11)
- Predefined list for who to column. If set to true, enter a comma separated list in the field below to populate your dropdown of choices. 
- Column headings can all be changed in the config.php file

## Changelog
* `v 1.0` - Initial Release

### Other
* Thanks to Tom Gleason, whose annotate plugin was invaluable for getting this started.
