Calland — Responsive Images
============================

Just wanted to experiment with a seamless approach to responsive images. Which is to say “the src points to the image as usual, and all the magic happens behind the scenes.”

So, the basic idea is that the .htaccess file intercepts the request for the image file and forwards the path along to img.php, which potentially generates a smaller version of the image depending on the screen size set in the ‘rwd-viewport’ cookie. As this is set in the document’s head, it’s available to scripts invoked in the document’s body on initial load.

Said cookie is set to the greater of the device’s height or width, allowing for full-bleed images regardless of device orientation.

## What I Don't Like

* There's nothing going on (yet) in the way of caching the generated images.
* The lack of control. One doesn’t always need potentially screen-width images, so I want to introduce some way of controlling this on a image-specific level.
* Everything hinges on cookies and JS being enabled. Again, I’m just messing around with this, and haven’t come up with anything in the way of a plan-B—I wouldn’t use this for any production sites yet.

## What I Do Like

* The name is kind of clever, right? Eh, eh?