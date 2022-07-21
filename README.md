# WordPress Setup

A package to help with getting WordPress configured and populated with content, so that it's a known testable or dev-able state.

## How to use

Install with Composer:

```
composer require-dev dxw/wordpress-setup
```

Call the Factory to get a new Setup instance, e.g.:

```
$setup = Dxw\WordPressSetup\Factory::create();
```

Then call specific modules as properties of setup, e.g to create a post:

```
$setup->post->create();
```

Or to create a menu and assign it to a menu location in your theme:

```
$setup->menu->createAndAssignLocation('menu-name', 'menu-location');
```

Modules and their available methods are documented in detail below.

## Modules

### Media

#### `upload`

Upload a file to the media library, and create the appropriate attachment metadata.

Takes either a path to the file, or a URL:

```
$setup->media->upload(string $pathOrUrlToFile);
```

Returns the ID of the created attachment.

### Menu

#### `addCustomLink`

Add a custom link item to a menu, where the first argument is the ID of the menu to assign it to:

```
$setup->menu->addCustomLink(int $menuId, string $menuItemTitle, string $menuItemUrl);
```

Can also be passed the ID of the menu item this should be a child of as the final argument:

```
$setup->menu->addCustomLink(int $menuId, string $menuItemTitle, string $menuItemUrl, int $parentMenuItemId);
```

Returns the ID of the menu item that has been created.

#### `addTaxonomyLink`

Add a taxonomy archive link to a menu.

```
$setup->menu->addTaxonomyLink(int $menuId, int $termid, int $taxonomyName)
```

Can also optionally be passed the ID of the menu item this should be a child of:

```
$setup->menu->addTaxonomyLink(int $menuId, int $termid, int $taxonomyName, int $parentMenuItemId)
```

Returns the ID of the menu item that has been created.


#### `createAndAssignLocation`

Create a new menu and assign it to a theme location by name:

```
$setup->menu->createAndAssignLocation(string $menuName, string $menuLocation);
```

Returns the ID of the new menu.

### Post

#### `create`

Create a new post:

```
$setup->post->create();
```

By default, Faker will be used to generate dummy title and content, the post type will be `post` and the post status will be `publish`.

You can override any of these defaults (or add additional parameters) using the same array of args you would pass to `wp_insert_post`.

Returns the ID of the new post.
