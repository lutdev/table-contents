[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)
[![GitHub version](https://badge.fury.io/gh/lutdev%2Ftable-contents.svg)](https://badge.fury.io/gh/lutdev%2Ftable-contents)

## About
Package for generating table of contents for the text.

For example, you have next text:
```html
<h1>Header first level</h1>
Some text here
<h2>Header second level</h2>
Some text here
<h4>Header fourth level</h4>
Some text here
<h3>Header third level</h3>
Some text here
```
Table of contents will be:
```
 - Header first level
    - Header second level
            - Header fourth level
         - Header third level
```

Table of contents support how strict headers nesting and free nesting, i.e. it can be: 
1-2-4-3-6-2-4-1-3-7 or 1-2-3-2-4-1-2-3-4-3-5-2-3.

Table of contents work with only `<h*>` tags 1-10 levels (`h1` - `h10`). 
## Getting Started
### Requirements
PHP 7.1
### Installation
1. You can install the package using the [composer](https://getcomposer.org/). 
```
"lutdev/table-contents": "^2.1"
```
Or install it by running this command in your project root:
```
composer require lutdev/table-contents
```

2. PHP class 
```php
use Lutdev\TOC\TableContents
```
or you can download package and include it via ```require```
### Usage
```php
//return string table contents
TableContents::tableContents($text);
```

Table of contents have next structure:
```php
"0": {
    "title": "Title",
    "link": "link"
},
"1": {
    "title": "Title",
    "link": "link"
},
"2": {
    "title": "Title",
    "link": "link"
    "subItems": {
        "3": {
            "title": "Title",
            "link": "link"
            "subItems": {
                "1": {
                    "subItems": {
                        "2": {
                            "subItems": {
                                "4": {
                                    "title": "Title",
                                    "link": "link"
                                },
                            }
                        }
                    }
                }
            }
        }
    }
}
```
* **Keys** (0,1,2,3,4) - header index number. **Keys** (1,2 subItems) - intermediate empty headers;
* **title** - title of the content item;
* **link** - anchor link. If text have few same headers links of them will be 
`<link>-<number>` (for example: link-1, link-2, link-3).

```php
//Add ID attribute to the headers. Need for anchors.
TableContents::headerLinks($text)
```

## Feedback
Thank you! If you have proposition or find error/bug write me, please.
## License
MIT