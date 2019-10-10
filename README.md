# Better Layout Hints
Simple Magento 2 module to show better layout hints.

## Why?
The default layout hints in M2 are horrible! They don't give enough information
about the block. There is no information about the containers or the
ui elements that are rendered.

This is built to show more information about what is on the page and how it's rendered.

## Screenshot
![](https://i.imgur.com/EUpbP50.png)

## How to use it?
You can enable the hints from the console or the admin panel.

### Console commands:
```
justinkase:hints:on
justinkase:hints:off
```
So to enable the hints simply run `magento justinkase:hints:on` and you
should probably run a `magento cache:flush` command if your caches are enabled.

![](https://i.imgur.com/C4l3SMf.png)

### Admin panel
Update the setting from the admin panel. 

`Stores > Configuration > JustinKase > Layout Hints` 
![](https://i.imgur.com/j4vgKKk.png)

## Author
[Alex Ghiban](mailto:drew7721@gmail.com)
