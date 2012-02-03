# University of Washington Wordpress Theme

## About

This theme is the updated UW Wordpress theme.
The goal is to keep all the new TwentyEleven features while maintaining a branded theme.

For the time being the master branch is under heavey development and could potentially be broken.
It is recommended to clone the repository and then checkout the latest tag.

## History

### 0.6.5 - CSS refactored
  - Only loading Community Photos widget CSS when the widget is in use
  - Replaced get_stylesheet_directory_uri with get_bloginfo('template_url')
    for child themes using this theme as a parent.

### 0.6.1 - CSS refactored
  - Using test data from wordpress.org to sort out minor bugs
  - Left widgets area
  - Paginated post navigation

### 0.6.0 - CSS refactored
  - Begin tagging releases
  - Fix issue #1 where nested comments were being hidden
  - Minor bug fixes to UI 

### 0.5.3 - Page Templates
  - Left navigation in header file for buddypress support

### 0.5.2 - Page Templates
  - Adding theme screenshot
  - Slight CSS modifications

### 0.5.1 - Page Templates
  - Bug fix: left navigation back in blog posts

### 0.5.0 - Page Templates
  - Page template for widgets on left side under navigation
  - Better handling of page transitions
  - Removed post transitions - will reimplement in the future

### 0.4.4 - Customizable Header
  - Buddypress compatibility

### 0.4.3 - Customizable Header
  - Bug fix: Blog title and description without banner image

### 0.4.2 - Customizable Header
  - Bug fix: line-heights for h1

### 0.4.1 - Customizable Header
  - Blog title and description now appear

### 0.4.0 - Finalized Navigation
  - Page generated and custom menus both functional
  - Added Community Photos widget
  - HTML5 transition between posts
  - Fixed bug that loaded style.css twice

### 0.3.0 - Convert to full theme
  - Theme is no longer a child theme for TwentyEleven
  - HTML5 navigation for compatible browsers
  - Featured images for posts and pages
  - Custom background image for site

### 0.2.0 - Initial branding
  - completed base css and javascript
  - widgets are functional
  - left navigation works for wp_page_menu fallback
  - 404 page
  - bug fixes

### 0.1.1 - Bug fixes with integration  
  - left navigation appearing on all pages  
  - images from parent theme migrated over to child theme  
  - made and adjusted local copy of twentyeleven css file  

### 0.1.0 - First build  
  - basic integration with twenty eleven  
  - index page and sub pages branded  
