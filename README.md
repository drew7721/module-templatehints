#Better Layout Hints
Simple Magento 2 module to show better layout hints.

### Why?
The default layout hints in M2 are horrible! They don't give enough information
about the block, its name and the template file that is used.

### How to use it?
You can enable the hints from the console or the admin panel.

####Console commands:
```
justinkase:hints:on
justinkase:hints:off
```
So to enable the hints simply run `magento justinkase:hints:on` and you
should probably run a `magento cache:flush` command if your caches are enabled.

####Admin panel
Check out the **Developer** section of the admin panel and you can enable it from
there. `Advanced > Developer > JustinKase`

## Author
[Alex Ghiban](mailto:drew7721@gmail.com)
