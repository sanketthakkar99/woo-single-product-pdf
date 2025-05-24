# Woo Single Product PDF

Generate a downloadable PDF catalog directly from individual WooCommerce product pages.

---

## Description

**Woo Single Product PDF** is a simple yet powerful WordPress plugin that allows customers to download a PDF version of a product page in your WooCommerce store. This is useful for users who want to keep product details offline or share them more easily.

### Features

* Adds a customizable "Download Product PDF" button to product pages.
* Automatically generates a clean, printable PDF using DOMPDF.
* Simple shortcode-based integration: `[wspdf_download_button]`.
* Lightweight and easy to install.

---

## Installation

1. **Upload Plugin:**

   * Upload the plugin folder to the `/wp-content/plugins/` directory, or install it via the WordPress Plugin Directory.

2. **Activate Plugin:**

   * Activate the plugin through the **Plugins** menu in WordPress.

3. **Install Dependencies:**

   * Make sure the `dompdf/dompdf` library is available. You can run `composer install` if using the full package from source.

4. **Use Shortcode:**

   * Add `[wspdf_download_button]` to any single product page template or use a hook to insert it dynamically.

---

## Usage

To display the download button, add the shortcode:

```
[wspdf_download_button]
```

This will render a "Download Product PDF" button on product pages. When clicked, a PDF file of the current product page is generated and served for download.

---

## Developer Notes

* The plugin uses `template_redirect` to hook into page requests and generate the PDF.
* All logic is encapsulated in `includes/class-wspdf-generator.php`.
* Uses `dompdf` for PDF generation. Ensure it is installed and autoloaded via Composer.

---

## Screenshots

1. **PDF Download Button** – Visible on single product pages.
2. **Generated PDF Output** – A printable, branded product detail PDF.

---

## Frequently Asked Questions

### Does this work on all WooCommerce product pages?

Yes, the button only appears on single product pages and will generate the PDF for the product currently being viewed.

### Can I customize the PDF output?

Yes, by editing the `class-wspdf-generator.php` file and modifying the HTML/CSS used to build the PDF content.

---

## Changelog

### 1.0.0

* Initial release
* Adds PDF download button via shortcode
* Integrates DOMPDF for rendering

---

## License

This plugin is licensed under the GPL v2 or later.
