# BEM Library

[![Build Status](https://img.shields.io/travis/widoz/bem/develop.svg?style=flat-square)](https://travis-ci.org/widoz/bem)
[![codecov](https://img.shields.io/codecov/c/github/widoz/bem/develop.svg?style=flat-square)](https://codecov.io/gh/widoz/bem)

Bem is a library that allow you to define BEM style class attribute values to use in your markup.

Let for example you want to include a class attribute value into your html tag.
You can do it by using the library.

```html
<div class="<?php echo $bem->value() ?>">
    <!-- your content here -->
</div>
```

The library works with WordPress but also as a standalone library to use in your projects.

If you use it into your WordPress project you can take advantage of the `bem` filter allowing you
to manipulate the bem string depending on your needs.

It's is possible to retrieve the entire class value such as the block, element and modifiers singularly.

Since Version 1.0.0 the string values are no longer sanitized, so you have to use a function like `sanitize_html_class`.
The classes now only check against the value passed in construction phase.

## Requirements

PHP >= 7.0.0

## What is BEM

BEM — Block Element Modifier is a methodology that helps you to create reusable components and code sharing in front-end development.

<dl>
	<dt>Block</dt>
	<dd>Encapsulates a standalone entity that is meaningful on its own. While blocks can be nested and interact with each other, semantically they remain equal; there is no precedence or hierarchy. Holistic entities without DOM representation (such as controllers or models) can be blocks as well.</dd>
	<dt>Element</dt>
	<dd>Parts of a block and have no standalone meaning. Any element is semantically tied to its block.</dd>
	<dt>Modifier</dt>
	<dd>Flags on blocks or elements. Use them to change appearance, behavior or state.</dd>
</dl>

Example

```css
.block__element {}

.block block--modifier {}
```

For more information have a look at: [getbem](http://getbem.com/)

## How it works

To use the bem value you must create a instance of a class that implements `Valuable` interface such as `Standard` or `Namespaced` then 
call `value` method.

Since version 1.0.0 isn't possible to retrieve the bem's components separately, this is because the 
responsibility to hold data has been moved under a different class that implements `Bem` interface.

Also, the `modifiers` are no longer an array but an instance of a class that implements `Modifiable`.
The class used to hold modifiers is `BlockModifier`.

```php
$bem = new Data('block');
$standard = new Standard($bem);
$standard->value(); // will print 'block'

$bem = new Data('block', 'element');
$standard = new Standard($bem);
$standard->value(); // will print 'block__element'

$modifiers = new BlockModifiers(['modifier'], 'block');
$bem = new Data('block', 'element', $modifiers);
$standard = new Standard($bem);
$standard->value(); // will print 'block block--modifier'
```

The *Namespace* bem value is a decorator for the *Standard* one that get an additional parameter
in the `__construct` method to set the namespace for your block classes.

```php
$bem = new Data('block');
$standard = new Standard($bem);
$namspaced = new Namespaced($standard, 'namespace');

$namespaced->value(); // will output 'namespaceblock'
``` 

## Factory
To create a bem as you seen above isn't much complex but isn't simple as doing it in one line of code
(if you want to keep your code readable). For that reason you make use of a simple `Factory` class
that allow you to create all of the Bem classes you want just in one line of code by passing only
the necessary data.

```php
$standardBem = Factory::createStandard('block', 'element', ['modifier']);
// Or
$namespacedBem = Factory::createWithNamespace('namespace', 'block', 'element', ['modifier']);
```

Then you can use the object as usual, by calling the method `value`.

**Note:**
Even though it's possible to pass all of the parameters to the class that implements `Bem` interface, 
when both *block* and *modifiers* are passed the *element* is ignored.

This is right and in line with the BEM requirements. Infact isn't possible to have a BEM string like `block block--modifier__element`.

### Add more than one modifier

It's possible to pass more than one modifier to `BlockModifier` infact the `__construct` method
get an array of strings.

So for example, the following code will output `block block--modifier-one block--modifier-two`.

```php
$modifiers = new BlockModifiers(['modifier', 'modifier-two'], 'block');
$bem = new Data('block', 'element', $modifiers);
$standard = new Standard($bem);
$standard->value(); // will print 'block block--modifier block--modifier-two'
```

Since version 1.0.0 there are additional checks to the *block*, *element* and *modifier* values to ensure
a valid string is passed during construction. The check is made against the pattern `[^a-zA-Z0-9\-\_]`.

### Retrieve properties.

Since version 1.0.0 it's no longer possible to retrieve the bem components from the `Valuable` instance,
you have to use `Data` instance if you want to get them.

## Bugs

To report a bug simply open an [issue on github project](https://github.com/widoz/bem/issues)

## License

Since version 1.0.0 the license is MIT and no longer GPL-1.0.0

For more info read the `LICENSE` file
