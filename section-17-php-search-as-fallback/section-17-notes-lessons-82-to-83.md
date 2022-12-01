# Section 17: NON-JS Fallback Traditional Search

## Using PHP to power a backup search when Users JS is disabled

### Lesson 82: Setting Up Alternate View To Display PHP powered Search

Display the results from our new CUSTOM API in section 15.


[Lesson 82 in Section 17](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007374#overview).


SECURITY BEST PRACTICE: PRO TIP: use _Escape URL_**esc_url()**

This is to protect the visitors of your site IF your site has already been hacked. 

In this case, we used Escape URL when we loaded a URL directly from our databse with **site_url()**

```

<form action="<?php echo esc_url(site_url('/')) ?>">

```