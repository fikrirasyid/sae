## What
__Sae__ is gallery module for [Divi](https://www.elegantthemes.com/gallery/divi/) which uses [Low Quality Image Placeholders (LQIP)](https://cloudinary.com/blog/low_quality_image_placeholders_lqip_explained) approach to keep page rendering fast.

### What's with the name?
__Sae__ is Sundanese (local tribe of Indonesian) language  for `good` in polite form (Sundanese has different word for different level of formality and / or politeness)

I just need a decent and unique name for this project and I'm Sundanese, so that's it.

## Why
I recently gain more interest in photography which leads me to post tons of photo on [my personal blog](https://fikrirasyid.com) which uses Divi. I exhibit lots of photo per page and I want to display the photos on the highest quality possible (See [this "blogazine" look post](https://fikrirasyid.com/spain-trip-2018/) or [this post](https://fikrirasyid.com/japan-trip-2017/) for example); Unfortunately, it ends up making the page slower.

Hence this custom module.

## How
__Sae__ works with Low Quality Image Placeholder (LQIP) approach:

1. __Sae__ registers image sizes which tries to hit the sweet spot of enough for various breakpoint but not too much (see: `sae_image_sizes()`; __Sae__ registers 6 new image size to cater mobile to desktop retina display). Note: this might cause your upload directory size significantly bigger. If you have very limited size of storage, this might not be for you
2. When the image is set for the gallery, on front end, __Sae__ will swap the assigned image with placeholder image of given image which has 150px width size
3. On front end page load, this 150px width size is the one that is being loaded on page load which makes the document render quick. Once the document render is done, __Sae__ examine the width of the module then load the most suitable image size and display the suitable image size instead.

Currently, __Sae__ offers two kind of gallery layout: list of image / masonry. The Masonry layout use pure CSS solution based on CSS Column property.

## Who
__Sae__ is currently developed by [Fikri Rasyid](http://fikrirasy.id/).

***

## Notes
- __Sae__'s repository is publicly available at https://github.com/fikrirasyid/sae
- __Sae__ is developed using [Divi's create-divi-extension](https://github.com/elegantthemes/create-divi-extension) and compatible with Divi Visual Builder
- __Sae__ is licensed under GPL
- There is a plan for more gallery layout(s) and more modules, but I keep my expectation reasonable since I develop __Sae__ on my spare time.