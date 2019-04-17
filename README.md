[![Latest release](https://img.shields.io/github/release/creecros/MetaMagik.svg)](https://github.com/creecros/MetaMagik/releases)
[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/creecros/MetaMagik/blob/master/LICENSE)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://github.com/creecros/MetaMagik/graphs/contributors)
[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)]()
[![Downloads](https://img.shields.io/github/downloads/creecros/MetaMagik/total.svg)](https://github.com/creecros/MetaMagik/releases)

Donate to help keep this project maintained.
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SEGNEVQFXHXGW&source=url">
<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" /></a>

## :star: If you use it, you should star it on Github! 
- It's the least you can do for all the work put into it!

MetaMagik Kanboard Plugin
==========================

Forked from [Metadata Plugin](https://github.com/BlueTeck/kanboard_plugin_metadata) and added functionality ontop of previous plugin, **there is no need to use both plugins**

Added Features:
================

1. Customizable Fields for tasks. 
   - Textbox
   - Number
   - Dropdowns
   - CheckBoxes
   - Radios
   - User Lists
   - Lists from DB
   - Date (older browsers may not support the popup calendar)
2. A settings panel which allows you to create custom fields for tasks.
3. Fields will show up when creating/modifying tasks.
4. Custom fields added to task details.
5. Metadata is duplicated during task duplication.
6. Exporting tasks to CSV will include custom fields.
7. Filters for searching metadata.
8. Can now set the column for the field to appear in, and placement is setup through drag and drop placement

Original Features:
==================

1. Metadata Sidebars for tasks, projects, and users to add remove metadata. (from original fork, slight UI improvements involving tasks)


Plugin for https://github.com/fguillot/kanboard

Author
------

- [Craig Crosby](https://github.com/creecros) - Latest additions
- [BlueTeck](https://github.com/BlueTeck) - Original Fork: [Metadata Plugin](https://github.com/BlueTeck/kanboard_plugin_metadata)
- License MIT

Installation
------------

- Decompress the archive in the `plugins` folder

or

- Create a folder **plugins/MetaMagik**
- Copy all files under this directory


Usage
------------

Settings>Custom Fields: panel for creating custom fields for tasks

![image](https://user-images.githubusercontent.com/26339368/48794160-2187e000-ecc7-11e8-89de-c2c83bde5425.png)

Fields setup in Settings will appear in the task creation panel:

![image](https://user-images.githubusercontent.com/26339368/48794210-48dead00-ecc7-11e8-9731-2eb57ef8f226.png)

Metadata will appear under Task Details in an Accordian:

![image](https://user-images.githubusercontent.com/26339368/48794118-fe5d3080-ecc6-11e8-844b-af76a71d7249.png)

Metadata will also show up as a tooltip on the Board:

![image](https://user-images.githubusercontent.com/26339368/45580741-a4716200-b862-11e8-92ab-1cd8d4783273.png)

There is also a sidebar menu to add/remove/edit metadata, which is not dependent on the fields setup in your settings, adding fields here will not add metadata fields during creation or modification to a task, only those in the settings panel will show up. This sidebar will appear for tasks, users, and projects:

![image](https://user-images.githubusercontent.com/26339368/45580785-15187e80-b863-11e8-8c04-94e05dc2e7f8.png)

During Task Modification, your custom fields will be pre-populated with yout data:

![image](https://user-images.githubusercontent.com/26339368/45580810-5c067400-b863-11e8-8c27-1e040d4974f5.png)

Perform searches for metadata fields. `metakey:"field"`

![image](https://user-images.githubusercontent.com/26339368/45580859-08e0f100-b864-11e8-8d96-bcb682398681.png)

Perform searches for metadata values. `metaval:"value"`

![image](https://user-images.githubusercontent.com/26339368/45580850-e51dab00-b863-11e8-96e3-c8ff832e70a2.png)

Export to CSV will include your custom fields and data during Task Export

![image](https://user-images.githubusercontent.com/26339368/45769838-c2e2af00-bc0e-11e8-95b6-34c23876f03f.png)

![image](https://user-images.githubusercontent.com/26339368/45769796-af374880-bc0e-11e8-9587-83ab717da733.png)


Credits
------------

* Original Metadata Plugin author: [BlueTeck](https://github.com/BlueTeck)
* Additional Metadata Types and some organization for adding more types down the road: [Cortex](https://github.com/ncortex)
* Unused non working code in original code that greatly assisted in adding the settings panel: [Daniele Lenares](https://github.com/dnlnrs)
* Some guy who suckered me into writing this code, and provided the idea and desire: [Julien Buratto](https://github.com/TheCloud)




