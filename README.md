# Magento 2 - Layout Hints (Enhanced)

![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/drew7721/module-templatehints)
![GitHub forks](https://img.shields.io/github/forks/drew7721/module-templatehints?style=social)

## Why?
Let's be honest, the default Magento 2 layout hints are very _bare_ (to stay polite). They lack much of the information
that is needed when we want to debug the layout.

This module made my like easier when it comes to altering the layout and templates of Magento 2 and I hope it will do
the same for you.

The goal is to show all blocks, containers and uiComponents on the page without breaking the page too badly. When the
mouse hovers any given element it will show more information for the current hovered element and its parents. The data
that is provided includes the name, alias, parent, template and class.

I've also added some nice frontend features to easily hide or show the hints that way it's easy to navigate the site
while the hints are ON. There are some additional features that bring some of the CLI actions to the frontend such as
enabling and disabling the hints from the frontend as well as clearing the caches directly from the browser.

This module will never make itself visible or have any effect in production mode, **it will only work in developer mode**.

<a href="https://i.imgur.com/VPea9TL.png"><img src="https://i.imgur.com/VPea9TL.png" width="350" height="250"/></a>
<a href="https://i.imgur.com/NhJhmco.png"><img src="https://i.imgur.com/NhJhmco.png" width="350" height="250"/></a>

## Features

 - [x] Enable and disable from **Frontend**, CLI or Admin panel
 - [x] Shows **blocks** and **containers**
 - [x] Displays the **name** and **alias** of the block or container.
 - [x] Lots of information on hover such as the block **class** and **template file**.
 - [x] **Clear all caches from the frontend**
 - [x] Non-intrusive display
 - [x] Layout information at the bottom of the page.

## Install

```
composer require justinkase/module-layouthints
magento setup:upgrade
magento cache:flush
```

## How to use this module
### Frontend
**Make sure you're in developer mode**

Visit your Magento 2 store in a browser and use the following keys combinations.

#### Shortcuts:
- `Shift + Ctrl + H` => Toggle hints visibility
- `Shift + Ctrl + =` => Turn ON hints (you must also clear caches)
- `Shift + Ctrl + -` => Turn OFF hints (you must also clear caches)
- `Shift + Ctrl + C` => Clear caches

You might get a request to approve browser notifications.

Make sure you're focused on the page, _click somewhere on the page with the mouse_, **but not a link**!

### CLI

```
justinkase:hints:on
justinkase:hints:off
magento cache:flush
```

### Admin Panel

`Stores > Configuration > Advanced > Developer > JustinKase - Layout Hints`

![](https://i.imgur.com/DUA9leh.png)

## Author
[Alex Ghiban](mailto:drew7721@gmail.com)

