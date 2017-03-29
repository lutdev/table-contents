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
[Laravel](https://laravel.com/) 5.1 or higher.
### Installation
1. You can install the package using the [composer](https://getcomposer.org/). 
```
"alutskevich/table-contents": "1.0.*"
```
Or install it by running this command in your project root:
```
composer require alutskevich/table-contents
```

2. Add the `Lutskevich\TOC\TableContentsServiceProvider` provider to the `providers` array in 
`config/app.php`:
```php
'providers' => [
  Lutskevich\TOC\TableContentsServiceProvider::class,
],
```
Then add the facade to your aliases array:
```php
'aliases' => [
  ...
  'TableContents' => Lutskevich\TOC\TableContentsServiceProvider::class,
],
```
### Usage
```php
//return string table contents
TableContents::arrayTableContents($text);
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
TableContents::setHeaderLinks($text)
```


### In the future
* configuration file with:
    * type of table contents: array|string. Array can be if it is strict headers nesting.
    * save all attributes of the headers. Now all attributes are clearing.
### Current version
*1.0.0*
## Feedback
Thank you! If you have proposition or find error/bug write me, please.
## License
MIT