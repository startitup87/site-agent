# WP Site Agent

## What is this?
WP Site Agent is a WordPress plugin that helps you build, test, and launch WordPress websites easily. It can also suggest and install plugins based on the type of website you want to make.

## Features
- Create, test, and deploy WordPress sites with one click
- Reads your preferences from a simple file (`context.json`)
- Recommends and can install the best plugins for your site type (like blog, store, or AI coach)
- Easy to use, even for beginners
- Includes tests to make sure everything works

## How does it work?
- You install the plugin on your WordPress site.
- In the WordPress admin area, you’ll see a new menu called "Site Agent."
- You can create, test, and deploy a site with the click of a button.
- The plugin reads a file called `context.json` to understand what kind of site you want (like a blog, store, or AI coach site).
- Based on your choices, it recommends and can install the best plugins for your site.

## What is `context.json`?
This file tells the plugin what kind of site you want. Here are some fields you can fill in:
- `niche`: The main topic or industry (like "blog", "ecommerce", or "ai coach")
- `site_type`: Another way to describe your site (can be the same as niche)
- `tone`, `colors`, `approved_pages`, etc.: Extra details to help customize your site

Example:
```json
{
  "niche": "blog",
  "site_type": "",
  "tone": "friendly",
  "colors": ["blue", "white"],
  "approved_pages": ["Home", "About", "Contact"]
}
```

## What files are important?
- `wp-site-agent.php`: Starts the plugin.
- `includes/class-wp-site-agent-core.php`: Handles the admin menu and page.
- `includes/class-wp-site-agent-site-builder.php`: Does the main work (site creation, plugin suggestions, etc).
- `includes/context.json`: Stores your site’s settings and preferences.
- `tests/test-wp-site-agent-site-builder.php`: Tests to make sure everything works.

## How do I use it?
1. Put the plugin files in your WordPress `wp-content/plugins` folder.
2. Activate the plugin in your WordPress admin.
3. Go to the "Site Agent" menu.
4. Click the buttons to create, test, or deploy your site.
5. To get plugin suggestions, fill out `context.json` with your site’s type or niche (like "blog" or "ecommerce").
6. The plugin will recommend and can install plugins for you. (You need to be connected to the internet and have permission to install plugins.)

## How do I run the tests?
1. Make sure you have [PHPUnit](https://phpunit.de/) installed.
2. In your terminal, run:
   ```bash
   phpunit tests/test-wp-site-agent-site-builder.php
   ```
   This will check if the main features work as expected.

## Troubleshooting
- If plugin installation fails, make sure your WordPress site can connect to the internet and your user has permission to install plugins.
- If you see errors, check that your `context.json` is filled out correctly.
- For more help, look at the code comments or ask someone who knows WordPress.

## Who is this for?
Anyone who wants to quickly set up a WordPress site with the right plugins, even if you’re not a tech expert. The instructions are simple enough for an 8th grader to follow!

## Contributing
If you want to help make this plugin better, you can suggest changes or add new features. Just make sure to test your changes!

## Need help?
If you get stuck, check the code comments or ask someone who knows WordPress for help.