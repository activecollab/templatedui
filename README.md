# Templated UI

Experimental library for building interfaces using templates, on the backend.

## Basic Elements

Templated UI builds on top of Smarty syntax and provides a more convenient way to extend it. Unlike recommended way to build extensions, as functions, Templated UI extensions are built as classes with following goals in mind:

1. **Composability** - Use all the PHP's object features to compose your extensions: inheritance, interfaces, traits, encapsulation etc,
2. **Strict Types** - Use PHP's type system to ensure that your extensions are used correctly, with centralized type checking,
3. **Dependency Injection Ready** - Provide all dependencies as constructor arguments,
4. **Easy to Test, and Refactor** - Use standard refactorings and testing tools to work with your extensions.

There are three types of extensions that Templated UI provides out of the box:

1. **Tags** - Similar to function calls, or HTML's self-closing elements, they have a name, and accept any number of arguments,
2. **Blocks** - Blocks are similar to tags, but they can have content, and they can be nested,
3. **Modifiers** - Modifiers are used to modify the output of variables. For example, you can output dates in different formats, or escape HTML.

Tags are commonly used as functions, that receive a number of arguments, and output some HTML. We can define a tag by extending `Tag` class:

```php
<?php

declare(strict_types=1);

namespace MyApp;

use ActiveCollab\TemplatedUI\Helper\HtmlHelpersTrait;
use ActiveCollab\TemplatedUI\Tag\Tag;

class TagName extends Tag
{
    use HtmlHelpersTrait;

    public function render(
        string $arg1, 
        array $arg2, 
        bool $arg3 = true,
    ): string
    {
        if ($arg3) {
            return '<div>' . $this->sanitizeForHtml($arg1) . '</div>';
        }
    
        return sprintf('<div>There are %d elements in the second argument.</div>', count($arg2));
    }
}
```

This tag then can be used in templates like this:

```smarty
{TagName arg1="value" arg2=$someArray}
```
There are several things to note here:

1. Tag's class name, without the namespace and `Tag` suffix, is used as a tag name,
2. Valid tags need to implement `render()` method. It is not part of any base interface, so you can have any set of arguments you want,
3. Arguments with default value can be omitted in templates. On the other hand, arguments that don't have the default value need to be specified,
4. Argument values will be checked against type hints. Rendering will be rejected if there are missing arguments, of it here is type mismatch.

## Built-in Tags

* AssetUrl
* ScriptUrl
* StyleUrl
* Template
* Url

## Built-in Blocks

None so far.

## Built-in Modifiers

* Clean
* Export
* FormatDate
* FormatPercent
* FormatTime
* ImplodeNames
* Json
